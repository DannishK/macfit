<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Role;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validated = $request->validate([
        'name'=>'required|string',
        'email'=>'required|email|unique:users,email', 
        'password'=>'required|string|min:4|max:15',
        'user_image'=>'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Default role logic
    if ($request->role_id) {
        $role_id = $request->role_id;
    } else {
        $role = Role::where('name', 'user')->first();

        if (!$role) {
            return response()->json([
                'message' => 'Default user role not found'
            ], 500);
        }

        $role_id = $role->id;
    }

    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->role_id = $role_id;

    if ($request->hasFile('user_image')) {
        $filename = $request->file('user_image')->store('users','public');
        $user->user_image = $filename;
    }

    try {
        $user->save();

        // Generate signed verification link
        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email)
            ]
        );

        // Send email
        $user->notify(new VerifyEmailNotification($signedUrl));

        return response()->json([
            'message'=>'User registered successfully. Please check your email to verify your account.',
            'user'=>$user
        ], 201);

    } catch(\Exception $exception) {
        return response()->json([
            'error'=>'Failed to register user',
            'message'=>$exception->getMessage()
        ], 500);
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

        if (!$user->is_active){
            return response()->json([
                'message'=>'Your account is not Active. Please verify your Emali Address.'
            ],403);
        }
            
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

