<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        $feedbacks = Feedback::latest();

        if (!empty($request->keyword)) {
            $feedbacks->where('name', 'like', '%' . $request->keyword . '%');
            $feedbacks->orWhere('email', 'like', '%' . $request->keyword . '%');
        }

        $feedbacks = $feedbacks->paginate(8);
        return view('Admin.feedback.feedback', compact('feedbacks'));
    }


    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);


        if ($validator->passes()) {

            if (Auth::check() == false) {
                return response()->json([
                    'isError' => true,
                    'msg' => 'Submit Feedback to first Sign in',
                ]);
            }


            $ExistUser = User::where('email', $request->email)->first();
            if ($ExistUser != null) {
                return response()->json([
                    'isError' => true,
                    'msg' => 'Email is Already Exist',
                ]);
            }



            $user = Auth::user();

            $feedback =  new Feedback();
            $feedback->user_id = $user->id;
            $feedback->name = $request->name;
            $feedback->email = $request->email;
            $feedback->message = $request->message;
            $feedback->save();

            $message = 'Your Feedback Send Successfully';

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
        $feedback = Feedback::find($id);

        if (empty($feedback)) {

            $error = "Feedback Not Found";


            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => $error,
            ]);
        }

        if ($feedback->status == 0) {

            $feedback->status = 1;
            $feedback->save();

            $status = true;
            $message = "Feedback Status Change Successfully";
        } else {
            $feedback->status = 0;
            $feedback->save();

            $status = true;
            $message = "Feedback Status Change Successfully";
        }




        return response()->json([
            'status' => $status,
            'id' => $feedback->id,
            'feedbackStatus' => $feedback->status,
            'msg' => $message
        ]);
    }


    public function destroy(string $id)
    {

        $feedback = Feedback::find($id);

        if (empty($feedback)) {

            $error = "Feedback Not Found";


            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => $error,
            ]);
        }

        $feedback->delete();



        $status = true;
        $message = "Feedback Delete Successfully";



        return response()->json([
            'status' => $status,
            'id' => $id,
            'msg' => $message
        ]);
    }

    public function show(Request $request, $id)
    {

        $feedback = Feedback::find($id);


        if (empty($feedback)) {

            $error = "Feedback Not Found";
            $request->session()->flash('error', $error);
            return redirect()->route('feedback');
        }

        return view('Admin.feedback.feedback-detail', compact('feedback'));
    }
}
