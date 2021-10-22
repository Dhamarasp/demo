<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\City;
use App\Models\CityRo;
use App\Models\District;
use App\Models\Province;
use App\Models\ShippingAddress;
use App\Models\ShippingPrice;
use App\Models\ShippingPriceNew;
// use App\Models\ShippingPricejnt;
use App\Models\ShippingPricejtr;
use App\Models\ShippingService;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

class AddressController extends BaseController{
    public function indexList(Request $request){
        $customer = Auth::user();

        $shipping_addresses = ShippingAddress::select('shipping_address_id',
                                                        'shipping_address_name',
                                                        'shipping_address_customer_name',
                                                        'shipping_address_phone',
                                                        'shipping_address_text',
                                                        'province_name',
                                                        'city_name',
                                                        'district_name',
                                                        'postal_code')
                                                ->join('provinces', 'provinces.province_id', '=', 'shipping_addresses.province_id')
                                                ->join('cities', 'cities.city_id', '=', 'shipping_addresses.city_id')
                                                ->join('districts', 'districts.district_id', '=', 'shipping_addresses.district_id')
                                                ->where(['customer_id' => $customer->customer_id, 'shipping_addresses.is_active' => 1])
                                                ->get();
        return view('pages/account/address', compact('shipping_addresses'));
    }

    public function indexManage(Request $request, $shipping_address_id = 0){
        $input = (object) $request->input();

        $customer = Auth::user();

        if($item = ShippingAddress::where(['shipping_address_id' => $shipping_address_id, 'customer_id' => $customer->customer_id, 'is_active' => 1])->first()){
            $address = $item;
        }else{
            $address = null;
        }
        $provinces = Province::where('is_active', 1)->orderBy('province_name', 'asc')->get();
        $cities = City::where('is_active', 1)->orderBy('city_name', 'asc')->get();
        $districts = District::where('is_active', 1)->orderBy('district_name', 'asc')->get();
        return view('pages/account/manage-address', compact('provinces', 'cities', 'districts', 'address'));
    }

    public function indexSelectShippingAddress(Request $request){
        $customer = Auth::user();

        $shipping_addresses = ShippingAddress::select('shipping_address_id',
                                                        'shipping_address_name',
                                                        'shipping_address_customer_name',
                                                        'shipping_address_phone',
                                                        'shipping_address_text',
                                                        'province_name',
                                                        'city_name',
                                                        'district_name',
                                                        'postal_code')
                                                ->join('provinces', 'provinces.province_id', '=', 'shipping_addresses.province_id')
                                                ->join('cities', 'cities.city_id', '=', 'shipping_addresses.city_id')
                                                ->join('districts', 'districts.district_id', '=', 'shipping_addresses.district_id')
                                                ->where(['customer_id' => $customer->customer_id, 'shipping_addresses.is_active' => 1])
                                                ->get();
        return view('pages/order/shipping-address', compact('shipping_addresses'));
    }

    public function indexSelectShippingService(Request $request){
        $input = (object) $request->input();
        $customer = Auth::user();

        if($cart = Cart::join('shipping_addresses', 'shipping_addresses.shipping_address_id', '=', 'carts.shipping_address_id')->where('carts.customer_id', $customer->customer_id)->first()){
            $cart_details = CartDetail::selectRaw('(product_quantity * product_weight) as AGGREGATE')->join('products', 'products.product_id', '=', 'cart_details.product_id')->where('cart_id', $cart->cart_id)->get();
            $total_weight_before_processing = $cart_details->sum('AGGREGATE');
            $shipping_services_1 = ShippingPrice::join('shipping_services', 'shipping_services.shipping_service_id', '=', 'shipping_prices.shipping_service_id')
                                                    ->where(['district_id' => $cart->district_id])
                                                    ->get();
            $district = District::find($cart->district_id);
            $city = City::find($district->city_id);
            $city_ro = CityRo::where('city_name', 'LIKE', $city->city_name.'%')->first();

            $url = 'pro.rajaongkir.com/api/cost';
            $key = 'fa6e18be505b7f76111e2d841c5e9084';
            
            $params = 'origin=444&originType=city&destination='. $city_ro->city_id .'&destinationType=city&weight=1000&courier=tiki:wahana:ninja';
            $result = $this->http_curl($url, $key, $params);
            $result_data = (object) json_decode($result);
            $shipping_service_3 = new Collection();
            foreach($result_data->rajaongkir->results as $shipping){
                if(!empty($shipping->costs[0])){
                    $shipping = (object) $shipping;
                    if($shipping->code == 'tiki'){
                        $shipping_service_id = 6;
                    }else if($shipping->code == 'wahana'){
                        $shipping_service_id = 5;
                    }else if($shipping->code == 'ninja'){
                        $shipping_service_id = 4;
                    }

                    $data_shipping_service = ShippingService::find($shipping_service_id);
                    $data_shipping_service->destination = $result_data->rajaongkir->destination_details->city_name;
                    $data_shipping_service->shipping_price_unit = $shipping->costs[0]->cost[0]->value;
                    $data_shipping_service->shipping_etl = $shipping->costs[0]->cost[0]->etd;
                    $data_shipping_service->is_active = 1;

                    $shipping_service_3->push($data_shipping_service);
                }
            }
            
            $destination = District::select('cities.city_name', 'districts.district_name')->join('cities', 'cities.city_id', '=', 'districts.city_id')->where('district_id', $cart->district_id)->first();
            $shipping_services_2 = ShippingPriceNew::join('shipping_services', 'shipping_services.shipping_service_id', '=', 'shipping_prices_new.shipping_service_id')
            ->where('destination', 'LIKE', '%'.$destination->city_name.'%')
            ->get();

            $shipping_services_manual = ShippingService::where('shipping_service_id', 8)->get();

            if(strpos($destination->district_name, '-') !== false ){
                $jtr_district_name = explode('-', $destination->district_name)[0];
            }else{
                $jtr_district_name = $destination->district_name;
            }
            $shipping_services_jtr = ShippingPricejtr::join('shipping_services', 'shipping_services.shipping_service_id', '=', 'shipping_prices_jtr.shipping_service_id')->where('shipping_prices_jtr.shipping_service_id', 9)->where('city', 'LIKE', '%'.$destination->city_name.'%')->where('district', 'LIKE', '%'.$jtr_district_name.'%')->get();
            
            // if(strpos($destination->district_name, '-') !== false ){
            //     $jnt_district_name = explode('-', $destination->district_name)[0];
            // }else{
            //     $jnt_district_name = $destination->district_name;
            // }
            // $shipping_services_jnt = ShippingPricejnt::join('shipping_services', 'shipping_services.shipping_service_id', '=', 'shipping_prices_jnt.shipping_service_id')->where('shipping_prices_jnt.shipping_service_id', 10)->where('city', 'LIKE', '%'.$destination->city_name.'%')->where('district', 'LIKE', '%'.$jnt_district_name.'%')->get();

            $shipping_services = $shipping_services_1->merge($shipping_services_jtr);
            // $shipping_services = $shipping_services->merge($shipping_services_2);
            $shipping_services = $shipping_services->merge($shipping_service_3);
            $shipping_services = $shipping_services->merge($shipping_services_manual);

            $products = CartDetail::selectRaw('product_weight, product_length, product_width, product_height, product_quantity')->join('products', 'products.product_id', '=', 'cart_details.product_id')->where('cart_id', $cart->cart_id)->get();
            foreach($shipping_services as $key => $shipping_service){
                if($shipping_service->shipping_service_id == 1 || $shipping_service->shipping_service_id == 2){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 4000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                // }else if($shipping_service->shipping_service_id == 3){
                //     $total_weighted_by_shipping = 0;
                //     foreach ($products as $product) {
                //         $volume_product = $product->product_length * $product->product_width * $product->product_height;
                //         $weighted_product_by_shipping = $product->product_quantity * $volume_product / 4000;
                //         $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                //     }  
                }else if($shipping_service->shipping_service_id == 4){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 6000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                }else if($shipping_service->shipping_service_id == 5){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 6000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                }else if($shipping_service->shipping_service_id == 6){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 6000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                }else if($shipping_service->shipping_service_id == 7){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 4000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                }else if($shipping_service->shipping_service_id == 8){
                    $shipping_service->shipping_price_unit = 0;
                    $total_weighted_by_shipping = 0;
                }else if($shipping_service->shipping_service_id == 9){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 4000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                }else if($shipping_service->shipping_service_id == 10){
                    $total_weighted_by_shipping = 0;
                    foreach ($products as $product) {
                        $volume_product = $product->product_length * $product->product_width * $product->product_height;
                        $weighted_product_by_shipping = $product->product_quantity * $volume_product / 4000;
                        $total_weighted_by_shipping = $total_weighted_by_shipping + $weighted_product_by_shipping;
                    }
                }else{
                    $total_weighted_by_shipping = $total_weight_before_processing;
                }

                if($total_weight_before_processing > $total_weighted_by_shipping){
                    $shipping_service->total_weight_shipping = $total_weight_before_processing;
                }else{
                    $shipping_service->total_weight_shipping = $total_weighted_by_shipping;
                }

                if($shipping_service->shipping_service_id == 9){
                    if($shipping_service->total_weight_shipping <= 10){
                        $shipping_service->shipping_price_unit = $shipping_service->price_1;
                    }else if($shipping_service->total_weight_shipping <= 50){
                        $shipping_service->shipping_price_unit = $shipping_service->price_2;
                    }else{
                        $shipping_service->shipping_price_unit = $shipping_service->price_3;
                    }
                }

                // if($shipping_service->shipping_service_id == 10){
                //     if($shipping_service->total_weight_shipping <= 10){
                //         $shipping_service->shipping_price_unit = $shipping_service->price_1;
                //     }else if($shipping_service->total_weight_shipping <= 50){
                //         $shipping_service->shipping_price_unit = $shipping_service->price_2;
                //     }else{
                //         $shipping_service->shipping_price_unit = $shipping_service->price_3;
                //     }
                // }

                $shipping_service->total_shipping_price = ceil($shipping_service->total_weight_shipping * $shipping_service->shipping_price_unit);

                if($shipping_service->shipping_service_id == 4 && $shipping_service->total_weight_shipping > 50){
                    unset($shipping_services[$key]);
                }

                if($shipping_service->shipping_service_id == 5 && $shipping_service->total_weight_shipping > 50){
                    unset($shipping_services[$key]);
                }

                if($shipping_service->shipping_service_id == 6 && $shipping_service->total_weight_shipping > 75){
                    unset($shipping_services[$key]);
                }
            }

            return view('pages/order/shipping-service', compact('shipping_services'));
        }else{
            return abort(404);
        }
    }

    public function actionSelectShippingAddress(Request $request){
        $input = (object) $request->input();
        $customer = Auth::user();

        if($cart = Cart::where('customer_id', $customer->customer_id)->first()){
            $cart->shipping_address_id = $input->shipping_address_id;
            $cart->save();

            return ['status' => 200, 'message' => 'Next, select shipping service!'];
        }else{
            return abort(404);
        }
    }

    public function actionChangeProvince(Request $request){
        $input = (object) $request->input();
        
        return City::where('province_id', $input->province_id)->where('is_active', 1)->orderBy('city_name', 'asc')->get();
    }

    public function actionChangeCity(Request $request){
        $input = (object) $request->input();
        
        return District::where('city_id', $input->city_id)->where('is_active', 1)->orderBy('district_name', 'asc')->get();
    }

    public function actionSelectShippingService(Request $request){
        $input = (object) $request->input();
        $customer = Auth::user();

        if($cart = Cart::where('customer_id', $customer->customer_id)->first()){
            $cart->shipping_service_id = $input->shipping_service_id;
            $cart->shipping_price_unit = $input->shipping_price_unit;
            $cart->save();

            return ['status' => 200, 'message' => 'Next, select payment method!'];
        }else{
            return abort(404);
        }
    }

    public function actionSave(Request $request){
        $input = (object) $request->input();

        $validator = Validator::make($request->all(), [
            'shipping_address_name' => 'required|max:255',
            'shipping_address_customer_name' => 'required|max:255',
            'shipping_address_phone' => 'required|max:255',
            'shipping_address_text' => 'required',
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'postal_code' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return ['status' => 201, 'message' => $validator->errors()->first()];
        }

        $customer = Auth::user();

        if($address = ShippingAddress::find($input->shipping_address_id)){
            $address->customer_id                       = $customer->customer_id;
            $address->shipping_address_name             = $input->shipping_address_name;
            $address->shipping_address_customer_name    = $input->shipping_address_customer_name;
            $address->shipping_address_phone            = $input->shipping_address_phone;
            $address->shipping_address_text             = $input->shipping_address_text;
            $address->province_id                       = $input->province_id;
            $address->city_id                           = $input->city_id;
            $address->district_id                       = $input->district_id;
            $address->postal_code                       = $input->postal_code;
            $address->map_coordinate                    = null;
            $address->is_active                         = 1;
            $address->save();
        }else{
            $address = new ShippingAddress;
            $address->customer_id                       = $customer->customer_id;
            $address->shipping_address_name             = $input->shipping_address_name;
            $address->shipping_address_customer_name    = $input->shipping_address_customer_name;
            $address->shipping_address_phone            = $input->shipping_address_phone;
            $address->shipping_address_text             = $input->shipping_address_text;
            $address->province_id                       = $input->province_id;
            $address->city_id                           = $input->city_id;
            $address->district_id                       = $input->district_id;
            $address->postal_code                       = $input->postal_code;
            $address->map_coordinate                    = null;
            $address->is_active                         = 1;
            $address->save();
        }

        return ['status' => 200, 'message' => 'Successfully save record!'];
    }

    public function http_curl($url, $key, $request){
		$curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ".$key
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
	}
}