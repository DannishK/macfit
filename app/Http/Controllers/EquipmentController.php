<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function createEquipment(Request $request){

    $validated = $request->validate([
        'name'=>'required|string|unique:equipments,name',
        'usage'=>'string',
        'model_no'=>'string',
        'value'=>'integer',
        'status'=>'string',
    ]);

    $equipment = new Equipment();
    $equipment->name = $validated['name'];
    $equipment->usage = $validated['usage'];
    $equipment->model_no = $validated['model_no'];
    $equipment->value = $validated['value'];
    $equipment->status = $validated['status'];

    try{
        $equipment->save();
        return response()->json($equipment);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to save equipment',
            'message'=>$exception->getMessage()],500);
    }
}
public function readAllEquipments(){
    try{
        $equipments = Equipment::all();
        return response()->json($equipments);
        
    }
    catch(\Exception $exception){
        return response()->json([
     'error'=>'Failed to fetch equipments',
        'message'=>$exception->getMessage()
        ],500);
    }
    
 }
 public function readEquipment($id){
    try{
        $equipment = Equipment::findOrFail($id);
        return response()->json($equipment);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to fetch equipment with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function updateEquipment(Request $request,$id){
    $validated = $request->validate([
        'name'=>'required|string|unique:equipments,name',
        'usage'=>'string',
        'model_no'=>'string',
        'value'=>'integer',
        'status'=>'string',
    ]);
    try {
        $existingEquipment = Equipment::findorfail($id);
        $existingEquipment->name = $validated['name'];
        $existingEquipment->usage = $validated['usage'];
        $existingEquipment->model_no = $validated['model_no'];
        $existingEquipment->value = $validated['value'];
        $existingEquipment->status = $validated['status'];
        $existingEquipment->save();
        return response()->json($existingEquipment);

        
    }
     catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to update equipment with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function deleteEquipment($id){
    try{
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return response('Equipment deleted successfully');
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to delete equipment with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
}
