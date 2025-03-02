<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ServiceController extends Controller
{

    public function index(Request $request)
    {

        $services = Service::orderby('id', 'ASC');
        if (!empty($request->keyword)) {
            $services->where('title', 'like', '%' . $request->keyword . '%');
        }

        $services = $services->paginate(10);
        return view("Admin.service.service", compact('services'));
    }
    public function create()
    {
        return view("Admin.service.create");
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9\s]+$/',
            'slug' => 'required|min:3|max:200|unique:services',
            'description' => 'required|min:10',
            'is_Home' => 'required|in:Yes,No',
            'status' => 'required',

        ]);

        if ($validator->passes()) {
            $service = new Service();
            $service->title = $request->title;
            $service->slug = $request->slug;
            $service->description = $request->description;
            $service->is_Home = $request->is_Home;
            $service->status = $request->status;
            $service->save();



            if (!empty($request->serviceimage)) {
                $tempimgid = $request->serviceimage;
                $tempimginfo = TempImage::find($tempimgid);
                $extArray = explode('.', $tempimginfo->image);
                $ext = last($extArray);

                $newImageName = $service->id . '-' . time() . '.' . $ext;
                $TempSpath = public_path() . '/temp/' . $tempimginfo->image;
                $TempDpath = public_path() . '/uploads/Service/' . $newImageName;
                File::copy($TempSpath, $TempDpath);

                $service->img = $newImageName;
                $service->save();

                // Generate thumbnail





                //small
                $manager = new ImageManager(new Driver());
                $dpath = public_path() . '/uploads/Service/thumb/' . $newImageName;
                $image = $manager->read($TempDpath);
                $image->cover(300,275);
                $image->save($dpath);
            }

            $request->session()->flash('success', 'Service Added Successfully');
            return response()->json([
                'status' =>  true,
                'msg' => "Service Added Successfully",
            ]);
        } else {
            return response()->json([
                'status' =>  false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Request $request, string $id)
    {
        $service = Service::find($id);

        if (empty($service)) {
            $request->session()->flash('error', 'Service not Found');
            return response()->json([
                'status' => false,
                'msg' => 'Service Not Found'
            ]);
            return redirect()->route('Admin-service');
        }


        return view('Admin.service.edit', compact('service'));

        return response()->json([
            'status' => true,
            'msg' => 'Service  Found Successfully'
        ]);
    }


    public function update(Request $request, string $id)
    {
        $service = Service::find($id);
        if (empty($service)) {
            $request->session()->flash('error', 'Service not Found');
            return response()->json([
                'status' => false,
                'NotFound' => true,
                'msg' => 'Service Not Found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200|regex:/^(?=.*[A-Za-z].*[A-Za-z].*[A-Za-z])[A-Za-z0-9\s]+$/',
            'slug' => 'required|min:3|max:200|unique:services,slug,' . $service->id . ',id',
            'description' => 'required|min:10',
            'is_Home' => 'required|in:Yes,No',
            'status' => 'required',

        ]);

        if ($validator->passes()) {
            $service->title = $request->title;
            $service->slug = $request->slug;
            $service->description = $request->description;
            $service->is_Home = $request->is_Home;
            $service->status = $request->status;
            $service->update();

            $OldImageName = $service->img;


            if (!empty($request->serviceimage)) {
                $tempimgid = $request->serviceimage;
                $tempimginfo = TempImage::find($tempimgid);
                $extArray = explode('.', $tempimginfo->image);
                $ext = last($extArray);

                $newImageName = $service->id . '-' . time() . '.' . $ext;
                $TempSpath = public_path() . '/temp/' . $tempimginfo->image;
                $TempDpath = public_path() . '/uploads/Service/' . $newImageName;
                File::copy($TempSpath, $TempDpath);

                $service->img = $newImageName;
                $service->update();

                File::delete(public_path('uploads/Service/thumb/' . $OldImageName));
                File::delete(public_path('uploads/Service/' . $OldImageName));


                // Generate thumbnail



                 //small
                 $manager = new ImageManager(new Driver());
                 $dpath = public_path() . '/uploads/Service/thumb/' . $newImageName;
                 $image = $manager->read($TempDpath);
                 $image->cover(300,275);
                 $image->save($dpath);
            }

            $request->session()->flash('success', 'Service Updated Successfully');
            return response()->json([
                'status' =>  true,
                'msg' => "News Updated Successfully",
            ]);
        } else {
            return response()->json([
                'status' =>  false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy(string $id)
    {
        $service = Service::find($id);
        if (empty($service)) {
            return response()->json([
                'status' => false,
                'error' => true,
                'msg' => 'Service Not Found'
            ]);
        }
        File::delete(public_path('uploads/Service/thumb/' . $service->img));
        File::delete(public_path('uploads/Service/' . $service->img));

        $service->delete();

        return response()->json([
            'status' => true,
            'id' => $id,
            'msg' => 'Service will be Deleted Successfully',
        ]);
    }
}
