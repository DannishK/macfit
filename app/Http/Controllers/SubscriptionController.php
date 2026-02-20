<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
class SubscriptionController extends Controller
{
    public function createSubscription(Request $request){

    $validated = $request->validate([
        'user_id'=>'required|string|unique:subscriptions,user_id',
        'bundle_id'=>'integer|required|exists:bundles,id',
    ]);

    $subscription = new Subscription();
    $subscription->user_id = $validated['user_id'];
    $subscription->bundle_id = $validated['bundle_id'];

    try{
        $subscription->save();
        return response()->json($subscription);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to save subscription',
            'message'=>$exception->getMessage()],500);
    }
}
public function readAllSubscriptions(){
    
    try{
        $Subscriptions = Subscription::join('bundles','subscriptions.bundle_id','=','bundles.id')
        ->select('subscriptions.*','bundles.name as bundle_name')
        ->get();
        return response()->json($Subscriptions);
    }
    catch(\Exception $exception){
        return response()->json([
     'error'=>'Failed to fetch subscriptions',
        'message'=>$exception->getMessage()
        ],500);
    }
    
 }
 public function readSubscription($id){
    try{
        $subscription = Subscription::join('bundles','subscriptions.bundle_id','=','bundles.id')
        ->select('subscriptions.*','bundles.name as bundle_name')
        ->where('subscriptions.id',$id)
        ->first();
        return response()->json($subscription);
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to fetch subscription with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function updateSubscription(Request $request,$id){
    $validated = $request->validate([
        'user_id'=>'required|string|unique:subscriptions,user_id',
        'bundle_id'=>'integer|required|exists:bundles,id',
    ]);
    try {
        $existingSubscription = Subscription::findOrFail($id);
        $existingSubscription->user_id = $validated['user_id'];
        $existingSubscription->bundle_id = $validated['bundle_id'];
        $existingSubscription->save();
        return response()->json($existingSubscription);

        
    }
     catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to update subscription with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
public function deleteSubscription($id){
    try{
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        return response('Subscription deleted successfully');
    }
    catch(\Exception $exception){
        return response()->json([
            'error'=>'Failed to delete subscription with ID.',$id,
            'message'=>$exception->getMessage()
        ]);
    }
}
}
