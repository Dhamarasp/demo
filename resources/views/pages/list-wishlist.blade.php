<div class="content has-text-centered is-gap">
    <p class="title is-5">Favorit Saya</p>
</div>
@if($products->first())
<div class="columns is-mobile is-multiline">
    @foreach($products as $product)
    <div class="column is-6-mobile is-3-desktop" style="border: 1px solid #ff3860;">
        <a class="card target-link" href="#product/{{$product->product_id}}">
            <div class="card-image">
                <figure class="image">
                    @if(!empty($product->product_image_url))
                    <img src="{{$media_url.'/'.$product->product_image_url}}">
                    @else
                    <img src="https://bulma.io/images/placeholders/96x96.png">
                    @endif
                </figure>
            </div>
            <div class="card-content has-text-centered">
                <p class="title is-5">{{$product->product_name}}</p>
                <p class="subtitle is-6">IDR {{number_format($product->product_price)}}</p>
            </div>
        </a>
    </div>
    @endforeach
</div>
@else
<div class="box">
    <div class="content has-text-centered">
        <p class="subtitle is-6">Belum ada yang difavoritkan</p>
    </div>
</div>
@endif

<script>
    $(document).ready(function  () {
        hideBack();
    });
</script>