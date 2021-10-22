<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

use Akulaku;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\TransactionDetail;
use App\Models\Wishlist;
use Yajra\Datatables\Datatables;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

use Stichoza\GoogleTranslate\TranslateClient;

class ProductController extends BaseController
{
    public function indexList(Request $request)
    {
        $product_types = ProductType::get();

        return view('pages/products', compact('product_types'));
    }

    public function indexGetProducts(Request $request)
    {
        $input = (object) $request->input();
        $lang_id = true;
        $media_url = env('MEDIA_URL', '');
        $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $products = Product::select(
            'products.product_id',
            'product_image_url',
            'product_code',
            'product_type_name'
        )
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
                            });
        
        if (!empty($input->category)) {
            $products = $products->where('products.product_type_id', $input->category);
        }

        if (!empty($input->sort)) {
            switch ($input->sort) {
                case 'newest': $products = $products->orderBy('products.created_at', 'desc'); break;
                case 'asc': $products = $products->orderBy('products.product_name_id', 'asc'); break;
                case 'cheapest': $products = $products->orderBy('products.product_selling_price', 'asc'); break;
                case 'cost': $products = $products->orderBy('products.product_selling_price', 'desc'); break;
                default: $products = $products->orderBy('products.created_at', 'desc'); break;
            }
        }

        $products = $products->get();

        return view('partials/products-fragment', compact('products', 'media_url'));
    }

    public function indexSearchProducts(Request $request)
    {
        $input = (object) $request->input();
        $lang_id = true;
        $media_url = env('MEDIA_URL', '');
        $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $products = Product::select(
            'products.product_id',
            'product_image_url',
            'product_code',
            'product_type_name'
        )
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
                            });
        
        if (!empty($input->q)) {
            $products = $products->where('products.product_name_id', 'like', '%'.$input->q.'%')
                        ->orWhere('products.product_name_en', 'like', '%'.$input->q.'%');
        }

        $products = $products->get();

        return view('pages/search-product', compact('products', 'media_url'));
    }

    public function indexDetail(Request $request, $product_id = 0)
    {
        $customer = Auth::user();
        $lang_id = true;
        $media_url = env('MEDIA_URL', '');
        $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
        $lang = $request->input('lang');

        $product = Product::select(
            'products.product_id',
            'product_code',
            'product_type_name',
            'product_weight',
            'product_length',
            'product_stock',
            'product_width',
            'product_height',
            'product_selling_price'
        )
        ->selectRaw('IF (? BETWEEN product_start_date_diskon_price AND product_end_date_diskon_price, product_diskon_price, product_selling_price) as product_price', [$today])
        ->when($lang_id, function ($query) {
            return $query->selectRaw('product_name_id as product_name, product_description_id as product_description');
        }, function ($query) {
            return $query->selectRaw('product_name_en as product_name, product_description_en as product_description');
        })
        ->join('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
        ->where('product_id', $product_id)
        ->first();
        if ($product) {
            $product_images = ProductImage::where('product_id', $product_id)->get();
            if ($customer) {
                $wishlist = Wishlist::where(['customer_id' => $customer->customer_id, 'product_id' => $product->product_id])->first();
            } else {
                $wishlist = Wishlist::where(['customer_id' => 0, 'product_id' => $product->product_id])->first();
            }

            if (!empty($lang) && $lang != 'id') {
                $tr = new TranslateClient(); // Default is from 'auto' to 'en'
                $tr->setSource('id'); // Translate from English
                $tr->setTarget($lang); // Translate to Georgian
                $multi_text = new Collection();
                $multi_text->description = $tr->translate($product->product_description);
                $multi_text->category = $tr->translate('Kategori: '.$product->product_type_name);
                $multi_text->varian = $tr->translate('Kapasitas lainnya');
                $multi_text->anti_karat = $tr->translate('Produk anti karat (Optional)');
                $multi_text->pre_order = $tr->translate('Alat ini tidak ready stock,</b> <br>silakan melakukan pre-order saat membelinya');
                $multi_text->other_text = $tr->translate('Deskripsi, Berat, Ukuran');
            } else {
                $multi_text = null;
            }

            $transaction_detail_count = TransactionDetail::where('product_id', $product_id)->sum('product_quantity');

            $installment_info = Akulaku::getInstallmentInfo($product->product_id, $product->product_price);

            $installment_product = (array) ((array) $installment_info['data'])[$product->product_id];
            
            return view('pages/detail-product', compact('product', 'product_images', 'media_url', 'wishlist', 'multi_text', 'transaction_detail_count', 'installment_product'));
        } else {
            return abort(404);
        }
    }

    public function commonList(Request $request)
    {
        $list_data = Product::select(
            'products.product_id',
            'product_image_url',
            'product_code',
            'product_name_id',
            'product_name_en',
            'product_type_name',
            'product_selling_price',
            'product_diskon_price',
            'product_start_date_diskon_price',
            'product_end_date_diskon_price'
        )
                        ->join('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
                        ->leftJoin('product_images', function ($join) {
                            $join->on('product_images.product_id', '=', 'products.product_id')
                                 ->where('product_images.product_image_order', 0)
                                 ->whereNull('product_images.deleted_at');
                        })
                        ->orderBy('product_code', 'asc')
                        ->get();

        return Datatables::of($list_data)
                ->editColumn('product_image_url', function ($item) {
                    if (empty($item->product_image_url)) {
                        return 'https://bulma.io/images/placeholders/96x96.png';
                    } else {
                        return url('media').'/'.$item->product_image_url;
                    }
                })
                ->addColumn('product_name', function ($item) {
                    return $item->product_name_en.' ('.$item->product_name_id.')';
                })
                ->addColumn('product_price', function ($item) {
                    $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                    if (!empty($item->product_start_date_diskon_price) && !empty($item->product_end_date_diskon_price)) {
                        if (strtotime($item->product_start_date_diskon_price) < strtotime($today) && strtotime($today) < strtotime($item->product_end_date_diskon_price)) {
                            return $item->product_diskon_price;
                        } else {
                            return $item->product_selling_price;
                        }
                    } else {
                        return $item->product_selling_price;
                    }
                })
                ->addColumn('action', function ($item) {
                    $data = array(
                        'id' => $item->product_id,
                        'code' => $item->product_code
                    );
                    return $data;
                })
                ->removeColumn('product_name_id')
                ->removeColumn('product_name_en')
                ->removeColumn('product_selling_price')
                ->removeColumn('product_diskon_price')
                ->removeColumn('product_start_date_diskon_price')
                ->removeColumn('product_end_date_diskon_price')
                ->make(true);
    }

    public function actionSave(Request $request)
    {
        $input = (object) $request->input();

        $validator = Validator::make($request->all(), [
            'product_type_id' => 'required|integer',
            'product_code' => 'required|max:255',
            'product_name_id' => 'required|max:255',
            'product_name_en' => 'required|max:255',
            'product_description_id' => 'required',
            'product_description_en' => 'required',
            'product_weight' => 'required|max:255',
            'product_length' => 'required|max:255',
            'product_width' => 'required|max:255',
            'product_height' => 'required|max:255',
            'product_production_price' => 'required|max:255',
            'product_selling_price' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => 'Not valid input'];
        }

        if ($product = Product::find($input->product_id)) {
            $product->product_type_id           = $input->product_type_id;
            $product->product_code              = $input->product_code;
            $product->product_name_id           = $input->product_name_id;
            $product->product_name_en           = $input->product_name_en;
            $product->product_description_id    = $input->product_description_id;
            $product->product_description_en    = $input->product_description_en;
            $product->product_weight            = $input->product_weight;
            $product->product_length            = $input->product_length;
            $product->product_width             = $input->product_width;
            $product->product_height            = $input->product_height;
            $product->product_production_price  = $input->product_production_price;
            $product->product_selling_price     = $input->product_selling_price;
            $product->save();

            $redirect = false;
        } else {
            $product = new Product;
            $product->product_type_id           = $input->product_type_id;
            $product->product_code              = $input->product_code;
            $product->product_name_id           = $input->product_name_id;
            $product->product_name_en           = $input->product_name_en;
            $product->product_description_id    = $input->product_description_id;
            $product->product_description_en    = $input->product_description_en;
            $product->product_stok              = 0;
            $product->product_weight            = $input->product_weight;
            $product->product_length            = $input->product_length;
            $product->product_width             = $input->product_width;
            $product->product_height            = $input->product_height;
            $product->product_production_price  = $input->product_production_price;
            $product->product_selling_price     = $input->product_selling_price;
            $product->save();

            $redirect = true;
        }

        return ['status' => 200, 'message' => 'Successfully save record!', 'redirect' => $redirect];
    }
}
