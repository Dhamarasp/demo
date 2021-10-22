<div class="content has-text-centered is-gap">
    <p class="title is-5">Daftar alamat tersimpan</p>
</div>
<div class="box">
    @if($shipping_addresses->first())
    <div class="columns is-mobile is-multiline" id="cart_detail_wrapper">
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
                    <a class="button is-medium target-link" href="#account/address/edit/{{$shipping_address->shipping_address_id}}">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    @endif
    <div class="content has-text-centered">
        <a class="button is-black is-primary-color width-100 target-link" href="#account/address/new">Tambah alamat</a>
    </div>
</div>

<script>
    $(document).ready(function  () {
        back('account');
    });
</script>