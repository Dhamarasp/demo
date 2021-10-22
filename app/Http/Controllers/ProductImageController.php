<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use App\Models\ProductImage;
use Yajra\Datatables\Datatables;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

class ProductImageController extends BaseController{
    
    public function getProductImage($tanggal, $name_file){
        $name = 'public/image/product/'.$tanggal.'/'.$name_file;
        if (!Storage::exists($name)){
            return Response::make('File no found.', 404);
        }

        $file = Storage::get($name);
        $type = Storage::mimeType($name);
        $response = Response::make($file, 200)->header("Content-Type", $type);

        return $response;
    }

    public function detailList(Request $request){
        $input = (object) $request->input();
        if(empty($input->id)){
            $list_data = array();
        }else{
            $list_data = ProductImage::select(
                                'product_image_id',
                                'product_image_url',
                                'product_image_order')
                            ->where('product_id', $input->id)
                            ->orderBy('product_image_order', 'asc')
                            ->get();
        }

        return Datatables::of($list_data)
                ->editColumn('product_image_url', function($item){
                    return url('media').'/'.$item->product_image_url;
                })
                ->editColumn('product_image_order', function($item){
                    $data = array(
                        'id' => $item->product_image_id
                    );
                    return $data;
                })
                ->addColumn('action', function($item){
                    $data = array(
                        'id' => $item->product_image_id
                    );
                    return $data;
                })
                ->make(true);
    }

    public function actionOrder(Request $request){
        $input = (object) $request->input();
        
        if($product_image = ProductImage::find($input->product_image_id)){
            if($input->order > 0){
                $order = $product_image->product_image_order + 1;
                if($after_image = ProductImage::where(['product_id' => $product_image->product_id, 'product_image_order' => $order])->first()){
                    $after_image->product_image_order = $after_image->product_image_order - 1;
                    $after_image->save();

                    $product_image->product_image_order = $order;
                    $product_image->save();
                    return ['status' => 200, 'message' => 'Successfully order image!'];
                }else{
                    return ['status' => 201, 'message' => 'Cannot process!'];
                }
            }else{
                $order = $product_image->product_image_order - 1;
                if($before_image = ProductImage::where(['product_id' => $product_image->product_id, 'product_image_order' => $order])->first()){
                    $before_image->product_image_order = $before_image->product_image_order + 1;
                    $before_image->save();

                    $product_image->product_image_order = $order;
                    $product_image->save();
                    return ['status' => 200, 'message' => 'Successfully order image!'];
                }else{
                    return ['status' => 201, 'message' => 'Cannot process!'];
                }
            }
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }
    }

    public function actionSave(Request $request){
        $input = (object) $request->input();

        if ($request->hasFile('product_image')) {
            $tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $filename = uniqid().'.'.$request->file('product_image')->getClientOriginalExtension();
            $path = Storage::putFileAs('public/image/product/'.$tanggal, $request->file('product_image'), $filename);
            $path = str_replace('public/', 'storage/', $path);

            if($last_image = ProductImage::where('product_id', $input->product_id)->first()){
                $product_image = new ProductImage;
                $product_image->product_id = $input->product_id;
                $product_image->product_image_url = 'product/'.$tanggal.'/'.$filename;
                $product_image->product_image_order = $last_image->product_image_order + 1;
                $product_image->save();
            }else{
                $product_image = new ProductImage;
                $product_image->product_id = $input->product_id;
                $product_image->product_image_url = 'product/'.$tanggal.'/'.$filename;
                $product_image->product_image_order = 0;
                $product_image->save();
            }
            
            return ['status' => 200, 'message' => 'Successfully save record!'];
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }
    }
}