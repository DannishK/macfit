<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundle;

class BundleController extends Controller
{
    public function createBundle(Request $request){

    $validated = $request->validate([
        'name'=>'required|string|unique:bundles,name',
        'description'=>'nullable|string|max:1000',
        'duration'=>'required',
        'category_id'=>'integer|required|exists:categories,id',
        'start_time'=>'required',
    ]);

    $bundle = new Bundle();
    $bundle->name = $validated['name'];
    $bundle->description = $validated['description'];
    $bundle->duration = $validated['duration'];
    $bundle->category_id = $validated['category_id'];
    $bundle->start_time = $validated['start_time'];

    try{
        $bundle->save();
        return response()->json($bundle);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to save bundle',
            'message'=>$exception->getMessage()],500);
    }
}
public function readAllBundles(){
    try{
        // $bundles = Bundle::all();
        $bundles = Bundle::join('categories','bundles.category_id','=','categories.id')
        ->select('bundles.*','categories.name as category_name')
        ->get();
        return response()->json($bundles);
        
    }
    catch(\Exception $exception){
        return response()->json([
     'error'=>'Failed to fetch bundles',
        'message'=>$exception->getMessage()
        ]);
    }
    
 }
 public function readBundle($id){
    try{
        // $bundle = Bundle::findOrFail($id);
        $bundles = Bundle::join('categories','bundles.category_id','=','categories.id')
        ->select('bundles.*','categories.name as category_name')
        ->where('bundles.id',$id)
        ->first();
        return response()->json($bundles);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to fetch bundle with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function updateBundle(Request $request,$id){
    $validated = $request->validate([
        'name'=>'required|string|unique:bundles,name',
        'description'=>'nullable|string|max:1000',
        'duration'=>'required|date_format:H:i:s',
        'category_id'=>'integer|required|exists:categories,id',
        'start_time'=>'required|date_Time',
    ]);
    try {
        $bundle = Bundle::findorfail($id);
        $bundle->name = $validated['name'];
        $bundle->description = $validated['description'];
        $bundle->duration = $validated['duration'];
        $bundle->category_id = $validated['category_id'];
        $bundle->start_time = $validated['start_time'];


        $bundle->save();
        return response()->json($bundle);

        
    }
     catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to update bundle with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function deleteBundle($id){
    try{
        $bundle = Bundle::findOrFail($id);
        $bundle->delete();
        return response('Bundle deleted successfully');
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to delete bundle with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
}
