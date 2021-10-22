<div class="content has-text-centered is-gap">
    <p class="title is-5">INV NO: {{explode('CAT', $transaction->transaction_number)[0].'/CAT/'.substr(explode('CAT', $transaction->transaction_number)[1], 0, 2).'/'.substr(explode('CAT', $transaction->transaction_number)[1], 2)}}</p>
</div>
<div class="content has-text-centered" style="background:#bd2e06; padding-top:1rem; padding-bottom:1rem;">
    <p class="title is-4" style="color:white;">TAGIHAN ANDA</p>
</div>
<div class="box">
@foreach($transaction_invoices as $i => $transaction_invoice)
    <div class="columns">
        <div class="column">
            <p class="title is-5">({{$i+1}}) {{$transaction_invoice->transaction_invoice_number}}</p>
        </div>
        <div class="column">
            {{$transaction_invoice->transaction_invoice_name}}
        </div>
        <div class="column">
            <!--p class="title is-6" style="text-align: right;">
                IDR {{number_format($transaction_invoice->transaction_invoice_amount)}}
            </p-->
            
            <p class="tittle is-6" style="text-align: right;">  Akan dihitung setelah Anda Konfirm Order </p>
        </div>
        <div class="column">
            <p class="buttons is-right">
            @if($transaction->shipping_service_id != 8 || $transaction->transaction_shipping_price > 0)
                @if($transaction_invoice->transaction_invoice_status == 0)
                    @if($transaction->payment_method == '999:KREDIVO')
                    <button class="button is-link" onclick="paymentKredivoAction(this)" data-order="{{$transaction_invoice->transaction_invoice_number}}" data-payment="{{$transaction->payment_method}}">
                        Bayar tagihan
                    </button>
                    @elseif($transaction->payment_method == '999:AKULAKU')
                    <button class="button is-link" onclick="paymentAkulakuAction(this)" data-order="{{$transaction_invoice->transaction_invoice_number}}" data-payment="{{$transaction->payment_method}}">
                        Bayar tagihan
                    </button>
                    @else
                    <button class="button is-link" onclick="paymentAction(this)" data-order="{{$transaction_invoice->transaction_invoice_number}}" data-payment="{{$transaction->payment_method}}">
                        Bayar tagihan
                    </button>
                    @endif
                @elseif($transaction_invoice->transaction_invoice_status == 1)
                <span class="tag is-success is-large">Sudah dibayar</span>
                @elseif($transaction_invoice->transaction_invoice_status == 2)
                <span class="tag is-danger is-large" style="background:#bd2e06;">Expired</span>
                @endif
            @else
            <span class="tag is-warning">Menunggu konfirmasi biaya pengiriman</span>
            @endif
            </p>
        </div>
    </div>
@endforeach
</div>
<div class="content has-text-centered" style="background:#bd2e06; padding-top:1rem; padding-bottom:1rem;">
    <p class="title is-4" style="color:white;">DETAIL ORDER</p>
</div>
<div class="box">
    <div class="content">
        <p class="title is-5">Alamat Pengiriman:</p>
        <p class="subtitle is-6">
        {{$shipping_address->shipping_address_customer_name}}<br>
        {{$shipping_address->shipping_address_text}}<br>
        {{$shipping_address->district_name}}, {{$shipping_address->city_name}}, {{$shipping_address->postal_code}}<br>
        {{$shipping_address->province_name}}<br>
        {{$shipping_address->shipping_address_phone}}
        </p>
    </div>
</div>
<div class="box">
    @foreach($transaction_details as $product)
    <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
        <article class="media">
            <figure class="media-left">
                <a class="image is-64x64 target-link" style="height: auto;" href="#product/{{$product->product_id}}">
                    @if(!empty($product->product_image_url))
                    <img src="{{$media_url.'/'.$product->product_image_url}}">
                    @else
                    <img src="https://bulma.io/images/placeholders/96x96.png">
                    @endif
                </a>
            </figure>
            <div class="media-content">
                <p class="title is-6">{{$product->product_name}}</p>
                <p>{{number_format($product->product_quantity)}} mesin</p>
            </div>
            <figure class="media-right">
                <!--p class="title is-6">IDR {{number_format($product->product_price * $product->product_quantity)}}</p-->
                <p class="tittle is-6" style="text-align: right;">  Akan dihitung setelah Anda Konfirm Order </p>
            </figure>
        </article>
    </div>
    @endforeach
</div>
<div class="box">
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    <p class="title is-4">Pengiriman</p> {{$shipping_service->shipping_service_name}}
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    @if($transaction->shipping_service_id != 8 || $transaction->transaction_shipping_price > 0)
                    <p class="title is-6">IDR {{number_format($transaction->transaction_shipping_price)}}</p>
                    @else
                    <p class="title is-6">Biaya belum diset</p>
                    @endif
                </figure>
            </article>
        </div>
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    <p class="title is-4">Pembayaran</p>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">{{explode(':', $transaction->payment_method)[1]}}</p>
                </figure>
            </article>
        </div>
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    <p class="title is-4">Pallet</p>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">IDR {{number_format($transaction->transaction_pallet_price)}}</p>
                </figure>
            </article>
        </div>
    </div>
    @if($transaction->transaction_assurance > 0)
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    <p class="title is-4">Asuransi</p>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">IDR {{number_format($transaction->transaction_assurance)}}</p>
                </figure>
            </article>
        </div>
    </div>
    @endif
</div>
<div class="box">
    <div class="content">
        <p class="title is-4">TOTAL</p>
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    Subtotal<br>
                    Voucher
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <!--p class="title is-6" style="text-align: right;">
                        IDR {{number_format($transaction->transaction_subtotal + $transaction->transaction_shipping_price + $transaction->transaction_pallet_price + $transaction->transaction_assurance)}}<br>
                        -IDR {{number_format($transaction->transaction_discount)}}
                    </p-->
                    <p class="tittle is-6" style="text-align: right;">  Akan dihitung setelah Anda Konfirm Order </p>
                </figure>
            </article>
            <article class="media">
                <figure class="media-left">
                    <p class="title is-6">Total</p>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <!--p class="title is-6">IDR {{number_format($transaction->transaction_subtotal + $transaction->transaction_shipping_price + $transaction->transaction_pallet_price + $transaction->transaction_assurance - $transaction->transaction_discount)}}</p-->
                </figure>
            </article>
        </div>
    </div>
</div>
<iframe id="sgoplus-iframe" src="" scrolling="no" style="display:none" frameborder="0"></iframe>
@if(env('APP_ENV', 'local') == 'production')
<script type="text/javascript" src="https://kit.espay.id/public/signature/js"></script>
@else
<script type="text/javascript" src="https://sandbox-kit.espay.id/public/signature/js"></script>
@endif

<script>
    $(document).ready(function  () {
        back('transaction');
    });

    function paymentAction(element){
        var item = $(element);
        if(!item.hasClass('is-loading')){
            ga("gtag_UA_107066470_1.send", {
                hitType: 'event',
                eventAction: 'click',
                eventCategory: 'Pay With Espay',
                eventLabel: 'pay-with-espay'
            });
            item.addClass('is-loading');
            var pos = item.attr('data-payment');
            var posLength = pos.length;
            var n = pos.indexOf(":");
            var bankCode = pos.substr(0, n);
            var productCode = pos.substr(n + 1, posLength);
            var data = {
                //please dont change this at least u already register ur url for inquiry
                @if(env('APP_ENV', 'local') == 'production')
                key: "48c9a2355a3791a25cc2436fdf21a9e1",
                @else
                key: "4484aa3c9b4dabbbd24685fa8b800eec",
                @endif
                paymentId: item.attr('data-order'),
                backUrl: encodeURIComponent(base_url + '#transaction/detail/{{$transaction->transaction_number}}'),
                bankCode: bankCode,
                bankProduct: productCode,
                display: 'option',
            },
            sgoPlusIframe = document.getElementById("sgoplus-iframe");

            if (sgoPlusIframe !== null) 
            sgoPlusIframe.src = SGOSignature.getIframeURL(data);
            SGOSignature.receiveForm();
        }
    }

    function paymentKredivoAction(element){
        var item = $(element);
        if(!item.hasClass('is-loading') && item.attr('data-payment') == '999:KREDIVO'){
            ga("gtag_UA_107066470_1.send", {
                hitType: 'event',
                eventAction: 'click',
                eventCategory: 'Pay With Kredivo',
                eventLabel: 'pay-with-kredivo'
            });
            item.addClass('is-loading');
            window.location = '{{url('transaction/kredivo/checkout')}}' + '/' + item.attr('data-order');
        }else{
            item.removeClass('is-loading');
        }
    }

    function paymentAkulakuAction(element){
        var item = $(element);
        if(!item.hasClass('is-loading') && item.attr('data-payment') == '999:AKULAKU'){
            ga("gtag_UA_107066470_1.send", {
                hitType: 'event',
                eventAction: 'click',
                eventCategory: 'Pay With Akulaku',
                eventLabel: 'pay-with-akulaku'
            });
            item.addClass('is-loading');
            window.location = '{{url('transaction/akulaku/checkout')}}' + '/' + item.attr('data-order');
        }else{
            item.removeClass('is-loading');
        }
    }
</script>