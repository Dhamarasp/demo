<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8="/>
    <title>Thanks for your order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            background: #F7F7F7;
        }
    </style>
</head>
<body bgcolor="#f9f9f9" style="font-family:'Open Sans', sans-serif;">
    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff; margin:5% auto; width: 100%; max-width: 600px;">
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cell=s pacing="0" width="100%">
                    <tr>
                        <td align="left">
                            <img src="{{asset('images/5b17dbe375831918552114.jpg')}}" style="max-width: 600px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin: 15px 0; color: rgba(0, 0, 0, 0.7); font-size: 16px;">
                    <tr>
                        <td colspan="3">
                            <span style="text-align: left; margin: 15px 10px; font-weight: bold; font-size: 13px;">
                                <p>Hai,</p>
                                <p>Terima kasih kamu telah melakukan order pada web https://cahayaagro.com.</p>
                                <p>Ini detail transaksi kamu saat ini.</p>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin: 15px 0; border:1px solid #000000; color: rgba(0, 0, 0, 0.7); font-size: 16px;">
                    <tr>
                        <td colspan="2">
                            <span style="text-align: left; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>No Transaksi</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>{{explode('CAT', $transaction->transaction_number)[0].'/CAT/'.substr(explode('CAT', $transaction->transaction_number)[1], 0, 2).'/'.substr(explode('CAT', $transaction->transaction_number)[1], 2)}}</p>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="color: rgba(0, 0, 0, 0.7); border:1px solid #000000; font-size: 16px;">
                    <tr>
                        <td colspan="3" style="background-color:#bd2e06;">
                            <span style="text-align: center; margin: 15px 0; font-weight: bold; font-size: 13px; color: #ffffff;">
                                <p>PEMBAYARAN</p>
                            </span>
                        </td>
                    </tr>
                    @foreach($detail_transaction_invoices as $transaction_invoice)
                    <tr>
                        <td colspan="1">
                            <span style="text-align: left; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>{{$transaction_invoice->transaction_invoice_name}}</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: center; margin: 15px 0; font-weight: bold; font-size: 13px;">
                            @if($transaction_invoice->transaction_invoice_status == 1)
                                <b style="color:green">TELAH DIBAYAR</b>
                            @else
                                <b style="color:red">BELUM DIBAYAR</b>
                            @endif
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($transaction_invoice->transaction_invoice_amount)}}</p>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="color: rgba(0, 0, 0, 0.7); margin-top:32px; border:1px solid #000000; font-size: 16px;">
                    <tr>
                        <td colspan="3" style="background-color:#bd2e06;">
                            <span style="text-align: center; margin: 15px 0; font-weight: bold; font-size: 13px; color: #ffffff;">
                                <p>DETAIL BARANG</p>
                            </span>
                        </td>
                    </tr>
                    @foreach($transaction_details as $transaction_detail)
                    <tr>
                        <td colspan="2">
                            <span style="text-align: left; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>{{$transaction_detail->product_name_id}} x{{$transaction_detail->product_quantity}}</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($transaction_detail->product_price * $transaction_detail->product_quantity)}}</p>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="1">
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>SUBTOTAL</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($transaction->transaction_subtotal)}}</p>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1">
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>POTONGAN</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR -{{number_format($transaction->transaction_discount)}}</p>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1">
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>PENGIRIMAN</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($transaction->transaction_shipping_price)}}</p>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1">
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>BIAYA PALLET</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($transaction->transaction_pallet_price)}}</p>
                            </span>
                        </td>
                    </tr>
                    @if($transaction->transaction_assurance > 0)
                    <tr>
                        <td colspan="1">
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>ASURANSI</p>
                            </span>
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($transaction->transaction_assurance)}}</p>
                            </span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="1">
                        </td>
                        <td colspan="1">
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>TOTAL</p>
                            </span>
                        </td>
                        <td colspan="1">
                        @php
                            $total = 0;
                            $total += $transaction->transaction_subtotal;
                            $total -= $transaction->transaction_discount;
                            $total += $transaction->transaction_shipping_price;
                            $total += $transaction->transaction_pallet_price;
                            $total += $transaction->transaction_assurance;
                        @endphp
                            <span style="text-align: right; margin: 15px 0; font-weight: bold; font-size: 13px;">
                                <p>IDR {{number_format($total)}}</p>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin: 15px 0; color: rgba(0, 0, 0, 0.7); font-size: 16px;">
                    <tr>
                        <td colspan="3">
                            <span style="text-align: left; margin: 15px 10px; font-weight: bold; font-size: 13px;">
                                <p>Klik tombol di bawah untuk melakukan pembayaran dan melihat detail transaksimu</p>
                                <a href="{{url('/').'#transaction/detail/'.$transaction->transaction_number}}" style="background-color:#bd2e06; border-radius:6px; border:1px solid #d02718; display:inline-block; cursor:pointer; color:#ffffff; font-size:15px; padding:6px 24px; text-decoration:none;">
                                Lihat Detail
                                </a>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin: 15px 0; color: rgba(0, 0, 0, 0.7); font-size: 16px;">
                    <tr>
                        <td colspan="3">
                            <span style="text-align: left; margin: 15px 10px; font-weight: bold; font-size: 13px;">
                                <p>Best,</p>
                                <p>Cahaya Agro</p>
                                <br>
                                <br>
                                <p>Untuk Keluhan dan saran Anda bisa hubungi kami di</p>
                                <p><b>Phone</b>: (031) - 5051298</p>
                                <p><b>Email</b>: <a href="mailto:customerservice@cahayaagro.com" style="color: #bd2e06;">customerservice@cahayaagro.com</a></p>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>