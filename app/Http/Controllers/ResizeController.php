<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ResizeController extends Controller
{
    public function index()
    {
        File::delete(public_path().'/uploads/'.'1667575277.jpeg');
        return view('resize');
    }

    public function resizeImage(Request $request)
    {

        /*$this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $image = $request->file('file');
        $input['file'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/thumbnail');
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['file']);
        //$destinationPath = public_path('/uploads');
        //$image->move($destinationPath, $input['file']);

        return back()
            ->with('success','Image has successfully uploaded.')
            ->with('fileName',$input['file']);*/
       /* $input = $request->all();
        $input['file'] = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $input['file']);

        return response()->json(['success'=>'done']);*/
        $image = $request->file('file');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        return response()->json([
            'message'   => 'Image Upload Successfully',
            'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
            'class_name'  => 'alert-success'
        ]);
    }
}
