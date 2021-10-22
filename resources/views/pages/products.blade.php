<div class="container" style="padding-right:0.75rem;padding-left:0.75rem;">
    <div class="columns is-mobile is-gapless">
        <div class="column is-6-mobile is-6">
            <div class="field">
                <div class="control">
                    <div class="select" style="width: 100%">
                        <select style="width: 100%" onchange="onChangeFilter()" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($product_types as $product_type)
                            @if(!empty(request()->input('category')) && request()->input('category') == $product_type->product_type_id)
                            <option value="{{$product_type->product_type_id}}" selected>{{$product_type->product_type_name}}</option>
                            @else
                            <option value="{{$product_type->product_type_id}}">{{$product_type->product_type_name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="column is-6-mobile is-6">
            <div class="field">
                <div class="control">
                    <div class="select" style="width: 100%">
                        <select style="width: 100%" onchange="onChangeFilter()" name="sort">
                            <option value="newest">Terbaru</option>
                            <option value="asc">Abjad</option>
                            <option value="cheapest">Termurah</option>
                            <option value="cost">Termahal</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="product-content">
    </div>
</div>

<script>
    $(document).ready(function  () {
        hideBack();
        var original_title = location.hash;
        var target_url = original_title.replace('#','');
        loadURI('get' + target_url, 'product-content', target_url);
    });

    function onChangeFilter() {
        var category = $('select[name=category]').val();
        var sort = $('select[name=sort]').val();
        var target_url = 'products?category=' + category + '&sort=' + sort;
        loadURI('get' + target_url, 'product-content', target_url);
    }
</script>