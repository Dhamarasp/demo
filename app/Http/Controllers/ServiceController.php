<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionInvoice;

use App\Jobs\SendEmailJob;

use Carbon\Carbon;

class ServiceController extends BaseController{
    public function sendEmailInvoice(){
        $transaction_invoices = TransactionInvoice::where(['transaction_invoice_status' => 0, 'is_checked' => 0])->get();

        foreach($transaction_invoices as $transaction_invoice){
            $transaction = Transaction::find($transaction_invoice->transaction_id);
            $transaction_details = TransactionDetail::join('products', 'products.product_id', '=', 'transaction_details.product_id')->where('transaction_id', $transaction->transaction_id)->get();
            $detail_transaction_invoices = TransactionInvoice::where('transaction_id', $transaction->transaction_id)->get();
            $customer = Customer::find($transaction->customer_id);
            $email = $customer->customer_email;

            $plain_content = 'Hi,
            \n \n
            Kamu masih punya tagihan yang belum terbayar nih.\n
            Kami sertakan info untuk melihat detail transaksi kamu saat ini
            \n \n
            Best,
            \n
            Cahaya Agro';
            
            $html_content = view('emails/new-invoice-detail', compact('transaction', 'transaction_details', 'detail_transaction_invoices'))->render();
            
            $email = array(
                'html' => $html_content,
                'text' => $plain_content,
                'subject' => 'Cahaya Agro Order Detail',
                'from' => array(
                    'name' => 'Cahaya Agro',
                    'email' => 'no-reply@cahayaagro.com',
                ),
                'to' => array(
                    array(
                        'name' => $customer->customer_email,
                        'email' => $customer->customer_email,
                    ),
                )
            );

            $emailJob = (new SendEmailJob($email))->delay(Carbon::now()->addSeconds(3));
            dispatch($emailJob);
            
            $transaction_invoice->is_checked = 1;
            $transaction_invoice->save();

            $email_cs = array(
                'html' => $html_content,
                'text' => $plain_content,
                'subject' => $transaction->transaction_number.' Order Detail From Customer',
                'from' => array(
                    'name' => 'Cahaya Agro',
                    'email' => 'no-reply@cahayaagro.com',
                ),
                'to' => array(
                    array(
                        'name' => 'Cahaya Agro CS',
                        'email' => 'customerservice@cahayaagro.com',
                    ),
                )
            );

            $emailJob = (new SendEmailJob($email_cs))->delay(Carbon::now()->addSeconds(3));
            dispatch($emailJob);
        }

        return response('Success', 200)->header('Content-Type', 'text/plain');
    }

    public function sendEmailReview(){
        $transactions = Transaction::where(['transaction_status' => 4, 'is_checked' => 0])->get();

        foreach($transactions as $transaction){
            $customer = Customer::find($transaction->customer_id);
            $email = $customer->customer_email;

            $plain_content = 'Hi,
            \n \n
            Terima kasih telah berbelanja di website https://cahayaagro.com.\n
            Saat ini kami membutuhkan feedback dari Kamu untuk memajukan layanan kami.\n
            Klik https://goo.gl/forms/WNihvQL0dWxp6EMs2 \n
            \n \n
            Best,
            \n
            Cahaya Agro';
            
            $html_content = view('emails/delivered-order')->render();
            
            $email = array(
                'html' => $html_content,
                'text' => $plain_content,
                'subject' => 'Cahaya Agro Order Delivered',
                'from' => array(
                    'name' => 'Cahaya Agro',
                    'email' => 'no-reply@cahayaagro.com',
                ),
                'to' => array(
                    array(
                        'name' => $customer->customer_email,
                        'email' => $customer->customer_email,
                    ),
                )
            );

            $emailJob = (new SendEmailJob($email))->delay(Carbon::now()->addSeconds(3));
            dispatch($emailJob);
            
            $transaction->is_checked = 1;
            $transaction->save();
        }

        return response('Success', 200)->header('Content-Type', 'text/plain');
    }

    public function sendEmailPaidInvoice(){
        $transaction_invoices = TransactionInvoice::where(['transaction_invoice_status' => 1, 'is_checked' => 0])->get();

        foreach($transaction_invoices as $transaction_invoice){
            $transaction = Transaction::find($transaction_invoice->transaction_id);
            $transaction_details = TransactionDetail::join('products', 'products.product_id', '=', 'transaction_details.product_id')->where('transaction_id', $transaction->transaction_id)->get();
            $detail_transaction_invoices = TransactionInvoice::where('transaction_id', $transaction->transaction_id)->get();
            $customer = Customer::find($transaction->customer_id);
            $email = $customer->customer_email;

            $plain_content = 'Hi,
            \n \n
            Terima kasih kamu telah melakukan order pada web https://cahayaagro.com.\n
            Ini detail transaksi kamu saat ini.
            \n \n
            Best,
            \n
            Cahaya Agro';
            
            $html_content = view('emails/order-detail', compact('transaction', 'transaction_details', 'detail_transaction_invoices'))->render();
            
            $email = array(
                'html' => $html_content,
                'text' => $plain_content,
                'subject' => 'Cahaya Agro Paid Order',
                'from' => array(
                    'name' => 'Cahaya Agro',
                    'email' => 'no-reply@cahayaagro.com',
                ),
                'to' => array(
                    array(
                        'name' => $customer->customer_email,
                        'email' => $customer->customer_email,
                    ),
                )
            );

            $emailJob = (new SendEmailJob($email))->delay(Carbon::now()->addSeconds(3));
            dispatch($emailJob);
            
            $transaction_invoice->is_checked = 1;
            $transaction_invoice->save();

            $email_cs = array(
                'html' => $html_content,
                'text' => $plain_content,
                'subject' => $transaction->transaction_number.' Paid Order From Customer',
                'from' => array(
                    'name' => 'Cahaya Agro',
                    'email' => 'no-reply@cahayaagro.com',
                ),
                'to' => array(
                    array(
                        'name' => 'Cahaya Agro CS',
                        'email' => 'customerservice@cahayaagro.com',
                    ),
                )
            );

            $emailJob = (new SendEmailJob($email_cs))->delay(Carbon::now()->addSeconds(3));
            dispatch($emailJob);
        }

        return response('Success', 200)->header('Content-Type', 'text/plain');
    }

    public function checkExpiredInvoice(){
        $transaction_invoices = TransactionInvoice::where(['transaction_invoice_status' => 0])->get();

        $now = Carbon::now('Asia/Jakarta');
        foreach($transaction_invoices as $transaction_invoice){
            $expired = Carbon::createFromFormat('Y-m-d H:i:s', $transaction_invoice->created_at)->addDay(1);
            if(strtotime($now) > strtotime($expired)){
                $other_invoice = TransactionInvoice::where('transaction_id', $transaction_invoice->transaction_id)
                                                    ->where('transaction_invoice_id', '<>', $transaction_invoice->transaction_invoice_id)
                                                    ->whereIn('transaction_invoice_status', [0, 1])
                                                    ->get();

                if($other_invoice->first()){
                    $transaction_invoice->transaction_invoice_status = 2;
                    $transaction_invoice->save();
                }else{
                    // Invoice Expired
                    $transaction_invoice->transaction_invoice_status = 2;
                    $transaction_invoice->save();

                    $transaction = Transaction::find($transaction_invoice->transaction_id);
                    $transaction->transaction_status = 10;
                    $transaction->save();
                }
            }
        }

        return response('Success', 200)->header('Content-Type', 'text/plain');
    }
}