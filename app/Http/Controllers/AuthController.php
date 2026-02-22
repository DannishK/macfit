<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
           'name'=>'required|string',
           'email'=>'required|email|unique:users,email', 
           'password'=>'required|string|min:4|max:15',
           'user_image'=>'nullable|image|mimes:jpeg,png,jpg,gif',
           
            
        ]);

         $role = Role::where('name', 'user')->first();

if (!$role) {
    return response()->json([
        'message' => 'Default user role not found'
    ], 500);
}
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role_id = $role->id;

        if($request->hasFile('user_image')) {
            $filename = $request->file('user_image')->store('users','public');
            
        }else{
            $filename = null;
        }
        $user->user_image = $filename;


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
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($validated['password'],$user->password))
            throw ValidationException::withMessages(['Invalid credentials'], 401);
            
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token'=>$token,
            'message'=>'Login successful',
            'user'=>$user,
            'abilities'=>$user->abilities(),
        ],201);
        }
        public function logout(Request $request){
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message'=>'Logged out successfully']);
        }
        
    }

