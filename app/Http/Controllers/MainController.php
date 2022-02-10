<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function login(){
        return view('logintry');
    }

    public function loginCheck(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8|max:20'
        ]);

        $userInfo = User::where('email','=',$request->email)->first();
        // return $request->input();

        if(!$userInfo){
            return back()->with('fail', 'We do not recognize this email address');
        }else{
            // check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                return redirect()->route('user.index');
            }else{
                return back()->with('fail', 'Incorrect password');
            }
        }
    }

    public function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect()->route('login');
        }
    }
}
