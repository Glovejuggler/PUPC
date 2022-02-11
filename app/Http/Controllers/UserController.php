<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\MainController;


class UserController extends Controller
{
    public function index(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $numberOfUsers = User::count();
        $numberOfFiles = File::count();
        $filecount = File::wherehas('user', function(Builder $query){
            $user = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
            $query->where('role','=',$user['LoggedUserInfo']->role);
        })->count();
        return view('index', compact('numberOfUsers', 'numberOfFiles','filecount'), $data);
    }

    public function users(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $users = User::all();
        $roles = Role::all();
        
        return view('userslist', compact('users', 'roles'), $data);
    }

    public function show(User $user){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $user = User::findorfail($user->id);
        $files = File::where('uploader_id','=',$user->id)->get();
        $viewable = [
            'pdf',
            'jpg',
            'png',
            'txt',
        ];

        return view('show', compact('user','files','viewable'), $data);
    }

    public function create(Request $request){
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'role' => 'required',
            'password' => 'required|min:8|max:20',
        ]);

        $user = new User;

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->middle_name = $request->middle_name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);


        $user->save();

        return Redirect('users');
    }

    public function delete(User $user){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $user->delete();

        return Redirect('users');
    }

    public function edit(User $user){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];

        $user = User::findOrFail($user->id);
        $roles = Role::all();
        return view('edit', compact('user','roles'), $data);
    }

    public function update(Request $request, User $user){
        // $this->validate($request, [
        //     'password' => 'sometimes|required|string|min:8|max:20',
        // ]);

        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $userInfo = User::findOrFail($user->id);

        $userInfo->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'role' => $request->role,
            'email' => $request->email,
            'address' => $request->address,
            'password' => $request->password == NULL ? $userInfo->password : Hash::make($request->password),
        ]
            // $request->all()            
        );
        return redirect()->route('user.show', $user->id);
    }

    // User's Own Profile Functions
    public function myProfile(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $files = File::where('uploader_id','=',$data['LoggedUserInfo']->id)->get();
        $viewable = [
            'pdf',
            'jpg',
            'png',
            'txt',
        ];

        return view('myProfile', compact('files','viewable'), $data);
    }

    public function editmyprofile(User $user){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];

        $user = User::findorfail($data['LoggedUserInfo']->id);
        $roles = Role::all();
        return view('editmyprofile', compact('user','roles'), $data);
    }

    public function updateme(Request $request){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $userInfo = User::findorfail($data['LoggedUserInfo']->id);

        $userInfo->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'role' => $userInfo->role,
            'email' => $request->email,
            'address' => $request->address,
        ]
            // $request->all()            
        );
        return redirect()->route('user.index');
    }

    public function changepass(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $userInfo = User::findorfail($data['LoggedUserInfo']->id);

        return view('changepassword', compact('userInfo'), $data);
    }

    public function updatepassword(Request $request, User $user){
        $this->validate($request, [
            'oldPassword' => 'required|min:8|max:20',
            'newPassword' => 'required|min:8|max:20',
            'confirmPassword' => 'required|min:8|max:20',
        ]);

        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $user = User::findorfail($data['LoggedUserInfo']->id);


        if(Hash::check($request->oldPassword, $user->password)){
            if($request->newPassword == $request->confirmPassword){
                $user->update([
                    $user->password = Hash::make($request->confirmPassword)
                ]);
            } else {
                return back()->withErrors([
                    'confirmPassword' => ['Password do not match']
                ]);
            }
        } else {
            return back()->withErrors([
                'oldPassword' => ['Incorrect password']
            ]);
        }
        return redirect()->route('user.index')->with('changed', 'Password changed');
    }
}
