<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function createUsers(Request $request){
        $validated = $request->validate([
            'name' =>'required|string',
            'email' =>'required|string',
            'password' =>'required|string', ]);

             $user = new User();
             $user->name = $validated['name'];
             $user->email = $validated['email'];
             $user->password = bcrypt($validated['password']);
             
             try{
                $user->save();
                return response()->json($user);
             }
             catch(\Exception $exception){
                return response()->json([
                'error' => 'Failed to Save Users',
                'message'=>$exception->getMessage()
                ], 500);

             }

 }
 public function readAllUsers(){
    try{
        $users = User::all();
        return response()->json($users);
     }
     catch(\Exception $exception){
        return response()->json([
            'error' => 'Failed to fetch Users.',
            'message' => $exception->getMessage()
        ], 500);
     }
 }
 public function readUsers($id){
    try{
        $user = User::findOrFail($id);
        return response()->json($user);

    }
    catch(\Exception $exception){
        return response()->json([
            'error' => 'Failed to fetch Users.',
            'message' => $exception->getMessage()
        ]);
      }
   }
   public function updateUsers(Request $request,$id){
     $validated = $request->validate([
            'name' =>'required|string',
            'email' =>'required|string',
            'password' =>'required|string',
            ]);

    try{
        $user = User::findOrFail($id);
        $user->name = $validated['name'];
             $user->email = $validated['email'];
             $user->password = bcrypt($validated['password']);
             $user->save();
        return response()->json($user);
         }
         catch(\Exception $exception){
                return response()->json([
                'error' => 'Failed to Save Users',
                'message'=>$exception->getMessage()
                ], 500);
   }
}
public function deleteUsers($id){
    try{
        $user = User::findOrFail($id);
        $user->delete();
        return response("Users deleted successfully!");
    }
    catch(\Exception $exception){
        return response()->json([
            'error' => 'Failed to delete Users.',
            'message' => $exception->getMessage()
        ], 500);
    }
}
}
