<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;

class UserOtpController extends Controller
{
    public function verifyOtp (Request $request) {
        $request-> validate([
            'email'=>'required|email',
            'otp'=>'required|string'
        ]);
        $user=User::where('email',$request->email)->first();

        if(!$user){
            return response()->json(['message'=>'User not found'],404);
        }

        $otpEntry=UserOtp::where ('user_id',$user->id)
        ->where('otp_code',$request->otp)
        ->first();
       
        if(!$otpEntry || $otpEntry->isExpired()){
            return response()->json(['message'=>'Invalid or expired OTP'],400);
        }
        $otpEntry->delete();
        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'message'=>'Login successful',
            'token'=>$token,
            'user'=>$user
        ],201);
    }

}
