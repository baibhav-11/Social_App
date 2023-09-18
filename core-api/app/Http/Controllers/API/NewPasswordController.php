<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Validator;
class NewPasswordController extends Controller
{

    //forgot password 
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
        ? response()->json(['status' => __($status)], 200)
        : response()->json(['email' => __($status)], 422);
        return response()->json([trans($status)], 422);

    }
  

//reset password


    protected function reset(Request $request){

        $input = $request->only('token', 'password', 'password_confirmation', 'email');
        $validator = Validator::make($input, [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
        }

        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
            'password' => Hash::make($password)
            ])->save();
            //$user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        });

        if($response == Password::PASSWORD_RESET){
            $message = "Password reset successfully";
            $code = 200;
        }else{
            $message = "Email could not be sent to this email address";
            $code = 422;
        }

        $response = ['message' => $message];

        return response()->json($response, $code);
    }

}