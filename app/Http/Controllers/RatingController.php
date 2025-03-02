<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{

    public function index(Request $request)
    {
        $ratings = Rating::latest('ratings.created_at')->select('ratings.*', 'products.title')->leftJoin('products', 'products.id', '=', 'ratings.product_id');

        if (!empty($request->keyword)) {
            $ratings->where('name', 'like', '%' . $request->keyword . '%');
            $ratings->orWhere('email', 'like', '%' . $request->keyword . '%');
            $ratings->orWhere('products.title', 'like', '%' . $request->keyword . '%');
        }
        $ratings = $ratings->paginate(8);
        return view('Admin.Rating.rating', compact('ratings'));
    }


    public function store(Request $request, $id)
    {


        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]);


        if ($validator->passes()) {

            if (Auth::check() == false) {
                return response()->json([

                    'isError' => true,
                    'msg' => 'Add Reviews to first Sign in',
                ]);
            }


            $RatingCheck = Rating::where(['user_id' => $user->id, 'product_id' => $id])->first();

            if ($RatingCheck != null) {
                $error = 'Your Already Comment For This Product';

                return response()->json([
                    'status' => true,
                    'msg' => $error,
                ]);
            }



            $ExistUser = User::where('email', $request->email)->first();
            if ($ExistUser != null) {
                return response()->json([
                    'isError' => true,
                    'msg' => 'Email is Already Exist',
                ]);
            }


            $rating = new Rating();
            $rating->user_id = $user->id;
            $rating->product_id = $id;
            $rating->name = $request->name;
            $rating->email = $request->email;
            $rating->message = $request->message;
            $rating->save();

            $message = 'Your Comment Send Successfully';

            return response()->json([
                'status' => true,
                'msg' => $message,
            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }



    public function ChangeStatus(string $id)
    {
        $rating = Rating::find($id);

        if (empty($rating)) {

            $error = "Ratng Not Found";


            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => $error,
            ]);
        }

        if ($rating->status == 0) {

            $rating->status = 1;
            $rating->save();

            $status = true;
            $message = "Rating Status Change Successfully";
        } else {
            $rating->status = 0;
            $rating->save();

            $status = true;
            $message = "Rating Status Change Successfully";
        }




        return response()->json([
            'status' => $status,
            'id' => $id,
            'ratingStatus' => $rating->status,
            'msg' => $message
        ]);
    }


    public function destroy(string $id)
    {
        $rating = Rating::find($id);

        if (empty($rating)) {

            $error = "Rating Not Found";


            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => $error,
            ]);
        }

        $rating->delete();



        $status = true;
        $message = "Rating Delete Successfully";




        return response()->json([
            'status' => $status,
            'id' => $id,
            'msg' => $message
        ]);
    }


    public function show(Request $request, $id)
    {

        $rating = Rating::where('ratings.id', $id)->select('ratings.*', 'products.title')->leftJoin('products', 'products.id', '=', 'ratings.product_id')->first();


        if (empty($rating)) {

            $error = "Ratng Not Found";
            $request->session()->flash('error', $error);
            return redirect()->route('Rating');
        }

        return view('Admin.rating.rating-detail', compact('rating'));
    }
}
