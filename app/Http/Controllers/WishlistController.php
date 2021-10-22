<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;

use App\Models\Product;
use App\Models\Wishlist;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

class WishlistController extends BaseController{
    
    public function indexList(Request $request){
        $customer = Auth::user();
        $wishlists = Wishlist::where('customer_id', $customer->customer_id)->get();

        $lang_id = true;
        $media_url = env('MEDIA_URL', '');
        $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $products = Product::select(
                                'products.product_id', 
                                'product_image_url',
                                'product_code', 
                                'product_type_name')
                            ->selectRaw('IF (? BETWEEN product_start_date_diskon_price AND product_end_date_diskon_price, product_diskon_price, product_selling_price) as product_price', [$today])
                            ->when($lang_id, function ($query) {
                                return $query->selectRaw('product_name_id as product_name');
                            }, function ($query) {
                                return $query->selectRaw('product_name_en as product_name');
                            })
                            ->join('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
                            ->leftJoin('product_images', function ($join) {
                                $join->on('product_images.product_id', '=', 'products.product_id')
                                    ->where('product_images.product_image_order', 0)->whereNull('product_images.deleted_at');
                            })
                            ->whereIn('products.product_id', $wishlists->pluck('product_id'))->get();
        return view('pages/list-wishlist', compact('products', 'media_url'));
    }

    public function actionSaveDelete(Request $request){
        $customer = Auth::user();
        $input = (object) $request->input();
        if(empty($input->product_id)){
            return abort(404);
        }else{
            if($wishlist = Wishlist::where(['customer_id' => $customer->customer_id, 'product_id' => $input->product_id])->first()){
                $wishlist->delete();
            }else{
                $wishlist = new Wishlist;
                $wishlist->customer_id = $customer->customer_id;
                $wishlist->product_id = $input->product_id;
                $wishlist->save();
            }
        }
        return ['status' => 200, 'message' => 'Save record!'];
    }
}