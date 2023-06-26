<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class AuthController extends Controller
{
    
    public function createUser(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'mobile' => 'required|numeric|unique:users,mobile',
                'email' => 'required|email|unique:users,email',
         
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'user_id' => uniqid(),
                'password' => Hash::make(rand(1234, 9999))
            ]);

            $userOtp = $this->generateOtp($request->mobile);

            $user = User::where('mobile', $request->mobile)->first();

            return response()->json([
                'status' => true,
                'message' => 'OTP send successfully',
                'user_id' => $user->user_id,
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'mobile' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::where('mobile', $request->mobile)->first();

            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'Mobile number does not match with our record.',
                ], 401);
            }


            $userOtp = $this->generateOtp($request->mobile);

            return response()->json([
                'status' => true,
                'message' => 'OTP send successfully',
                'user_id' => $user->user_id,
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function generateOtp($mobile)
    {

        $user = User::where('mobile', $mobile)->first();

        $userOtp = UserOtp::where('user_id', $user->user_id)->latest()->first();

        $now = now();

        if($userOtp && $now->isBefore($userOtp->expire_at)){
            return $userOtp;
        }

        return UserOtp::create([

            'user_id' => $user->user_id,

            'otp' => rand(1234, 9999),

            'expire_at' => $now->addMinutes(10)

        ]);

    }


    public function loginWithOtp(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'otp' => 'required'
        ]);  

        $userOtp   = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = now();

        if (!$userOtp) { 
            return response()->json([
                'status' => false,
                'message' => 'Your OTP is not correct'
            ], 401);

        }else if($userOtp && $now->isAfter($userOtp->expire_at)){
            return response()->json([
                'status' => false,
                'message' => 'Your OTP has been expired'
            ], 401);
        }

        $ip = '';
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        } else{  
                 $ip = $_SERVER['REMOTE_ADDR'];  
        }  

        $new_arr = array(
            'ip' => $ip,
        );

        User::where('user_id', $request->user_id)->update($new_arr);

        $user = User::where('user_id', $request->user_id)->first();

        if($user){

            $userOtp->update([
                'expire_at' => now()
            ]);

            
            return response()->json([
                'status' => true,
                'message' => 'User Login Successfully',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
           
        }

        return response()->json([
                'status' => false,
                'message' => 'Your Otp is not correct'
            ], 401);
    }

    
   

}
