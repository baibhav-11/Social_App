<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Classes\BroadcastNotification;

use GuzzleHttp\Client;

class CommentController extends Controller
{
    public function store(Request $request) // commenting on a post and reply on a post api
    {
        // return response()->json(Auth::user(), 422);


        $this->validate($request, [
            'comment' => 'required|min:1|max:500',
        ]);

        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->parent_id = $request->parent_id;
        $comment->user_id = Auth::user()->id;
        $comment->save();
        $id = $comment->post_id;
        $post = Post::with('comments')->find($id);
        $post = Post::with('comments.replies')->where('id', $request->post_id)->first();
        // Notify 
        BroadcastNotification::sendComment($post);


        // $userid  = $post->user_id;
        // if ($userid != $userid ){
        // $user = User::where('id', $userid)->first();
        // auth()->user()->notify(new CommentNotification($comment, $request->post_Id));
        // $comment->user->notify(new CommentNotification($comment, $request->post_id));
        // }
        // auth()->user()->notify(new CommentNotification());
        // return response()->json('commented', 200);
         return response()->json(['message'=>'Comment posted successfully!','comment'=>$comment], 200);



    }
}