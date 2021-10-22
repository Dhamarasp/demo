<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use App\Models\Image;
use Yajra\Datatables\Datatables;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

class ImageController extends BaseController{
    public function indexList(Request $request){
        $breadcrumb = array(
            (object) ['name' => 'Dashboard', 'link' => 'welcome'],
            (object) ['name' => 'Images', 'link' => 'images']
        );

        return view('admin/pages/list-image', compact('breadcrumb'));
    }

    public function getMedia($tanggal, $name_file){
        $name = 'public/image/'.$tanggal.'/'.$name_file;
        if (!Storage::exists($name)){
            return Response::make('File no found.', 404);
        }

        $file = Storage::get($name);
        $type = Storage::mimeType($name);
        $response = Response::make($file, 200)->header("Content-Type", $type);

        return $response;
    }

    public function commonList(Request $request){

        $list_data = Image::select('image_id', 'image_url', 'image_name', 'updated_at')
                            ->orderby('updated_at', 'desc')
                            ->get();

        return Datatables::of($list_data)
                ->addColumn('image', function($item){
                    $data = array(
                        'src' => url('media').'/'.$item->image_url,
                        'alt' => $item->image_name,
                        'date' => with(new Carbon($item->updated_at))->format('j-m-Y H:i ')
                    );
                    return $data;
                })
                ->addColumn('action', function($item){
                    $data = array(
                        'id' =>$item->image_id
                    );
                    return $data;
                })
                ->make(true);
    }

    public function actionSave(Request $request){
        $input = (object) $request->input();

        if ($request->hasFile('image_base')) {
            $tanggal = Carbon::today()->format('Y-m-d');
            $filename = uniqid().'.'.$request->file('image_base')->getClientOriginalExtension();
            $path = Storage::putFileAs('public/image/'.$tanggal, $request->file('image_base'), $filename);
            $path = str_replace('public/', 'storage/', $path);

            $image = new Image;
            $image->image_name = $input->image_name;
            $image->image_url = $tanggal.'/'.$filename;
            $image->save();
            
            return ['status' => 200, 'message' => 'Successfully save record!'];
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }
    }

    public function actionDelete(Request $request){
        $input = (object) $request->input();
        if($item = Image::find($input->image_id)){
            $image = $item;
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }

        if($image->delete()){
            $file = 'public/image/'.$image->image_url;
            if (!Storage::exists($file)){
                Storage::delete($file);
            }
            return ['status' => 200, 'message' => 'Successfully delete record!'];
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }
    }

    public function actionUploadImage(Request $request){
        $input = (object) $request->input();

        if ($request->hasFile('image_base')) {
            $tanggal = Carbon::today()->format('Y-m-d');
            $filename = uniqid().'.'.$request->file('image_base')->getClientOriginalExtension();
            $path = Storage::putFileAs('public/image/'.$tanggal, $request->file('image_base'), $filename);
            $path = str_replace('public', 'storage', $path);

            $image = new Image;
            $image->image_name = $request->file('image_base')->getClientOriginalName();
            $image->image_url = $tanggal.'/'.$filename;
            $image->save();

            return url('media').'/'.$image->image_url;
        }else{
            return null;
        }
    }
}