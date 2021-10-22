<div class="box">
    <div class="content">
        <p class="title is-4">Keranjang belanja</p>
    </div>
    <div class="columns is-mobile is-multiline">
        @foreach($cart_details as $product)
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
    <div class="content">
        <p class="title is-4">Pengiriman</p>
        <!-- <p class="title is-4">Pengiriman ({{$total_weight}} kg)</p> -->
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    {{$shipping_service_name}}
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    @if($total_shipping_price > 0)
                    <p class="title is-6">IDR {{number_format($total_shipping_price)}}</p>
                    @else
                    <p class="title is-6">Akan dihitung setelah Anda konfirm order</p>
                    @endif
                </figure>
            </article>
        </div>
    </div>
    <div class="content">
        <p class="title is-4">Pembayaran</p>
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    Metode
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">{{explode(':', $cart->payment_method)[1]}}</p>
                </figure>
            </article>
        </div>
    </div>
    <div class="content">
        <p class="title is-4">Pallet (Opsional)</p>
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="check_pallet" value="yes"> Gunakan Pallet 
                            </label>
                        </div>
                    </div>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">IDR {{number_format($total_pallet_price)}}</p>
                </figure>
            </article>
            <br>
            <b style="color:red;"><small>Harga pallet <b>100rb/m<sup>3</sup></b> dengan maksimal biaya pallet <b>1jt</b></small></b>
        </div>
    </div>
    <div class="content">
        <p class="title is-4">Asuransi (Optional)</p>
    </div>
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-12-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <figure class="media-left">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="check_asuransi" value="yes"> Gunakan asuransi
                            </label>
                        </div>
                    </div>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">IDR 59,000</p>
                </figure>
            </article>
            <br>
            <b style="color:red;"><small>Cahaya Agro tidak akan menanggung apapun jika terjadi kerusakan jika pelanggan tidak menggunakan asuransi</small></b>
        </div>
    </div>
</div>
@if(empty($cart->voucher_id))
<div class="box">
    <div class="content has-text-centered">
        Masukkan kode voucher Kamu di sini (Jika ada)
    </div>
    <div class="field">
        <div class="control">
            <input class="input" type="text" placeholder="Kode voucher" name="voucher_code">
        </div>
    </div>
    <div class="field is-grouped is-grouped-centered">
        <div class="control width-100">
            <button class="button is-danger is-primary-color width-100" onclick="useVoucherAction(this)">
                Gunakan
            </button>
        </div>
    </div>
</div>
@else
<div class="box">
    <div class="content has-text-centered">
        Menggunakan voucher: <b>{{$cart->voucher->voucher_code}}</b>
    </div>
    <div class="field is-grouped is-grouped-centered">
        <div class="control width-100">
            <button class="button is-danger is-primary-color width-100" onclick="deleteVoucherAction(this)">
                Hapus Voucher
            </button>
        </div>
    </div>
</div>
@endif
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
                        IDR {{number_format($subtotal)}}<br>
                        -IDR {{number_format($voucher_price)}}
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
                    <!--p class="title is-6" style="text-align: right;">
                        IDR {{number_format($subtotal)}}<br>
                        -IDR {{number_format($voucher_price)}}
                    </p-->
                    <p class="tittle is-6" style="text-align: right;">  Akan dihitung setelah Anda Konfirm Order </p>
                </figure>
            </article>
        </div>
        <div class="column is-12-mobile is-12-desktop">
            <p class="title is-4">Sistem Pembayaran</p>
            <div class="control">
                <label class="radio">
                    <input type="radio" name="is_downpayment" value="2" checked>
                    Dengan DP {{\App\Models\Setting::where('setting_code', 'downpayment_value')->first()->setting_value}}%
                </label>
                <label class="radio">
                    <input type="radio" name="is_downpayment" value="1">
                    Langsung Lunas
                </label>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="field is-grouped is-grouped-centered">
        <div class="control width-100">
            <button class="button is-danger is-primary-color width-100" onclick="checkoutAction(this)">
                Konfirm order
            </button>
        </div>
    </div>
</div>

<!-- <iframe id="sgoplus-iframe" src="" scrolling="no" style="display:none" frameborder="0"></iframe> -->
@if(env('APP_ENV', 'local') == 'production')
<!-- <script type="text/javascript" src="https://kit.espay.id/public/signature/js"></script> -->
@else
<!-- <script type="text/javascript" src="https://sandbox-kit.espay.id/public/signature/js"></script> -->
@endif
<script>
    $(document).ready(function  () {
        back('order/payment');
    });

    function checkoutAction(element){
        var item = $(element);
        if(!item.hasClass('is-loading')){
            item.addClass('is-loading');
            ajaxPostRequest('order/checkout', function(result){
                if(result.status == 200){
                    @if(env('APP_ENV') == 'production')
                    ga("gtag_UA_107066470_1.send", {
                        hitType: 'event',
                        eventAction: 'click',
                        eventCategory: 'Checkout',
                        eventLabel: 'checkout'
                    });
                    @endif
                    iziToast.success({ title: 'OK', message: 'Transaksi telah dibuat' });
                    loadURI('transaction/detail/'+ result.order);
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            }, {
                check_asuransi: $('input[name=check_asuransi]').val(),
                check_pallet: $('input[name=check_pallet]').val(),
                is_downpayment: $('input[name=is_downpayment]:checked').val()
            });
        }
    }

    function useVoucherAction(element){
        var item = $(element);
        if(!item.hasClass('is-loading')){
            item.addClass('is-loading');
            ajaxPostRequest('order/cart/voucher/use', function(result){
                item.removeClass('is-loading');
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                    loadURI('order/review');
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            }, {
                voucher_code: $('input[name=voucher_code]').val()
            });
        }
    }

    function deleteVoucherAction(element){
        var item = $(element);
        if(!item.hasClass('is-loading')){
            item.addClass('is-loading');
            ajaxPostRequest('order/cart/voucher/delete', function(result){
                item.removeClass('is-loading');
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                    loadURI('order/review');
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            });
        }
    }
</script>