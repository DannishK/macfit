<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
           'name'=>'required|string',
           'email'=>'required|email|unique:users,email', 
           'password'=>'required|string|min:4|max:15',
            
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        
        
        try{
            $user->save();
            return response()->json($user);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to register user',
                'message'=>$exception->getMessage()]);
        }
        }

        public function login(Request $request){
        $validated = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string|min:4',
        ]);
        $user = User::where('email',$validated['email'])->first();

        if(!$user || !Hash::check($validated['password'],$user->password))
            throw ValidationException::withMessages(['Invalid credentials'], 401);
            
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token'=>$token,
            'message'=>'Login successful',
            'user'=>$user
        ],201);
        }
        
    }

