<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\TempImage;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminInfoContoller extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        return view('Admin.Profile.profile', [
            'user' => $request->user(),
        ]);
    }

    public function password(Request $request): View
    {


        return view('Admin.Profile.change-password', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,id,' . Auth::id() . ',id'],
            'mobile' => ['required', 'numeric', 'min:11', 'regex:/^0[3-9][0-9]{2}[0-9]{7}$/'],
        ], [
            'name.pattern' => "name must be alphabetical letter ",
        ]);


        if ($validator->passes()) {
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;


            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();


            if (!empty($request->profileImg)) {
                $tempimgid = $request->profileImg;
                $tempimginfo = TempImage::find($tempimgid);
                $extArray = explode('.', $tempimginfo->image);
                $ext = last($extArray);
                $newImageName = $user->id . '-' . time() . '.' . $ext;
                $TempSpath = public_path() . '/temp/' . $tempimginfo->image;
                $TempDpath = public_path() . '/uploads/profile/' . $newImageName;
                File::copy($TempSpath, $TempDpath);

                $user->profile_img = $newImageName;
                $user->save();


                $manager = new ImageManager(new Driver());
                $dpath = public_path() . '/uploads/profile/thumb/' . $newImageName;
                $image = $manager->read($TempDpath);
                $image->cover(300, 275);
                $image->save($dpath);
            }

            return response()->json([
                'status' => true,
                'msg' => "Profile  Updated Successfully"
            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'Please enter your password.',
            'password.current_password' => 'The password you entered is incorrect.',
        ]);

        if ($validator->passes()) {
            $user = $request->user();

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => true,
                'msg' => "Account deleted successfully.",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
