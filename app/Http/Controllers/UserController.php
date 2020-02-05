<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        return response()->json([
            'logged'=>true,
            'name'=>$user->name,
            'email'=>$user->email,
            'id'=>$user->id,
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $auth = Auth::attempt(['email' => $request->email, 'password' => ($request->password)]);

        if(!$auth){
            return response()->json([
                'logged'=>false,
            ]);
        }
        return response()->json([
            'logged'=>true,
        ]);
    }

    public function logOut()
    {
        Auth::logout();
        return response()->json('logout');
    }

}
