<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Post;
use App\Models\Attachment;
use App\Models\Linkurl;
use Validator;
use App\Http\Resources\Post as PostResource;
use Auth;
use DB;
use URL;
use Storage;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Post = Post::with('comments.user', 'comments.replies.user','likes', 'author', 'attachment')->latest()->get();
       
        return response()->json($Post, 200); 
    
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            
            'detail' => $request->hasFile('attachment') ? 'nullable' : 'required',
            'attachment' => $request->detail ? 'nullable' : 'required',
        ]);
        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors());    
            return response()->json($validator->errors(), 422);    
        }



        try {
            DB::beginTransaction();
            

            if($request->hasFile('attachment')){
                $file = $request->file('attachment');
                $default_storage_path = storage_path('app'. DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR . 'attachments');
                if(!file_exists($default_storage_path)){
                    mkdir($default_storage_path, intval('755',8), true);
                }
                $file_name = $file->getClientOriginalName();
                $file->move($default_storage_path, $file_name);

                $attachment = new Attachment;
                $attachment->url = URL::to('/') . Storage::url('attachments') . '/' . $file_name;
                $attachment->type = $request->type;
                $attachment->save();
            }else{
                $attachment = null;
            }
            $Post = new Post;
            
            $Post->detail = $request->detail;
            $Post->user_id = Auth::user()->id;
            $Post->attachment_id = $attachment ? $attachment->id : null;
            $Post->save();

            DB::commit();
            
            return response()->json([ 'post' => $Post,'message'=>'Post created successfully.'], 200);  
            
        } 
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e, 500]); 
            // return response()->json('error', 'Server error.');
            throw $e;
        }
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Post = Post::find($id);
  
        if (is_null($Post)) {
            return $this->sendError('Post not found.');
        }
   
        // return $this->sendResponse(new $PostResource($Post), 'Post retrieved successfully.');
        return response()->json($Post, 200);  

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $Post)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $validator = Validator::make($input, [
            'detail' => 'required'
        ]);
        
        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors());  
            return response()->json($validator->errors(), 422);    

        }
        if($Post['user_id'] == Auth::user()->id){
            
            $Post->detail = $input['detail'];
            $Post->save();

        // return $this->sendResponse(new PostResource($Post), 'Post updated successfully.');
        return response()->json('Post updated successfully.', 200);  


        }else{
            // return $this->sendError('Unauthorized', 'you are not allowded to change the post'); 
            return response()->json('you are not allowded to change the post.', 401);  

            
        }
    }
   
    // public function update(Request $request, Post $Post)
    // {
    //     $input = $request->all();
   
    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'detail' => 'required'
    //     ]);
   
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
   
    //     $Post->name = $input['name'];
    //     $Post->detail = $input['detail'];
    //     $Post->save();
   
    //     return $this->sendResponse(new PostResource($Post), 'Post updated successfully.');
    // }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $Post)
    {
        $Post->delete();
   
        // return $this->sendResponse([], 'Post deleted successfully.');
        return response()->json('Post deleted successfully.', 200);  
        
    }
}
