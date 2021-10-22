<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\ShippingPrice;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionInvoice;
use App\Models\Voucher;
use App\Models\Setting;

use Auth;
use Carbon\Carbon;
use DB;
use Validator;

class CartController extends BaseController
{
    public function indexList(Request $request)
    {
        $customer = Auth::user();

        if ($cart = Cart::where('customer_id', $customer->customer_id)->first()) {
        } else {
            $cart = new Cart;
            $cart->customer_id = $customer->customer_id;
            $cart->save();
        }
        
        $lang_id = true;
        $media_url = env('MEDIA_URL', '');

        $cart_details = CartDetail::select(
            'cart_detail_id',
            'products.product_id',
            'product_image_url',
            'product_code',
            'product_type_name',
            'product_price',
            'product_quantity'
        )
                                    ->when($lang_id, function ($query) {
                                        return $query->selectRaw('product_name_id as product_name');
                                    }, function ($query) {
                                        return $query->selectRaw('product_name_en as product_name');
                                    })
                                    ->join('products', 'products.product_id', '=', 'cart_details.product_id')
                                    ->join('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
                                    ->leftJoin('product_images', function ($join) {
                                        $join->on('product_images.product_id', '=', 'products.product_id')
                                            ->where('product_images.product_image_order', 0)->whereNull('product_images.deleted_at');
                                    })
                                    ->where('cart_id', $cart->cart_id)
                                    ->orderBy('cart_detail_id', 'desc')
                                    ->get();
        
        return view('pages/order/cart', compact('cart_details', 'media_url'));
    }

    public function indexSelectPayment(Request $request)
    {
        $customer = Auth::user();
        if ($cart = Cart::join('shipping_addresses', 'shipping_addresses.shipping_address_id', '=', 'carts.shipping_address_id')->where('carts.customer_id', $customer->customer_id)->first()) {
            $cart_details = CartDetail::selectRaw('(product_quantity * product_weight) as aggregate_weight, (product_quantity * product_price) as aggregate_price')
                                        ->join('products', 'products.product_id', '=', 'cart_details.product_id')
                                        ->where('cart_id', $cart->cart_id)
                                        ->get();
            // if($cart->shipping_service_id == 1 || $cart->shipping_service_id == 2){
            //     $shipping_price_unit = ShippingPrice::where(['district_id' => $cart->district_id, 'shipping_service_id' => $cart->shipping_service_id])->first()->shipping_price_unit;
            // }else{
            //     $shipping_price_unit = $cart->shipping_price_unit;
            // }
                                        
            $total_product_price = $cart_details->sum('aggregate_price');
            $total_weight = $cart_details->sum('aggregate_weight');
            // $total_shipping_price = $total_weight * $shipping_price_unit;
            $total_shipping_price = $cart->shipping_price_unit;

            DB::table('carts')->where('cart_id', $cart->cart_id)->update(['voucher_id' => null, 'discount' => 0]);

            // if(env('APP_ENV', 'local') == 'production'){
            //     $url = 'https://api.espay.id/rest/merchant/merchantinfo';
            //     $key = '48c9a2355a3791a25cc2436fdf21a9e1';
            // }else{
            //     $url = 'https://sandbox-api.espay.id/rest/merchant/merchantinfo';
            //     $key = '4484aa3c9b4dabbbd24685fa8b800eec';
            // }

            // $result = $this->http_curl($url, 'key='.$key);
            // $result_data = (object) json_decode($result);
            // if($result_data->error_code === '0000'){
            //     $payment_methods = $result_data->data;
            //     $payment_methods = collect($payment_methods)->sortBy('productName')->all();
            // }else{
            $payment_methods = array();
            // }

            return view('pages/order/payment-method', compact('payment_methods', 'total_product_price', 'total_weight', 'total_shipping_price'));
        } else {
            return abort(404);
        }
    }

    public function indexReview(Request $request)
    {
        $customer = Auth::user();

        if ($cart = Cart::join('shipping_addresses', 'shipping_addresses.shipping_address_id', '=', 'carts.shipping_address_id')->where('carts.customer_id', $customer->customer_id)->first()) {
            $lang_id = true;
            $media_url = env('MEDIA_URL', '');

            $cart_details = CartDetail::select(
                'cart_detail_id',
                'products.product_id',
                'product_image_url',
                'product_code',
                'product_type_name',
                'product_price',
                'product_quantity'
            )
                                        ->selectRaw('(product_quantity * product_weight) as aggregate_weight, 
                                                    (product_quantity * product_price) as aggregate_price, 
                                                    (product_quantity * product_length * product_width * product_height) as aggregate_volume')
                                        ->when($lang_id, function ($query) {
                                            return $query->selectRaw('product_name_id as product_name');
                                        }, function ($query) {
                                            return $query->selectRaw('product_name_en as product_name');
                                        })
                                        ->join('products', 'products.product_id', '=', 'cart_details.product_id')
                                        ->join('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
                                        ->leftJoin('product_images', function ($join) {
                                            $join->on('product_images.product_id', '=', 'products.product_id')
                                                ->where('product_images.product_image_order', 0)->whereNull('product_images.deleted_at');
                                        })
                                        ->where('cart_id', $cart->cart_id)
                                        ->orderBy('cart_detail_id', 'desc')
                                        ->get();

            $shipping_service = ShippingPrice::find($cart->shipping_service_id);
            $shipping_service_name = $shipping_service->shipping_service_name;

            $total_product_price = $cart_details->sum('aggregate_price');
            
            $total_weight = ceil($cart_details->sum('aggregate_weight'));
            // $total_shipping_price = $total_weight * $cart->shipping_price_unit;
            $total_shipping_price = $cart->shipping_price_unit;
            
            $total_volume = ceil($cart_details->sum('aggregate_volume') / (100 * 100 * 100));
            $total_pallet_price = $total_volume * 100000;
            // $total_pallet_price = 0;

            if($total_pallet_price > 1000000){
                $total_pallet_price = 1000000;
            }

            $subtotal = $total_product_price + $total_shipping_price + $total_pallet_price;

            if (empty($cart->voucher_id)) {
                $voucher_price = 0;
            } else {
                $voucher_price = $cart->discount;
            }
            $data = compact(
                'cart',
                'cart_details',
                'media_url',
                'shipping_service_name',
                'total_shipping_price',
                'total_weight',
                'total_pallet_price',
                'subtotal',
                'voucher_price'
            );
            return view('pages/order/review', $data);
        } else {
            return abort(404);
        }
    }

    public function actionSelectPayment(Request $request)
    {
        $input = (object) $request->input();
        $customer = Auth::user();

        if ($cart = Cart::where('customer_id', $customer->customer_id)->first()) {
            $cart->payment_method = $input->payment_method;
            $cart->save();

            return ['status' => 200, 'message' => 'Please review your order!'];
        } else {
            return abort(404);
        }
    }

    public function actionUseVoucher(Request $request)
    {
        $input = (object) $request->input();
        $customer = Auth::user();
        $today = Carbon::now();

        if ($cart = Cart::where('customer_id', $customer->customer_id)->first()) {
            $cart_details = CartDetail::where('cart_id', $cart->cart_id)->get();
            $subtotal = 0;
            foreach ($cart_details as $cart_detail) {
                $subtotal = $cart_detail->product_price * $cart_detail->product_quantity;
            }

            if ($voucher = Voucher::where('voucher_code', $input->voucher_code)->where('voucher_start_date', '<=', $today)->where('voucher_end_date', '>=', $today)->first()) {
                if ($voucher->voucher_quantity <= $voucher->voucher_used) {
                    return ['status' => 200, 'message' => 'Voucher telah habis digunakan!'];
                }

                if ($voucher->voucher_minimal_subtotal > $subtotal) {
                    return ['status' => 200, 'message' => 'Syarat minimal pembelian IDR '.number_format($voucher->voucher_minimal_subtotal)];
                }

                if ($voucher->voucher_type == 1) {
                    $discount = $voucher->voucher_discount;
                } elseif ($voucher->voucher_type == 2) {
                    if ($subtotal > $voucher->voucher_maximal_subtotal) {
                        $discount = $voucher->voucher_maximal_subtotal * $voucher->voucher_discount / 100;
                    } else {
                        $discount = $subtotal * $voucher->voucher_discount / 100;
                    }
                } else {
                    $discount = 0;
                }

                $cart->discount = $discount;
                $cart->voucher_id = $voucher->voucher_id;
                $cart->save();
                return ['status' => 200, 'message' => 'Voucher berhasil digunakan ...'];
            } else {
                return ['status' => 201, 'message' => 'Kode voucher tidak ditemukan ...'];
            }
        } else {
            return abort(404);
        }
    }

    public function actionDeleteVoucher(Request $request)
    {
        $input = (object) $request->input();
        $customer = Auth::user();

        if ($cart = Cart::where('customer_id', $customer->customer_id)->first()) {
            $cart->discount = 0;
            $cart->voucher_id = null;
            $cart->save();
            return ['status' => 200, 'message' => 'Voucher berhasil dihapus ...'];
        } else {
            return abort(404);
        }
    }

    public function actionCheckout(Request $request)
    {
        $input = (object) $request->input();

        $customer = Auth::user();
        if ($cart = Cart::where('customer_id', $customer->customer_id)->whereNotNull('shipping_address_id')->whereNotNull('shipping_service_id')->whereNotNull('payment_method')->first()) {
            $shipping_address = ShippingAddress::find($cart->shipping_address_id);
            $cart_details = CartDetail::select(
                'products.product_id',
                'product_price',
                'discount_id',
                'product_quantity'
            )
                        ->selectRaw('(product_quantity * product_weight) as aggregate_weight, 
                                    (product_quantity * product_price) as aggregate_price, 
                                    (product_quantity * product_length * product_width * product_height) as aggregate_volume')
                        ->join('products', 'products.product_id', '=', 'cart_details.product_id')
                        ->where('cart_id', $cart->cart_id)->get();

            if ($cart_details->first()) {
                $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                if(!empty($input->check_asuransi)){
                    $assurance     = 59000;
                }else{
                    $assurance = 0;
                }

                $transaction = new Transaction;
                $transaction->customer_id           = $cart->customer_id;
                $transaction->shipping_address_id   = $cart->shipping_address_id;
                $transaction->shipping_service_id   = $cart->shipping_service_id;
                $transaction->payment_method        = $cart->payment_method;
                $transaction->transaction_status    = 0;
                $transaction->voucher_id            = $cart->voucher_id;
                $transaction->transaction_discount  = $cart->discount;
                $transaction->transaction_assurance = $assurance;
                $transaction->save();

                $transaction_details = array();
                foreach ($cart_details as $cart_detail) {
                    $transaction_detail = array(
                        'transaction_id'    => $transaction->transaction_id,
                        'product_id'        => $cart_detail->product_id,
                        'product_price'     => $cart_detail->product_price,
                        'product_quantity'  => $cart_detail->product_quantity,
                        'discount_id'       => $cart_detail->discount_id,
                        'created_at'        => $today,
                        'updated_at'        => $today
                    );
                    $transaction_details[] = $transaction_detail;
                }
                
                $total_product_price    = $cart_details->sum('aggregate_price');
                $total_weight           = $cart_details->sum('aggregate_weight');
                // $total_shipping_price   = $total_weight * $cart->shipping_price_unit;
                $total_shipping_price   = $cart->shipping_price_unit;
                $total_volume           = ceil($cart_details->sum('aggregate_volume') / (100 * 100 * 100));

                if(!empty($input->check_pallet)){
                    $total_pallet_price     = $total_volume * 100000;
                }else{
                    $total_pallet_price     = 0;
                }

                if($total_pallet_price > 1000000){
                    $total_pallet_price = 1000000;
                }

                if ($today->month < 10) {
                    $month_text = '0' . $today->month;
                } else {
                    $month_text = $today->month;
                }

                $transaction->transaction_number            = $transaction->transaction_id . 'CAT' . $month_text . $today->year;
                $transaction->transaction_subtotal          = $total_product_price;
                $transaction->transaction_shipping_price    = $total_shipping_price;
                $transaction->transaction_pallet_price      = $total_pallet_price;
                $transaction->save();

                $total  = 0;
                $total  += $transaction->transaction_subtotal;
                $total  -= $transaction->transaction_discount;
                $total  += $transaction->transaction_shipping_price;
                $total  += $transaction->transaction_pallet_price;
                $total  += $transaction->transaction_assurance;

                if($input->is_downpayment == 1){
                    $downpayment_value = 100;
                    $invoicename = 'Tagihan pelunasan';
                }else{
                    if ($setting_dp = Setting::where('setting_code', 'downpayment_value')->first()) {
                        $downpayment_value = $setting_dp->setting_value;
                    } else {
                        $downpayment_value = 50;
                    }
                    $invoicename = 'Tagihan awal sebesar '.$downpayment_value.'%';
                }
                $transaction_invoice = new TransactionInvoice;
                $transaction_invoice->transaction_invoice_number    = $transaction->transaction_number.'1';
                $transaction_invoice->transaction_id                = $transaction->transaction_id;
                $transaction_invoice->transaction_invoice_name      = $invoicename;
                $transaction_invoice->transaction_invoice_value     = $downpayment_value;
                $transaction_invoice->transaction_invoice_status    = 0;
                $transaction_invoice->transaction_invoice_balance   = $total;
                $transaction_invoice->transaction_invoice_amount    = ceil($downpayment_value / 100 * $transaction_invoice->transaction_invoice_balance);
                $transaction_invoice->save();

                if (!empty($transaction->voucher_id)) {
                    $voucher = Voucher::find($transaction->voucher_id);
                    $voucher->voucher_used = $voucher->voucher_used + 1;
                    $voucher->save();
                }

                TransactionDetail::insert($transaction_details);
                CartDetail::where('cart_id', $cart->cart_id)->delete();
                $cart->delete();
                return ['status' => 200, 'payment' => $transaction->payment_method, 'order' => $transaction->transaction_number];
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function actionEditCartQty(Request $request)
    {
        $input = (object) $request->input();

        if ($cart_detail = CartDetail::find($input->cart_detail_id)) {
            $new_quantity = $cart_detail->product_quantity + $input->product_adding;
            if ($new_quantity > 0) {
                $cart_detail->product_quantity = $cart_detail->product_quantity + $input->product_adding;
                $cart_detail->save();
                return ['status' => 200, 'message' => 'Succesfully adding quantity product on cart!', 'value' => $cart_detail->product_quantity];
            } else {
                return ['status' => 201, 'message' => 'Quantity can\'t empty!'];
            }
        } else {
            return abort(404);
        }
    }

    public function actionDeleteCartDetail(Request $request)
    {
        $input = (object) $request->input();

        if ($cart_detail = CartDetail::find($input->cart_detail_id)) {
            if ($cart_detail->delete()) {
                return ['status' => 200, 'message' => 'Succesfully remove product on cart!'];
            } else {
                return ['status' => 201, 'message' => 'Operation error'];
            }
        } else {
            return abort(404);
        }
    }

    public function actionAddToCart(Request $request)
    {
        $input = (object) $request->input();
        $customer = Auth::user();

        if ($product = Product::find($input->product_id)) {
            if ($item = Cart::where('customer_id', $customer->customer_id)->first()) {
                $cart = $item;
            } else {
                $cart = new Cart;
                $cart->customer_id = $customer->customer_id;
                $cart->save();
            }

            if (!empty($product->product_diskon_price)) {
                $today = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                if (strtotime($product->product_start_date_diskon_price) < strtotime($today) && strtotime($product->product_end_date_diskon_price) > strtotime($today)) {
                    $product_price = $product->product_diskon_price;
                } else {
                    $product_price = $product->product_selling_price;
                }
            } else {
                $product_price = $product->product_selling_price;
            }
            
            if ($cart_detail = CartDetail::where(['cart_id' => $cart->cart_id, 'product_id' => $product->product_id])->first()) {
                $cart_detail->product_quantity  = $cart_detail->product_quantity + 1;
                $cart_detail->save();
                return ['status' => 200, 'message' => 'Succesfully adding quantity product on cart!'];
            } else {
                $cart_detail = new CartDetail;
                $cart_detail->cart_id           = $cart->cart_id;
                $cart_detail->product_id        = $product->product_id;
                $cart_detail->product_price     = $product_price;
                $cart_detail->product_quantity  = 1;
                $cart_detail->save();
                return ['status' => 200, 'message' => 'This product added to cart!'];
            }
        } else {
            return abort(404);
        }
    }

    public function http_curl($url, $request)
    {
        $curl=curl_init($url);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        
        curl_setopt($curl, CURLOPT_HEADER, false);
        //curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //use http 1.1
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        
        //NOTE: skip SSL certificate verification (this allows sending request to hosts with self signed certificates, but reduces security)
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        
        //enable ssl version 3
        //this is added because mandiri ecash case that ssl version that have been not supported before
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        //save to temporary file (php built in stream), cannot save to php://memory
        $verbose = fopen('php://temp', 'rw+');
        curl_setopt($curl, CURLOPT_STDERR, $verbose);
         
        $response=curl_exec($curl);
        
        return $response;
    }
}
