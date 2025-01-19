<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tempimage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class TempImageController extends Controller
{
    public function create(Request $request)
    {
         $image = $request->image;

         if(!empty($image)){
            $ext = $image->getClientOriginalExtension();
            $ImgNew = time().'.'.$ext;


            $Temp = new tempimage();
            $Temp->image = $ImgNew;
            $Temp->save();

            $image->move(public_path().'/temp',$ImgNew);

            $manager = new ImageManager(new Driver());
            $spath = public_path().'/temp/'.$ImgNew;
            $dpath = public_path().'/temp/thumb/'.$ImgNew;
            $image = $manager->read($spath);
            $image->cover(300,275);
            $image->save($dpath);


            return response()->json([
                'status' => true,
                'Image_id' => $Temp->id, 
                'Image_path' => asset('temp/thumb/'.$ImgNew) 
            ]);

         }
    }
}
