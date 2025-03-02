<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $Spath = $image->getPathName();


        $productimages = new ProductImage();
        $productimages->product_id = $request->product_id;
        $productimages->image = 'null';
        $productimages->save();

        $ImageName = $request->product_id . '-' . $productimages->id . '-' . time() . '.' . $ext;
        $productimages->image = $ImageName;
        $productimages->save();

        // Generate thumbnail

        //large
        $manager = new ImageManager(new Driver());
        $dpath = public_path() . '/uploads/product/large/' . $ImageName;
        $image = $manager->read($Spath);
        $image->scaleDown(1400);
        $image->save($dpath);



        //small
        $dpath = public_path() . '/uploads/product/small/' . $ImageName;
        $image->cover(300, 300);
        $image->save($dpath);


        return response()->json([
            'status' => true,
            'Image_id' => $productimages->id,
            'Image_path' => asset('uploads/product/small/' . $productimages->image),
            'msg' => 'Image Added Successfully'
        ]);
    }
    public function destroy(Request $request)
    {

        $productimages = ProductImage::find($request->id);
        if (empty($productimages)) {
            return response()->json([
                'status' => false,
                'msg' => 'Image not found'
            ]);
        }

        File::delete(public_path('uploads/product/large/' . $productimages->image));
        File::delete(public_path('uploads/product/small/' . $productimages->image));


        $productimages->delete();

        return response()->json([
            'status' => true,
            'msg' => 'Image Deleted Successfully'
        ]);
    }
}
