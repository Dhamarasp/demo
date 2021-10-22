<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use App\Models\Banner;
use App\Models\District;
use App\Models\ShippingPrice;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductType;
use Yajra\Datatables\Datatables;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;
use Kredivo;

class HomeController extends BaseController{
    public function index(Request $request){
        return view('pages/index');
    }

    public function indexAppsVersion(Request $request){
        Cookie::queue(Cookie::forever('apps-version', 'true'));
        return redirect('/');
    }

    public function indexError404(Request $request){
        return view('errors/404');
    }

    public function indexHome(Request $request){
        $lang_id = true;
        $media_url = env('MEDIA_URL', '');
        $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $home_banners = Banner::where('banner_type_id', 1)->get();
        $promo_products = Product::select(
                                'products.product_id', 
                                'product_image_url',
                                'product_code', 
                                'product_type_name', 
                                'product_selling_price',
                                DB::raw('product_diskon_price as product_price'))
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
                            ->whereRaw('? BETWEEN product_start_date_diskon_price AND product_end_date_diskon_price', [$today])
                            ->orderBy('product_start_date_diskon_price', 'desc')
                            ->get();;
        $product_categories = array();
        $latest_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_type', 'feed')->orWhere('post_categories.post_category_type','promo')->orderBy('posts.created_at', 'desc')->get();
        // $company_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_name', 'Perusahaan')->orderBy('posts.created_at', 'desc')->get();
        // $testimoni_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_name', 'Konsumen Testimonial')->orderBy('posts.created_at', 'desc')->get();
        // $csr_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_name', 'CSR')->orderBy('posts.created_at', 'desc')->get();
        // $artikel_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_name', 'Artikel')->orderBy('posts.created_at', 'desc')->get();
        $feed_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_id', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_type', 'feed')->orderBy('posts.created_at', 'desc')->get();
        $promo_posts = Post::select('posts.post_id', 'posts.post_image_url','posts.post_title', 'post_categories.post_category_id', 'post_categories.post_category_name', 'posts.created_at')->join('post_categories', 'post_categories.post_category_id', '=', 'posts.post_category_id')->where('post_categories.post_category_type', 'promo')->orderBy('posts.created_at', 'desc')->get();
        $new_products = Product::select(
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
                            ->limit(4)
                            ->orderBy('products.created_at', 'desc')
                            ->get();

        $post_categories = PostCategory::where('post_category_type', 'feed')->orderBy('post_category_id', 'desc')->get();
        $feed_categories = PostCategory::where('post_category_type', 'feed')->get();
        $promo_categories = PostCategory::where('post_category_type', 'promo')->get();
        if(Cookie::get('newsletter') != 'true'){
            Cookie::queue(Cookie::make('newsletter', 'true', 900));
        }
        return view('pages/home', compact('home_banners', 'promo_products', 'product_categories','latest_posts', 'feed_posts', 'promo_posts','post_categories', 'feed_categories','promo_categories', 'new_products', 'media_url'));
    }

    public function commonList(Request $request){

        $list_data = Gallery::select('gallery_id', 'gallery_name', 'gallery_url', 'gallery_type', 'updated_at')
                            ->orderby('updated_at', 'desc')
                            ->get();

        return Datatables::of($list_data)
                ->addColumn('image', function($item){
                    $data = array(
                        'src' => $item->gallery_url,
                        'alt' => $item->gallery_name,
                        'date' => with(new Carbon($item->updated_at))->format('j M Y H:i ').' WIB',
                        'type' => $item->gallery_type
                    );
                    return $data;
                })
                ->addColumn('action', function($item){
                    $data = array(
                        'id' =>$item->gallery_id
                    );
                    return $data;
                })
                ->make(true);
    }

    public function actionSave(Request $request){
        $input = (object) $request->input();

        $gallery = new Gallery;
        $gallery->gallery_type = $input->gallery_type;
        $gallery->gallery_name = $input->gallery_name;
        $gallery->gallery_url = $input->gallery_url;
        $gallery->save();

        return ['status' => 200, 'message' => 'Successfully save record!'];
    }

    public function actionDelete(Request $request){
        $input = (object) $request->input();
        if($item = Gallery::find($input->gallery_id)){
            $gallery = $item;
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }

        if($gallery->delete()){
            return ['status' => 200, 'message' => 'Successfully delete record!'];
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }
    }
}