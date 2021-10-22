<div class="content has-text-centered is-gap">
    <p class="title is-5">Alamat pengiriman</p>
    @if(!empty($address))
    <input class="input" type="hidden" name="shipping_address_id" value="{{$address->shipping_address_id}}">
    @else
    <input class="input" type="hidden" name="shipping_address_id">
    @endif
</div>
<div class="box">
    <div class="field">
        <label class="label">Simpan sebagai alamat</label>
        <div class="control">
        @if(!empty($address))
            <input class="input" type="text" placeholder="Alamat rumah, alamat kantor, alamat orangtua, dll" name="shipping_address_name" value="{{$address->shipping_address_name}}">
        @else
            <input class="input" type="text" placeholder="Alamat rumah, alamat kantor, alamat orangtua, dll" name="shipping_address_name">
        @endif
        </div>
    </div>
    <div class="field">
        <label class="label">Nama penerima</label>
        <div class="control">
        @if(!empty($address))
            <input class="input" type="text" placeholder="Nama penerima" name="shipping_address_customer_name" value="{{$address->shipping_address_customer_name}}">
        @else
            <input class="input" type="text" placeholder="Nama penerima" name="shipping_address_customer_name">
        @endif
        </div>
    </div>
    <div class="field">
        <label class="label">Telepon penerima</label>
        <div class="control">
        @if(!empty($address))
            <input class="input" type="text" placeholder="081312341234" name="shipping_address_phone" value="{{$address->shipping_address_phone}}">
        @else
            <input class="input" type="text" placeholder="081312341234" name="shipping_address_phone">
        @endif
        </div>
    </div>
    <div class="field">
        <label class="label">Alamat Lengkap</label>
        @if(!empty($address))
        <textarea class="textarea" placeholder="Alamat lengkap" name="shipping_address_text">{{$address->shipping_address_text}}</textarea>
        @else
        <textarea class="textarea" placeholder="Alamat lengkap" name="shipping_address_text"></textarea>
        @endif
    </div>
    <div class="field">
        <label class="label">Provinsi</label>
        <div class="control">
            <div class="select width-100">
                <select class="width-100" name="province_id" onchange="changeProvince()">
                    <option value="">Pilih provinsi</option>
                    @foreach($provinces as $province)
                    @if(!empty($address) && $address->province_id == $province->province_id)
                    <option value="{{$province->province_id}}" selected>{{$province->province_name}}</option>
                    @else
                    <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if(!empty($address))
        @php
            $cities = $cities->where('province_id', $address->province_id)->all();
            $districts = $districts->where('city_id', $address->city_id)->all();
        @endphp
    @endif
    <div class="field">
        <label class="label">Kota</label>
        <div class="control">
            <div class="select width-100">
                <select class="width-100" name="city_id" onchange="changeCity()">
                    <option value="">Pilih kota</option>
                    @foreach($cities as $city)
                    @if(!empty($address) && $address->city_id == $city->city_id)
                    <option value="{{$city->city_id}}" selected>{{$city->city_name}}</option>
                    @else
                    <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Kecamatan</label>
        <div class="control">
            <div class="select width-100">
                <select class="width-100" name="district_id">
                    <option value="">Pilih kecamatan</option>
                    @foreach($districts as $district)
                    @if(!empty($address) && $address->district_id == $district->district_id)
                    <option value="{{$district->district_id}}" selected>{{$district->district_name}}</option>
                    @else
                    <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Kode pos</label>
        <div class="control">
        @if(!empty($address))
            <input class="input" type="text" placeholder="61255" name="postal_code" value="{{$address->postal_code}}">
        @else
            <input class="input" type="text" placeholder="61255" name="postal_code">
        @endif
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-danger is-primary-color" onclick="saveAddressAction()">Simpan</button>
        </div>
        <div class="control">
            @if(!empty(Request::input('from')) && Request::input('from') == 'cart')
            <a class="button is-text target-link" href="#order/cart">Kembali ke cart</a>
            @else
            <a class="button is-text target-link" href="#account/address">Kembali ke daftar alamat</a>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function  () {
        @if(!empty(Request::input('from')) && Request::input('from') == 'cart')
        back('order/cart');
        @else
        back('account/address');
        @endif
    });

    function saveAddressAction(){
        ajaxPostRequest('account/address/save', function(result){
            if(result.status == 200){
                iziToast.success({ title: 'OK', message: result.message });
                @if(!empty(Request::input('from')) && Request::input('from') == 'cart')
                loadURI('order/shipping-address');
                @else
                loadURI('account/address');
                @endif
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            shipping_address_id: $('input[name=shipping_address_id]').val(),
            shipping_address_name: $('input[name=shipping_address_name]').val(),
            shipping_address_customer_name: $('input[name=shipping_address_customer_name]').val(),
            shipping_address_phone: $('input[name=shipping_address_phone]').val(),
            shipping_address_text: $('textarea[name=shipping_address_text]').val(),
            province_id: $('select[name=province_id]').val(),
            city_id: $('select[name=city_id]').val(),
            district_id: $('select[name=district_id]').val(),
            postal_code: $('input[name=postal_code]').val()
        });
    }

    function changeProvince(){
        ajaxPostRequest('account/address/change/province', function(result){
            $('select[name=city_id]').html('');
            var html = '<option value="" selected>Pilih kota</option>';
            $.each(result, function( key, value ) {
                html += '<option value="'+value.city_id+'" selected>'+value.city_name+'</option>'
            });
            $('select[name=city_id]').html(html);
        }, {
            province_id: $('select[name=province_id]').val()
        });
    }

    function changeCity(){
        ajaxPostRequest('account/address/change/city', function(result){
            $('select[name=district_id]').html('');
            var html = '<option value="" selected>Pilih kecamatan</option>';
            $.each(result, function( key, value ) {
                html += '<option value="'+value.district_id+'" selected>'+value.district_name+'</option>'
            });
            $('select[name=district_id]').html(html);
        }, {
            city_id: $('select[name=city_id]').val()
        });
    }
</script>