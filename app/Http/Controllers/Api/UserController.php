<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
   public function index($id)
    {
        $user = User::where('user_id', $id)->first();
        if($user){
            return response()->json([
                'status' => true,
                'message' => 'Get user data successfully',
                'user' => $user,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User not exist, please try again',
            ], 401);
        }
       
    }

     public function get_user_favorite_data($user_id)
    {
        
            $favorites = Favorite::where('user_id', $user_id)->orderBy('id','DESC')->get();
            if($favorites){
                return response()->json([
                    'status' => true,
                    'message' => 'Get user favorite data successfully',
                    'book' => $favorites,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No user favorite data available, please try again',
                ], 401);
            }
       
    }

    public function follow_author(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), 
            [
                'author_id' => 'required',
                'user_id' => 'required',
         
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $followdata = Follow::create([
                'author_id' => $request->author_id,
                'user_id' => $request->user_id,
               
            ]);

            
            return response()->json([
                'status' => true,
                'message' => 'Author followed successfully',
                'followdata' => $followdata,
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
