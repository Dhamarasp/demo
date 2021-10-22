<div class="content has-text-centered is-gap">
    <p class="title is-5">Pilih alamat pengiriman</p>
</div>
<div class="box container">
    @if($shipping_addresses->first())
    <div class="columns is-mobile is-multiline">
        @foreach($shipping_addresses as $shipping_address)
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;">
            <article class="media">
                <div class="media-content">
                    <p class="title is-6">{{$shipping_address->shipping_address_name}}</p>
                    <p class="subtitle is-6">
                    {{$shipping_address->shipping_address_customer_name}}<br>
                    {{$shipping_address->shipping_address_text}}<br>
                    {{$shipping_address->district_name}}, {{$shipping_address->city_name}}, {{$shipping_address->postal_code}}<br>
                    {{$shipping_address->province_name}}<br>
                    {{$shipping_address->shipping_address_phone}}
                    </p>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="{{$shipping_address->shipping_address_id}}" onclick="selectShippingAddressAction(this)">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    @endif
    <div class="content has-text-centered">
        <a class="button is-black is-primary-color width-100 target-link" href="#account/address/new?from=cart">Tambah alamat pengiriman</a>
    </div>
</div>

<script>
    $(document).ready(function  () {
        back('order/cart');
    });

    function selectShippingAddressAction(element){
        var item = $(element);
        ajaxPostRequest('order/shipping-address/select', function(result){
            if(result.status == 200){
                @if(env('APP_ENV') == 'production')
                ga("gtag_UA_107066470_1.send", {
                    hitType: 'event',
                    eventAction: 'click',
                    eventCategory: 'Select Shipping Address',
                    eventLabel: 'select-shipping-address'
                });
                @endif
                iziToast.success({ title: 'OK', message: result.message });
                loadURI('order/shipping-service');
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            shipping_address_id: item.attr('data-id')
        });
    }
</script>