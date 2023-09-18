<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Rules\StringTypeValidateRule;
use DB;
use URL;
use Storage;
// register a user
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        // $isString = false;
        // if (preg_match('/^[\p{L} ]+$/u', $request->first_name))
        // {
        //     $isString = true;
        // }else{
        //     $isString = false;
        // }
        // return response()->json($isString, 422);

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:120', new StringTypeValidateRule],
            'last_name' => ['required', 'string', 'max:120', new StringTypeValidateRule],
            'email' => 'required|email|max:120',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            // 'profile_picture' => 'nullable|image'
        ]);

        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors());
            // return response()->json(['Validation Error', $validator->errorS()]);
            return response()->json($validator->errors(),422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // if($request->profile_picture && $request->profile_picture->isValid()){
        //     $file_name = time().'.'.$request->profile_picture->extension();
        //     $request->profile_picture->move(public_path('images'),$file_name);
        //     $path = "public/images/$file_name";
        //     $user->profile_picture = $path;
        // }
        // return response()->json($request->hasFile('attachment'), 422);
        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $default_storage_path = storage_path('app'. DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR . 'profile-pictures');
            if(!file_exists($default_storage_path)){
                mkdir($default_storage_path, intval('755',8), true);
            }
            $file_name = $file->getClientOriginalName();
            $file->move($default_storage_path, $file_name);
            $attachment_url = URL::to('/') . Storage::url('profile-pictures') . '/' . $file_name;
        }else{
            $attachment_url = null;
        }
        $user->profile_picture = $attachment_url;
        $user->update();

        return response()->json('User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    //login a user
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token =  $user->createToken('MyApp')-> accessToken;

            return response()->json(['token' => $token, 'authUser' => $user]);
        }
        else{
            // return response()->json(['success' => false, 'message' => 'Invalid email or password.'], 422);
            return response()->json(["Credentials doesn't match with our records."],422);
            // return $this->sendError('Invalid email or password.', ['error'=>'Invalid email or password']);
        }
    }

    public function authuser(Request $request)
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function getProfile(Request $request){
        try{
            $user_id = $request->user()->id;
            $data = User::find($user_id);
            return response()->json(['status'=>'true','message'=>"User profile",'data'=>$data]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'false','message'=>$e->getMessage(),'data'=>[]],500);
        }
    }

    public function updateProfile(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                
                'profile_picture' => 'nullable|image'
            ]);
            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status'=>'false','message'=>$error,'data'=>[]],422);
            }else{
                $user = User::find($request->user()->id);
                
                if($request->profile_picture && $request->profile_picture->isValid()){
                    $file_name = time().'.'.$request->profile_picture->extension();
                    $request->profile_picture->move(public_path('images'),$file_name);
                    $path = "public/images/$file_name";
                    $user->profile_picture = $path;
                }
                $user->update();
                return response()->json(['status'=>'true','message'=>"Profile Updated!",'data'=>$user]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'false','message'=>$e->getMessage(),'data'=>[]],500);
        }
    }

//logout a user
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();
            // return $this->sendResponse(null,'User is logout');
            return response()->json('User Logout Successfully');
        }
        else{
            // return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'] , Response::HTTP_UNAUTHORIZED);
            return response()->json('Unauthorized',401);
        }
    }
}
