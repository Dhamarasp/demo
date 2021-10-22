<div class="content has-text-centered is-gap">
    <p class="title is-5">Keranjang belanja</p>
</div>
<div class="container box">
    @if($cart_details->first())
    <div class="columns is-mobile is-multiline" id="cart_detail_wrapper">
        @foreach($cart_details as $product)
        <div class="column is-12-mobile is-6-desktop" style="border-bottom: 1px #eeeeee solid;" id="cart_detail-{{$product->cart_detail_id}}">
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
                    <!--p class="subtitle is-6">@IDR {{number_format($product->product_price)}}</p-->
                    <p class="title is-6" name="quantity">{{number_format($product->product_quantity)}} mesin</p>
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <a class="level-item">
                                <button class="button is-small is-link is-outlined" data-quantity="-1" data-id="{{$product->cart_detail_id}}" onclick="addQtyAction(this)">
                                    Kurangi
                                </button>
                            </a>
                            <a class="level-item">
                                <button class="button is-small is-link is-outlined" data-quantity="1" data-id="{{$product->cart_detail_id}}" onclick="addQtyAction(this)">
                                    Tambah
                                </button>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="media-right">
                    <button class="button is-medium" data-id="{{$product->cart_detail_id}}" onclick="deleteCartDetailAction(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    <a class="button is-black is-primary-color width-100 target-link" href="#order/shipping-address">Isi tujuan pengiriman</a>
    @else
    <div class="content has-text-centered">
        <p class="subtitle is-6">Keranjang belanja Kamu kosong</p>
    </div>
    @endif
</div>

<script>
    $(document).ready(function  () {
        hideBack();
    });

    function addQtyAction(element){
        var item = $(element);
        ajaxPostRequest('order/cart/quantity/add', function(result){
            if(result.status == 200){
                $('#cart_detail-' + item.attr('data-id') + ' p[name="quantity"]').html(result.value + ' mesin');
                iziToast.success({ title: 'OK', message: result.message });
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            cart_detail_id: item.attr('data-id'),
            product_adding: item.attr('data-quantity')
        });
    }

    function deleteCartDetailAction(element){
        var item = $(element);
        ajaxPostRequest('order/cart/detail/delete', function(result){
            if(result.status == 200){
                $('#cart_detail-' + item.attr('data-id')).remove();
                iziToast.success({ title: 'OK', message: result.message });
                if(isEmptyHtml($('#cart_detail_wrapper'))){
                    loadURI('order/cart');
                }
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            cart_detail_id: item.attr('data-id')
        });
    }
</script>