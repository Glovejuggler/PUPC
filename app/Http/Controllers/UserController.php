<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MainController;


class UserController extends Controller
{
    public function index(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $numberOfUsers = User::count();
        $numberOfFiles = File::count();
        $filecount = File::where('uploader_id','=', session('LoggedUser'))->count();
        return view('index', compact('numberOfUsers', 'numberOfFiles', 'filecount'), $data);
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

        return view('show', compact('user','files'), $data);
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
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $userInfo = User::findOrFail($user->id);
        $userInfo->update(
            $request->all()
        );
        return redirect()->route('user.show', $user->id);
    }
}
