<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    
   public function get_popular()
    {
        $popular_data = HomeCategory::where('name', 'popular')->first();
        if($popular_data){
            $popularbooks = Book::where('home_category', $popular_data->id)->where('status', 'active')->where('showbookto', 'all_users')->orderBy('id','DESC')->get();
            if($popularbooks){
                return response()->json([
                    'status' => true,
                    'message' => 'Get books data successfully',
                    'book' => $popularbooks,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No book available, please try again',
                ], 401);
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'No Category available, please try again',
            ], 401);
        }
        
       
    }

    public function get_recommended()
    {
        $recommended_data = HomeCategory::where('name', 'recommended')->first();
        if($recommended_data){
            $recommendedbooks = Book::where('home_category', $recommended_data->id)->where('status', 'active')->where('showbookto', 'all_users')->orderBy('id','DESC')->get();
            if($recommendedbooks){
                return response()->json([
                    'status' => true,
                    'message' => 'Get books data successfully',
                    'book' => $recommendedbooks,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No book available, please try again',
                ], 401);
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'No Category available, please try again',
            ], 401);
        }
        
       
    }

    public function get_new_release()
    {
        
            $newreleasebooks = Book::where('status', 'active')->where('showbookto', 'all_users')->orderBy('id','DESC')->take(10)->get();
            if($newreleasebooks){
                return response()->json([
                    'status' => true,
                    'message' => 'Get new books data successfully',
                    'book' => $newreleasebooks,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No book available, please try again',
                ], 401);
            }
       
    }

    public function get_members_data()
    {
        
            $membersbooks = Book::where('status', 'active')->where('showbookto', 'paid_users')->orderBy('id','DESC')->get();
            if($membersbooks){
                return response()->json([
                    'status' => true,
                    'message' => 'Get member books data successfully',
                    'book' => $membersbooks,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No book available, please try again',
                ], 401);
            }
       
    }

    public function get_authors()
    {
        
            $authors = Author::where('status', 'active')->orderBy('id','DESC')->get();
            if($authors){
                return response()->json([
                    'status' => true,
                    'message' => 'Get authors data successfully',
                    'book' => $authors,
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No author available, please try again',
                ], 401);
            }
       
    }

    public function get_dashboard_data()
    {
        $popular_data = HomeCategory::where('name', 'popular')->first();
        if($popular_data){
            $popularbooks = Book::where('status', 'active')->where('showbookto', 'all_users')->where('home_category', $popular_data->id)->orderBy('id','DESC')->take(4)->get();
            if(!$popularbooks){
                return response()->json([
                    'status' => false,
                    'message' => 'No Popolar books available, please try again',
                ], 401);
            }

        }else{
            return response()->json([
                'status' => false,
                'message' => 'No Popolar category available, please try again',
            ], 401);
        }

        $recommended_data = HomeCategory::where('name', 'recommended')->first();
        if($recommended_data){
            $recommendedbooks = Book::where('home_category', $recommended_data->id)->where('status', 'active')->where('showbookto', 'all_users')->orderBy('id','DESC')->take(4)->get();

            if(!$recommendedbooks){
                return response()->json([
                    'status' => false,
                    'message' => 'No Recommended books available, please try again',
                ], 401);
            }

        }else{
            return response()->json([
                'status' => false,
                'message' => 'No Recommended category available, please try again',
            ], 401);
        }


        $newreleasebooks = Book::where('status', 'active')->where('showbookto', 'all_users')->orderBy('id','DESC')->take(4)->get();

        if(!$newreleasebooks){
            return response()->json([
                'status' => false,
                'message' => 'No new release books available, please try again',
            ], 401);
        }


        $membersbooks = Book::where('status', 'active')->where('showbookto', 'paid_users')->orderBy('id','DESC')->take(4)->get();

        if(!$membersbooks){
            return response()->json([
                'status' => false,
                'message' => 'No member books available, please try again',
            ], 401);
        }


        $authors = Author::where('status', 'active')->orderBy('id','DESC')->take(4)->get();

        if(!$authors){
            return response()->json([
                'status' => false,
                'message' => 'No author available, please try again',
            ], 401);
        }


        return response()->json([
            'status' => true,
            'message' => 'Get dashboard data successfully',
            'popularbooks' => $popularbooks,
            'recommendedbooks' => $recommendedbooks,
            'newreleasebooks' => $newreleasebooks,
            'membersbooks' => $membersbooks,
            'authors' => $authors,
        ], 200);
       
    }

    
    

}
