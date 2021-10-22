<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Akulaku;

use App\Models\Customer;
use App\Models\Finance;
use App\Models\PaymentLog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionInvoice;
use App\Models\ShippingAddress;
use App\Models\ShippingService;
use App\Models\Product;

use Carbon\Carbon;

use Auth;
use DB;
use Kredivo;
use Validator;

class TransactionController extends BaseController{
    public function indexList(Request $request){
        $customer = Auth::user();
        $transactions = Transaction::where('customer_id', $customer->customer_id)->orderBy('created_at', 'desc')->get();
        return view('pages/list-transaction', compact('transactions'));
    }

    public function indexDetail(Request $request, $transaction_number = null){
        $customer = Auth::user();
        if($transaction = Transaction::where(['transaction_number' => $transaction_number, 'customer_id' => $customer->customer_id])->first()){

            $lang_id = true;
            $media_url = env('MEDIA_URL', '');

            $transaction_details = TransactionDetail::select(
                                            'transaction_detail_id',
                                            'products.product_id', 
                                            'product_image_url',
                                            'product_code', 
                                            'product_type_name',
                                            'product_price',
                                            'product_quantity')
                                        ->selectRaw('(product_quantity * product_weight) as aggregate_weight, 
                                                    (product_quantity * product_price) as aggregate_price, 
                                                    (product_quantity * product_length * product_width * product_height) as aggregate_volume')
                                        ->when($lang_id, function ($query) {
                                            return $query->selectRaw('product_name_id as product_name');
                                        }, function ($query) {
                                            return $query->selectRaw('product_name_en as product_name');
                                        })
                                        ->join('products', 'products.product_id', '=', 'transaction_details.product_id')
                                        ->join('product_types', 'product_types.product_type_id', '=', 'products.product_type_id')
                                        ->leftJoin('product_images', function ($join) {
                                            $join->on('product_images.product_id', '=', 'products.product_id')
                                                ->where('product_images.product_image_order', 0)->whereNull('product_images.deleted_at');
                                        })
                                        ->where('transaction_id', $transaction->transaction_id)
                                        ->orderBy('transaction_detail_id', 'desc')
                                        ->get();

            $shipping_address = ShippingAddress::select('shipping_address_id',
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
                                                ->where('shipping_address_id', $transaction->shipping_address_id)
                                                ->first();
            $shipping_service = ShippingService::find($transaction->shipping_service_id);
            $transaction_invoices = TransactionInvoice::where('transaction_id', $transaction->transaction_id)->get();

            return view('pages/detail-transaction', compact('transaction', 'transaction_details', 'media_url', 'shipping_service', 'shipping_address', 'transaction_invoices'));
        }else{
            abort(404);
        }
    }

    public function actionInquiry(Request $request){
        $input = (object) $request->input();
        try{
            // Your Credentials provided by Espay Team
            if(env('APP_ENV', 'local') == 'production'){
                $espay_password = 'SDIUHGWS';
                $espay_signature_key =  '1ae641s8cz83g1j9';
            }else{
                $espay_password = '3sp4ytEsT';
                $espay_signature_key =  'P4yMentGat3w4Y';
            }
    
            // Get the data from Espay request
            $signature_from_espay   = $input->signature;
            $rq_datetime            = $input->rq_datetime;
            $order_id               = $input->order_id;
            $password_server        = $input->password;
    
            // Construct the signature
            // Format: ##KEY##rq_datetime##order_id##mode##
            $key = '##' . $espay_signature_key . '##' . $rq_datetime . '##' . $order_id . '##' . 'INQUIRY' . '##';
    
            // Next, the string will have to be converted to UPPERCASE before hashing is done.
            $uppercase = strtoupper($key);
            $generated_signature = hash('sha256', $uppercase);
    
            // validate the password
            if ($espay_password == $password_server) {
    
                // Validate Signature
                if ($generated_signature == $signature_from_espay) {
    
                    // Validate the given order id from espay inquiry request
                    // from your db or persistent
                    if($transaction_invoice = TransactionInvoice::where(['transaction_invoice_number' => $order_id, 'transaction_invoice_status' => 0])->first()){
                        $transaction = Transaction::find($transaction_invoice->transaction_id);
                        $customer = Customer::find($transaction->customer_id);
                        return '0;Success;'. $order_id .';'. $transaction_invoice->transaction_invoice_amount .'.00;IDR;'.$transaction_invoice->transaction_invoice_name.' oleh '. $customer->customer_name .';'. date_format(date_create($transaction_invoice->created_at), 'Y/m/d H:i:s'). ';;Y';
                    }else{
                        // if order id not exist show plain reponse
                        return '1;Order Id Does Not Exist;;;;;';
    
                    }
                } else {
                    return '1;Invalid Signature Key;;;;;';
                }
            } else {
                // if password not true
                return '1;Merchant Failed to Identified;;;;;';
            }
        }catch(Exception $error){
            return '1;'. $error .';;;;;';
        }
    }
    public function actionPayment(Request $request){
        $input = (object) $request->input();
        
        $payment_log = new PaymentLog;
        $payment_log->payment_log_content   = json_encode($input);
        $payment_log->created_at            = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
        $payment_log->save();
        
        // Your Credentials provided by Espay Team
        if(env('APP_ENV', 'local') == 'production'){
            $espay_password = 'SDIUHGWS';
            $espay_signature_key =  '1ae641s8cz83g1j9';
        }else{
            $espay_password = '3sp4ytEsT';
            $espay_signature_key =  'P4yMentGat3w4Y';
        }

        // Get detail from espay request
        $signature_from_espay   = $input->signature;
        $rq_datetime            = $input->rq_datetime;
        $member_id              = $input->member_id;
        $order_id               = $input->order_id;
        $password_server        = $input->password;
        $debit_from             = $input->debit_from;
        $credit_to              = $input->credit_to;
        $product                = $input->product_code;
        $paid_amount            = $input->amount;
        // $payment_fee            = $input->payment_fee;
        $payment_ref            = $input->payment_ref;

        // Construct the signature
        // Format: ##KEY##rq_datetime##order_id##mode##
        $key = '##' . $espay_signature_key . '##' . $rq_datetime . '##' . $order_id . '##' . 'PAYMENTREPORT' . '##';

        // Next, the string will have to be converted to UPPERCASE before hashing is done.
        $uppercase = strtoupper($key);
        $generated_signature = hash('sha256', $uppercase);

        // validate the password
        if ($espay_password == $password_server) {

            if ($generated_signature == $signature_from_espay) {
                // validate order id
                if($transaction_invoice = TransactionInvoice::where(['transaction_invoice_number' => $order_id, 'transaction_invoice_status' => 0])->first()){
                    // Flag your transaction to be success here
                    //#Code here ..
                    $payment_log->transaction_invoice_id = $transaction_invoice->transaction_invoice_id;
                    $payment_log->save();

                    $transaction_invoice->payment_log_id                = $payment_log->payment_log_id;
                    $transaction_invoice->transaction_invoice_status    = 1;
                    $transaction_invoice->is_checked                    = 0;
                    $transaction_invoice->pay_at                        = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                    $transaction_invoice->save();

                    $transaction = Transaction::find($transaction_invoice->transaction_id);

                    $finance = new Finance;
                    $finance->finance_type          = 1;
                    $finance->finance_category_id   = 1;
                    $finance->finance_note          = $transaction_invoice->transaction_invoice_name.' invoice '.$transaction->transaction_number;
                    $finance->finance_nominal       = $transaction_invoice->transaction_invoice_amount;
                    $finance->save();
                    
                    $finance->finance_number = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('Ymd').'FIN'.$finance->finance_id;
                    $finance->save();  

                    if($transaction_invoice->transaction_invoice_balance - $transaction_invoice->transaction_invoice_amount <= 0){
                        $transaction->transaction_status = 2;
                        $transaction->paid_off_at = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                        $transaction->save();
                    }else{
                        $transaction->transaction_status = 1;
                        $transaction->save();
                    }

                    // generate reconsile_id
                    $reconsile_id = $member_id . " - " . $order_id . date('YmdHis');
                    // if done, show the response, format: success_flag,error message,reconcile_id, order_id,reconcile_datetime
                    return '0,Success,' . $reconsile_id . ',' . $order_id . ',' . date('Y-m-d H:i:s') . '';
                } else {
                    return '1,Order Id Does Not Exist,,,'; // if order id not exist show plain reponse
                }
            } else {
                return '1,Invalid Signature Key,,,';
            }
        } else {
            // if password not true
            return '1,Password does not match,,,';
        }
    }

    public function actionKredivoCheckout(Request $request, $invoice_number){
        $input = (object) $request->input();
        $customer = Auth::user();

        if($transaction_invoice = TransactionInvoice::where(['transaction_invoice_number' => $invoice_number, 'transaction_invoice_status' => 0])->first()){
            if(!empty($transaction_invoice->kredivo_checkout_url)){
                return redirect($transaction_invoice->kredivo_checkout_url);
            }

            $transaction = Transaction::find($transaction_invoice->transaction_id);
            $shipping_address = ShippingAddress::with('city', 'district', 'province')->find($transaction->shipping_address_id);
            $transaction_details = TransactionDetail::where(['transaction_id' => $transaction->transaction_id])->first();
            $product = Product::where(['product_id' => $transaction_details->product_id])->first();

            $item = array(
                "id" => $transaction_invoice->transaction_invoice_id,
                "name" => $product->product_name_id,
                "price" => $product->product_selling_price,
                "url" => url('#transaction/detail/'.$transaction->transaction_number),
                "type" => "Machine",
                "quantity" => 1
            );
            $items[] = $item;

            if(!empty($customer->customer_phone)){
                $customer_phone = $customer->customer_phone;
            }else{
                $customer_phone = $shipping_address->shipping_address_phone;
            }
    
            $payloads = array(
                "payment_type" => "30_days",
                "transaction_details" => array (
                    "amount" => $transaction->transaction_subtotal +
                    $transaction->transaction_shipping_price +
                    $transaction->transaction_pallet_price + 
                    $transaction->transaction_assurance - 
                    $transaction->transaction_discount,
                    "order_id" => $transaction_invoice->transaction_invoice_number,
                    "items" => $items
                ),
                "customer_details" => array(
                    "first_name" => $customer->customer_name,
                    "last_name" => "",
                    "email" => $customer->customer_email,
                    "phone" => $customer_phone
                ),
                "shipping_address" => array(
                    "first_name" => $shipping_address->shipping_address_customer_name,
                    "last_name" => "",
                    "address" => $shipping_address->shipping_address_text,
                    "city" => $shipping_address->city->city_name,
                    "postal_code" => $shipping_address->postal_code,
                    "phone" => $shipping_address->shipping_address_phone,
                    "country_code" => "IDN"
                ),
                "back_to_store_uri" => url('#transaction/detail/'.$transaction->transaction_number),
            );
            
            $checkout = Kredivo::checkout($payloads);

            if($checkout['status'] == 'OK'){
                $transaction_invoice->kredivo_checkout_url = $checkout['redirect_url'];
                $transaction_invoice->save();

                return redirect($transaction_invoice->kredivo_checkout_url);
            }else{
                return $checkout;
            }
        }else{
            return 'Error';
        }

    }

    public function actionPaymentKredivo(Request $request){
        $input = (object) $request->input();
        
        $payment_log = new PaymentLog;
        $payment_log->payment_log_content   = json_encode($input);
        $payment_log->created_at            = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
        $payment_log->save();

        if($transaction_invoice = TransactionInvoice::where(['transaction_invoice_number' => $input->order_id, 'transaction_invoice_status' => 0])->first()){
            $payment_log->transaction_invoice_id = $transaction_invoice->transaction_invoice_id;
            $payment_log->save();

            if($input->transaction_status == 'pending'){
                $transaction_invoice->kredivo_trx = $input->transaction_id;
                $transaction_invoice->signature_key = $input->signature_key;
                $transaction_invoice->save();

                $checkout = Kredivo::check($transaction_invoice->kredivo_trx, $transaction_invoice->signature_key);

                if($checkout['status'] == 'OK' && $checkout['transaction_id'] == $transaction_invoice->kredivo_trx){
                    if($checkout['transaction_status'] == 'settlement'){
                        $payment_log = new PaymentLog;
                        $payment_log->payment_log_content   = json_encode($checkout);
                        $payment_log->created_at            = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                        $payment_log->save();

                        $transaction_invoice->payment_log_id                    = $payment_log->payment_log_id;
                        $transaction_invoice->transaction_invoice_status    = 1;
                        $transaction_invoice->is_checked                    = 0;
                        $transaction_invoice->pay_at                        = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                        $transaction_invoice->save();

                        $payment_log->transaction_invoice_id = $transaction_invoice->transaction_invoice_id;
                        $payment_log->save();

                        $transaction = Transaction::find($transaction_invoice->transaction_id);
            
                        $finance = new Finance;
                        $finance->finance_type          = 1;
                        $finance->finance_category_id   = 1;
                        $finance->finance_note          = $transaction_invoice->transaction_invoice_name.' invoice '.$transaction->transaction_number;
                        $finance->finance_nominal       = $transaction_invoice->transaction_invoice_amount;
                        $finance->save();
                        
                        $finance->finance_number = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('Ymd').'FIN'.$finance->finance_id;
                        $finance->save();  
            
                        if($transaction_invoice->transaction_invoice_balance - $transaction_invoice->transaction_invoice_amount <= 0){
                            $transaction->transaction_status = 2;
                            $transaction->paid_off_at = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                            $transaction->save();
                        }else{
                            $transaction->transaction_status = 1;
                            $transaction->save();
                        }

                        return response()->json([
                            'status' => 'OK', 
                            'message' => 'Transaction Success'
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'OK', 
                            'message' => 'Transaction not settlement'
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => 'OK', 
                        'message' => 'Kredivo is error'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'OK', 
                    'message' => 'Push notif from kredivo not pending'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'OK', 
                'message' => 'Order ID not found'
            ]);
        }
    }

    public function actionAkulakuCheckout(Request $request, $invoice_number){
        $input = (object) $request->input();
        $customer = Auth::user();

        if($transaction_invoice = TransactionInvoice::where(['transaction_invoice_number' => $invoice_number, 'transaction_invoice_status' => 0])->first()){
            if(!empty($transaction_invoice->akulaku_checkout_url)){
                return redirect($transaction_invoice->akulaku_checkout_url);
            }

            $transaction = Transaction::find($transaction_invoice->transaction_id);
            $shipping_address = ShippingAddress::with('city', 'district', 'province')->find($transaction->shipping_address_id);

            $item = array(
                'skuId' => $transaction_invoice->transaction_invoice_number,
                'skuName' => $transaction_invoice->transaction_invoice_name,
                'unitPrice' => $transaction_invoice->transaction_invoice_amount,
                'qty' => '1',
                'img' => 'https://www.cahayaagro.com/images/5af0169b2c147686442223.jpg',
                'vendorName' => 'CA',
                'vendorId' => 'CA',
            );
            $items[] = $item;
    
            if(!empty($customer->customer_phone)){
                $customer_phone = $customer->customer_phone;
            }else{
                $customer_phone = $shipping_address->shipping_address_phone;
            }

            $payloads = [
                'refNo' => $transaction_invoice->transaction_invoice_number,
                'totalPrice' => $transaction_invoice->transaction_invoice_amount,
                'userAccount' => Akulaku::getUserAccount(),
                'receiverName' => $customer->customer_name,
                'receiverPhone' => $customer_phone,
                'province' => $shipping_address->province->province_name,
                'city' => $shipping_address->city->city_name,
                'street' => $shipping_address->shipping_address_text,
                'postcode' => $shipping_address->postal_code,
                'callbackPageUrl' => url('#transaction/detail/'.$transaction->transaction_number),
                'details' => json_encode($items)
            ];
    
            $checkout = Akulaku::generateOrder($payloads);

            if($checkout['success']){
                $transaction_invoice->akulaku_checkout_url = Akulaku::getPaymentUrl($transaction_invoice->transaction_invoice_number);
                $transaction_invoice->save();

                return redirect($transaction_invoice->akulaku_checkout_url);
            }else{
                return $checkout;
            }
        }else{
            return 'Error';
        }

    }

    public function actionPaymentAkulaku(Request $request){
        $input = (object) $request->input();
        
        $payment_log = new PaymentLog;
        $payment_log->payment_log_content   = json_encode($input);
        $payment_log->created_at            = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
        $payment_log->save();

        if($input->appId == Akulaku::getAppid()){
            if($input->sign == Akulaku::sign($input->refNo.$input->status)){
                if($transaction_invoice = TransactionInvoice::where(['transaction_invoice_number' => $input->order_id, 'transaction_invoice_status' => 0])->first()){
                    $payment_log->transaction_invoice_id = $transaction_invoice->transaction_invoice_id;
                    $payment_log->save();
        
                    if($input->status == 100){
                        $transaction_invoice->payment_log_id                = $payment_log->payment_log_id;
                        $transaction_invoice->transaction_invoice_status    = 1;
                        $transaction_invoice->is_checked                    = 0;
                        $transaction_invoice->pay_at                        = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                        $transaction_invoice->save();

                        $transaction = Transaction::find($transaction_invoice->transaction_id);
            
                        $finance = new Finance;
                        $finance->finance_type          = 1;
                        $finance->finance_category_id   = 1;
                        $finance->finance_note          = $transaction_invoice->transaction_invoice_name.' invoice '.$transaction->transaction_number;
                        $finance->finance_nominal       = $transaction_invoice->transaction_invoice_amount;
                        $finance->save();
                        
                        $finance->finance_number = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('Ymd').'FIN'.$finance->finance_id;
                        $finance->save();  
            
                        if($transaction_invoice->transaction_invoice_balance - $transaction_invoice->transaction_invoice_amount <= 0){
                            $transaction->transaction_status = 2;
                            $transaction->paid_off_at = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
                            $transaction->save();
                        }else{
                            $transaction->transaction_status = 1;
                            $transaction->save();
                        }

                        return response()->json([
                            'status' => 'OK', 
                            'message' => 'Transaction Success'
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'Failed', 
                            'message' => 'Push notif from akulaku not success'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'Failed', 
                        'message' => 'Order ID not found'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'Failed', 
                    'message' => 'Sign is not valid'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'Failed', 
                'message' => 'APPID is not valid'
            ]);
        }
    }

}