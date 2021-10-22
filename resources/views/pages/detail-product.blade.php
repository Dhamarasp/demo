<style>
img {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

img:hover {opacity: 0.7;}

.modal img {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}
</style>
<div id="myModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-content">
        <p class="image zoom">
        <img src="https://bulma.io/images/placeholders/1280x960.png">
        </p>
    </div>
    <button class="modal-close is-large" aria-label="close"></button>
</div>
<div class="columns" style="padding: 0.75rem;">
    <div class="column is-6 is-12-mobile">
    @if(!empty($product_images))
    <div class="owl-carousel owl-theme owl-loaded" id="banner-product">
        @foreach($product_images as $image)
        <div class="item">
            <figure class="image">
                @if(!empty($image->product_image_url))
                <img src="{{$media_url.'/'.$image->product_image_url}}">
                @else
                <img src="https://bulma.io/images/placeholders/96x96.png">
                @endif
            </figure>
        </div>
        @endforeach
    </div>
    @endif
    </div>
    <div class="column is-6 is-12-mobile">
    <div class="columns is-mobile is-multiline" style="padding: 0.75rem;">
        <div class="column is-6 is-6-mobile">
            <p class="title is-5">{{$product->product_name}}</p>
            <p class="subtitle is-6">{{$product->product_code}}</p>
            <input type="hidden" name="product_id" value="{{$product->product_id}}"/>
        </div>
        <div class="column is-6 is-6-mobile">
            <span class="icon is-medium has-text-black is-pulled-right">
                <a class="a2a_dd" href="https://www.addtoany.com/share"> 
                    <i class="fa fa-share" style="font-size: 22px; color: #000;"></i>
                </a>
            </span>
            <span class="icon is-medium has-text-black is-pulled-right" style="cursor:pointer;" onclick="wishlistAction()">
                @if($wishlist)
                <i class="fa fa-heart" style="font-size: 22px;"></i>
                @else
                <i class="fa fa-heart-o" style="font-size: 22px;"></i>
                @endif
            </span>
        </div>
        <div class="column is-6 is-6-mobile">
            @if(!empty($multi_text))
            <p class="subtitle is-6">{{$multi_text->category}}</p>
            @else
            <p class="subtitle is-6">Kategori: {{$product->product_type_name}}</p>
            @endif
        </div>
        <div class="column is-6 is-6-mobile">
            @if($product->product_selling_price == $product->product_price)
            <!-- <p class="title is-5">IDR {{number_format($product->product_price)}} -->
                <!-- <br><span style="font-weight: 200; font-size: medium;">*Termasuk biaya pallet</span> -->
            <!-- </p> -->
            @else
            <!-- <p class="subtitle is-discount" style="font-size:0.75rem;"><del>IDR {{number_format($product->product_selling_price)}}</del><br> <ins><b>IDR {{number_format($product->product_price)}}</b></ins> -->
            <p class="subtitle is-discount" style="font-size:0.75rem;"><ins><b>IDR {{number_format($product->product_price)}}</b></ins>
                <!-- <br><span style="font-weight: 200; font-size: medium;">*Termasuk biaya pallet</span> -->
            </p>
            @endif
        </div>
        <!-- <div class="column is-12 is-12-mobile">
            <p class="title is-6 has-text-success">Estimasi Cicilan</p>
            @if(!empty($installment_product['3']))
                <p class="is-6"><span class="has-text-success">(3 Bulan)</span> , IDR {{number_format($installment_product['3'])}} per bulan</p>
            @endif
            @if(!empty($installment_product['6']))
                <p class="is-6"><span class="has-text-success">(6 Bulan)</span> , IDR {{number_format($installment_product['6'])}} per bulan</p>
            @endif
            @if(!empty($installment_product['9']))
                <p class="is-6"><span class="has-text-success">(9 Bulan)</span> , IDR {{number_format($installment_product['9'])}} per bulan</p>
            @endif
            @if(!empty($installment_product['12']))
                <p class="is-6"><span class="has-text-success">(12 Bulan)</span> , IDR {{number_format($installment_product['12'])}} per bulan</p>
            @endif
            <small>*Harga cicilan belum termasuk anti karat, ongkos kirim, bea admin, asuransi, dan pallet</small><br>
            <small>**Minimum pembelanjaan dan bunga yang berbeda setiap bank atau multifinance</small><br>
            <small>***Untuk informasi lebih lanjut, silahkan hubungi <b>Customer Service</b></small>
        </div> -->
        @if($transaction_detail_count > 0)
        <div class="column is-12 is-12-mobile">
            <b style="color:red;">Mesin ini telah berhasil ditransaksikan sebanyak {{$transaction_detail_count}} kali</b>
        </div>
        @endif
        @php
            $volume = ceil($product->product_length * $product->product_width * $product->product_height / 1000000);
            $price_per_m3 = 500000;
            $primary_code = substr($product->product_code, 0, strpos($product->product_code, "TYPE-"));;
            $other_products = \App\Models\Product::where('product_code', 'LIKE', '%'.$primary_code.'%')->get();
        @endphp
        <div class="column is-12 is-12-mobile" style="border-bottom: 1px #eeeeee solid;">
            <p class="title is-4">Varian</p>
            <div class="select width-100">
                <select class="width-100" onchange="changeTypeAction(this)">
                    @if(!empty($multi_text))
                    <option selected="0">{{$multi_text->varian}}</option>
                    @else
                    <option selected="0">Kapasitas lainnya</option>
                    @endif
                    @foreach($other_products as $other_product)
                    @php
                        $type_code = str_replace($primary_code, '', $other_product->product_code);
                    @endphp
                    <option value="product/{{$other_product->product_id}}">{{$type_code}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- <div class="column is-12 is-12-mobile" style="border-bottom: 1px #eeeeee solid;">
            @if(!empty($multi_text))
            <p class="title is-4">{{$multi_text->anti_karat}}</p>
            @else
            <p class="title is-4">Produk anti karat (Optional)</p>
            @endif
            <article class="media">
                <figure class="media-left">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox"> Check if yes
                            </label>
                        </div>
                    </div>
                </figure>
                <div class="media-content">
                </div>
                <figure class="media-right">
                    <p class="title is-6">IDR {{number_format($volume * $price_per_m3)}}</p>
                </figure>
            </article>
        </div> -->
    </div>
    <div class="box">
        <nav class="level">
            <div class="level-left">
                <div class="level-item">
                    @if(!empty($multi_text))
                    <p class="title is-4">{{explode(', ', $multi_text->other_text)[0]}} </p>
                    @else
                    <p class="title is-4">Deskripsi </p>
                    @endif
                </div>
            </div>

            <div class="level-right">
                <a class="level-item button target-link" href="product/{{$product->product_id}}?lang=id">
                    <span class="flag-icon flag-icon-id flag-icon-squared" style="margin-right:0.25rem;"></span> ID
                </a>
                <a class="level-item button target-link" href="product/{{$product->product_id}}?lang=en">
                    <span class="flag-icon flag-icon-gb flag-icon-squared" style="margin-right:0.25rem;"></span> ENG
                </a>
            </div>
        </nav>
        <div class="content">
        @if(!empty($multi_text))
        {!!$multi_text->description!!}
        @else
        {!!$product->product_description!!}
        @endif
        </div>
        <div class="content">
            @if(!empty($multi_text))
            <p class="title is-6">{{explode(', ', $multi_text->other_text)[1]}} <p>{{$product->product_weight}} kg</p></p>
            <p class="title is-6">{{explode(', ', $multi_text->other_text)[2]}} <p>{{$product->product_length.' x '.$product->product_width.' x '.$product->product_height}} cm</p></p>
            @else
            <p class="title is-6">Berat: <p>{{$product->product_weight}} kg</p></p>
            <p class="title is-6">Ukuran: <p>{{$product->product_length.' x '.$product->product_width.' x '.$product->product_height}} cm</p></p>
            @endif
        </div>
        <div class="content">
        @if($product->product_stock <= 0)
        @if(!empty($multi_text))
        <b style="color:red;">{!!$multi_text->pre_order!!}
        @else
        <b style="color:red;">Tidak ready stock,</b> <br>silakan melakukan pre-order saat membelinya
        @endif
        </div>
        @else
        <b style="color:red;">Ready stok</b>
        @endif
        </div>
        <div class="content has-text-centered">
            <button class="button is-danger is-primary-color width-100" onclick="addToCartAction()">Add to cart</button>
        </div>
    </div>
</div>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
    $(document).ready(function  () {
        back('products');
        if ($ && $.fn.zoom) {
            $('.zoom').zoom({on: 'click'});
        }
    });

    $('figure img').on('click', function(){
        $('#myModal').addClass('is-active');
        $('#myModal img').attr('src', $(this).attr('src'));
        $('.zoom').zoom({on: 'click'});
    });

    $("#banner-product").owlCarousel({
        items:1,
        lazyLoad:true,
        loop:true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:false
    });

    function addToCartAction(){
        $.ajax({
            type: 'POST',
            url: base_url + 'product/addtocart',
            data:{
                product_id: $('input[name="product_id"]').val()
            },
            async: false,
            success: function (result) {
                if(result.status == 200){
                    ga("gtag_UA_107066470_1.send", {
                        hitType: 'event',
                        eventAction: 'click',
                        eventCategory: 'Add To Cart',
                        eventLabel: 'add-to-cart'
                    });
                    iziToast.success({ title: 'OK', message: result.message });
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    $("#appcontent").html(result);
                }
            }
        });
    }

    function wishlistAction(){
        $.ajax({
            type: 'POST',
            url: base_url + 'wishlist',
            data:{
                product_id: $('input[name="product_id"]').val()
            },
            async: false,
            success: function (result) {
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                    loadURI('product/'+$('input[name="product_id"]').val());
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }
            }
        });
    }

    function changeTypeAction(element){
        var item = $(element);
        if(item.val() != 0){
            loadURI(item.val());
        }
    }
</script>