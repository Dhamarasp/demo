<div class="columns">
    <div class="column">
        <table class="table width-100">
            <tbody>
                <tr>
                    <th>Total Barang</th>
                    <!--td>IDR {{number_format($total_product_price + $total_shipping_price)}}</td-->
                    <td>Akan dihitung setelah Anda Konfirm Order</td>
                </tr>
                <tr>
                    <th>Total Pengiriman)</th>
                    @if($total_shipping_price > 0)
                    <td>IDR {{number_format($total_shipping_price)}}</td>
                    @else
                    <td>Akan dihitung setelah Anda konfirm order</td>
                    @endif
                </tr>
                <tr>
                    <th>Total</th>
                    <!--td>IDR {{number_format($total_product_price + $total_shipping_price)}}</td-->
                    <td>Akan dihitung setelah Anda Konfirm Order</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="content has-text-centered is-gap">
    <p class="title is-5">Pilih metode pembayaran</p>
</div>
<div class="box">
    <div class="columns is-mobile is-multiline">
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/bri.png')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/link.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">BRI ATM</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="002:BRIATM" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/visa.png')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/mastercard.png')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/amex.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">Credit Card Visa / Master / Amex</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="008:CREDITCARD" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/mandiri.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">Credit Card Visa / Master 12 Months Installment</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="008:CCINSTALL12" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/mandiri.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">Credit Card Visa / Master 3 Months Installment</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="008:CCINSTALL3" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/mandiri.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">Credit Card Visa / Master 6 Months Installment</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="008:CCINSTALL6" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/mandiri.png')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/link.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">MANDIRI ATM</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="008:MANDIRIATM" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/alfamart.png')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/indomaret.png')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/pegadaian.jpg')}}" style="height: 1.75rem;">
                        <img src="{{asset('images/support-logo/pos-indo.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">Modern Channel</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="008:FINPAY195" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/epay-bri.jpg')}}" style="height: 1.75rem;">
                    <p class="title is-6">e-Pay BRI</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="002:EPAYBRI" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                        <img src="{{asset('images/support-logo/kredivo.png')}}" style="height: 1.75rem;">
                    <p class="title is-6">Cicilan dengan KREDIVO</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="999:KREDIVO" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                    <img src="{{asset('images/support-logo/akulaku2.jpeg')}}" style="height: 1.75rem;">
                    <p class="title is-6">Cicilan dengan AKULAKU</p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="999:AKULAKU" onclick="selectPaymentMethodAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
    </div>
</div>

<script>
    $(document).ready(function  () {
        back('order/shipping-service');
    });

    function selectPaymentMethodAction(element){
        var item = $(element);
        ajaxPostRequest('order/payment/select', function(result){
            if(result.status == 200){
                @if(env('APP_ENV') == 'production')
                ga("gtag_UA_107066470_1.send", {
                    hitType: 'event',
                    eventAction: 'click',
                    eventCategory: 'Select Payment Method',
                    eventLabel: 'select-payment'
                });
                @endif
                iziToast.success({ title: 'OK', message: result.message });
                loadURI('order/review');
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            payment_method: item.attr('data-id')
        });
    }
</script>