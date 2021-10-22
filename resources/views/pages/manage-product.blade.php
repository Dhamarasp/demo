@include('admin/partials/breadcrumb-navigation', ['breadcrumb' => $breadcrumb])
<nav class="level">
    <div class="level-left">
        <div class="level-item">
            <p class="title">
                <strong>{{end($breadcrumb)->name}}</strong>
            </p>
        </div>
    </div>
    <div class="level-right">
        <div class="level-item">
            <div class="box">
                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">Edited date: <b>{{Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('j M Y')}}</b></label>
                    </div>
                    <div class="field body is-grouped is-grouped-right">
                        <div class="control">
                            <button class="button is-link save-item-btn is-primary-color">
                                <span class="icon">
                                    <i class="typcn typcn-folder-add"></i>
                                </span>
                                <span>Save</span>
                            </button>
                        </div>
                        <div class="control">
                            <a href="javascript:loadURI('product')">
                                <button class="button is-text">Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="columns">
        <div class="column">
            <div class="content has-text-centered">
                <p class="subtitle"><b>Product name and description in Indonesia</b></p>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Product Name (ID)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="hidden" name="product_id" value="{{$product->product_id}}">
                            <input class="input" type="text" name="product_name_id" value="{{$product->product_name_id}}"> 
                            @else
                            <input class="input" type="hidden" name="product_id">
                            <input class="input" type="text" name="product_name_id"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Product Description (ID)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            @if(!empty($product))
                            <div id="product_description_id">{!!$product->product_description_id!!}</div>
                            @else
                            <div id="product_description_id"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="content has-text-centered">
                <p class="subtitle"><b>Product name and description in English</b></p>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Product Name (EN)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="text" name="product_name_en" value="{{$product->product_name_en}}"> 
                            @else
                            <input class="input" type="text" name="product_name_en"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Product Description (EN)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            @if(!empty($product))
                            <div id="product_description_en">{!!$product->product_description_en!!}</div>
                            @else
                            <div id="product_description_en"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Product Code</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="text" name="product_code" value="{{$product->product_code}}"> 
                            @else
                            <input class="input" type="text" name="product_code"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Product Type</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select">
                                <select name="product_type_id">
                                    <option value="" selected>Select Product Type</option>
                                    @foreach($product_types as $product_type)
                                    @if(!empty($product) && $product->product_type_id == $product_type->product_type_id)
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
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Production Price (IDR)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="number" min="0" name="product_production_price" value="{{$product->product_production_price}}"> 
                            @else
                            <input class="input" type="number" min="0" name="product_production_price"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Selling Price (IDR)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="number" min="0" name="product_selling_price" value="{{$product->product_selling_price}}"> 
                            @else
                            <input class="input" type="number" min="0" name="product_selling_price"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Weight (kg)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="number" min="0" name="product_weight" value="{{$product->product_weight}}"> 
                            @else
                            <input class="input" type="number" min="0" name="product_weight"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Length (cm)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="number" min="0" name="product_length" value="{{$product->product_length}}"> 
                            @else
                            <input class="input" type="number" min="0" name="product_length"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Width (cm)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="number" min="0" name="product_width" value="{{$product->product_width}}"> 
                            @else
                            <input class="input" type="number" min="0" name="product_width"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-small">
                    <label class="label">Height (cm)</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            @if(!empty($product))
                            <input class="input" type="number" min="0" name="product_height" value="{{$product->product_height}}"> 
                            @else
                            <input class="input" type="number" min="0" name="product_height"> 
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#product_description_id').summernote({
        placeholder: '',
        tabsize: 2,
        height: 250,
        callbacks: {
            onImageUpload: function(files) {
                summernoteUploadsImage(files[0], '#product_description_id');
            }
        }
    });

    $('#product_description_en').summernote({
        placeholder: '',
        tabsize: 2,
        height: 250,
        callbacks: {
            onImageUpload: function(files) {
                summernoteUploadsImage(files[0], '#product_description_en');
            }
        }
    });

    $(document).on('click', '.save-item-btn', function () {
        $.ajax({
            type: "POST",
            url: base_url + 'api/product/save',
            data: {
                product_id: $('input[name=product_id]').val(),
                product_type_id: $('select[name=product_type_id]').val(),
                product_code: $('input[name=product_code]').val(),
                product_name_id: $('input[name=product_name_id]').val(),
                product_name_en: $('input[name=product_name_en]').val(),
                product_description_id: $('#product_description_id').summernote('code'),
                product_description_en: $('#product_description_en').summernote('code'),
                product_weight: $('input[name=product_weight]').val(),
                product_length: $('input[name=product_length]').val(),
                product_width: $('input[name=product_width]').val(),
                product_height: $('input[name=product_height]').val(),
                product_production_price: $('input[name=product_production_price]').val(),
                product_selling_price: $('input[name=product_selling_price]').val()
            },
            success: function (result) {
                if(result.status == 200){
                    iziToast.success({ title: 'Good job', message: result.message });
                    if(result.redirect){
                        loadURI('product');
                    }
                }else{
                    iziToast.warning({ title: 'Oops', message: result.message });
                }
            }
        });
    });
</script>