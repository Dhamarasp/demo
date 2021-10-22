<div class="content has-text-centered is-gap">
    <p class="title is-5">Pilih metode pengiriman</p>
</div>
<div class="box container">
    @if($shipping_services->first())
    <div class="columns is-mobile is-multiline">
        @foreach($shipping_services as $shipping_service)
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                    <span class="icon has-text-info" style="width: auto;">
                        <img src="{{asset($shipping_service->image_url)}}" style="height: 1.75rem;">
                    </span>
                    <p class="title is-6">{{$shipping_service->shipping_service_name}}</p>
                    @if($shipping_service->shipping_service_id == 8)
                    <p class="subtitle is-6">
                    Akan kami hubungi setelah Anda konfirm order, 
                    <br>pilih pengiriman ini jika Anda ingin pihak kami memilihkan 
                    <br>metode pengiriman yang terbaik dan cocok bagi Anda
                    </p>
                    @else
                    <p class="subtitle is-6">
                    Biaya kirim IDR {{number_format($shipping_service->total_shipping_price)}}<br>
                    Estimasi {{$shipping_service->shipping_etl}} hari<br>
                    <!-- <b>Berat {{$shipping_service->total_weight_shipping}} kg</b> -->
                    </p>
                    @endif
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="{{$shipping_service->shipping_service_id}}" data-price="{{$shipping_service->total_shipping_price}}" onclick="selectShippingServiceAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
    $(document).ready(function  () {
        back('order/shipping-address');
    });

    function selectShippingServiceAction(element){
        var item = $(element);
        ajaxPostRequest('order/shipping-service/select', function(result){
            if(result.status == 200){
                @if(env('APP_ENV') == 'production')
                ga("gtag_UA_107066470_1.send", {
                    hitType: 'event',
                    eventAction: 'click',
                    eventCategory: 'Select Shipping Service',
                    eventLabel: 'select-shipping-service'
                });
                @endif
                iziToast.success({ title: 'OK', message: result.message });
                loadURI('order/payment');
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            shipping_service_id: item.attr('data-id'),
            shipping_price_unit: item.attr('data-price')
        });
    }
</script>