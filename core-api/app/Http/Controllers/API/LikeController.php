<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\like;
use App\Notifications\LikeNotification;
use Illuminate\Support\Facades\Auth;
use App\Classes\BroadcastNotification;

use GuzzleHttp\Client;

class LikeController extends Controller
{
    public function like(Request $request) //like api
    {
        // return response()->json(Auth::user(), 422);

        $like = new like;

        if(!Like::where(['post_id' => $request->post_id, 'user_id' => Auth::user()->id])->exists()){
            $like->post_id = $request->post_id;
            $like->user_id = Auth::user()->id;
            $like->save();
            $id = $like->post_id;
            $post = Post::with('likes')->find($id);


            $post = Post::with('likes')->where('id', $request->post_id)->first();

            // BroadcastNotification::sendlike($like);
            BroadcastNotification::sendlike($post);

                return response()->json(['message'=>'Liked','Like'=>$like], 200);
        }
        else{
            return response()->json('Already liked', 200);
        }
    }
    public function dislike(Request $request) //dislike api
    {
        // return response()->json(Auth::user(), 422);
        // return response()->json($request->post_id);
        
        
        if(Like::where(['post_id' => $request->post_id, 'user_id' => Auth::user()->id])->exists()){

            Like::where(['post_id' => $request->post_id, 'user_id' => Auth::user()->id])->delete();

            $post = Post::with('likes')->where('id', $request->post_id)->first();

            // BroadcastNotification::sendlike($like);
            BroadcastNotification::sendlike($post);

                return response()->json(['message'=>'disLiked'], 200);
        }
        else{
            return response()->json('Already disliked', 200);
        }
    }
}