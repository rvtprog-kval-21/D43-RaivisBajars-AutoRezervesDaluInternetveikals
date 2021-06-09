<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => ['required'],
            'surename' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        User::create([
            'name' => $request->name,
            'surename' => $request->surename,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Dotie paramatri bija nepareizi.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());
 
        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}
