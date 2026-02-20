<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gym;

class GymController extends Controller
{
    public function createGym(Request $request){

    $validated = $request->validate([
        'name'=>'required|string',
        'description'=>'string|max:1000',
        'longitude'=>'required|string',
        'latitude'=>'required|string',
    ]);

    $gym = new gym();
    $gym->name = $validated['name'];
    $gym->description = $validated['description'];
    $gym->longitude = $validated['longitude'];
    $gym->latitude = $validated['latitude'];

    try{
        $gym->save();
        return response()->json($gym);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to save gym',
            'message'=>$exception->getMessage()],500);
    }
}
public function readAllGyms(){
    try{
        $gyms = Gym::all();
        return response()->json($gyms);
        
    }
    catch(\Exception $exception){
        return response()->json([
     'error'=>'Failed to fetch gyms',
        'message'=>$exception->getMessage()
        ],500);
    }
    
 }
 public function readGym($id){
    try{
        $gym = Gym::findOrFail($id);
        return response()->json($gym);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to fetch gym with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function updateGym(Request $request,$id){
   $validated = $request->validate([
        'name'=>'required|string',
        'description'=>'string|max:1000',
        'longitude'=>'required|string',
        'latitude'=>'required|string',
    ]);
    try {
        $gym = Gym::findorfail($id);
        $gym->name = $validated['name'];
        $gym->description = $validated['description'];
        $gym->longitude = $validated['longitude'];
        $gym->latitude = $validated['latitude'];
        $gym->save();
        return response()->json($gym);

        
    }
     catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to update gym with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function deleteGym($id){
    try{
        $gym = Gym::findOrFail($id);
        $gym->delete();
        return response('Gym deleted successfully');
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to delete gym with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
}
