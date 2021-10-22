<div class="tabs is-fullwidth">
    <ul>
        <li class="is-active" data-target="#home">
            <a>
                <span class="icon is-small">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </span>
                <span>Home</span>
            </a>
        </li>
        <li data-target="#feed">
            <a>
                <span class="icon is-small">
                    <i class="fa fa-book" aria-hidden="true"></i>
                </span>
                <span>Feed</span>
            </a>
        </li>
        <li data-target="#promo">
            <a>
                <span class="icon is-small">
                    <i class="fa fa-tag" aria-hidden="true"></i>
                </span>
                <span>Promo</span>
            </a>
        </li>
    </ul>
</div>
<div id="home" style="display: block;">
    @if($home_banners->first())
    <div class="owl-carousel owl-theme" id="banner-promo">
        @foreach($home_banners as $banner)
        <div class="item">
            @if(!empty($banner->banner_url))
            <a href="{{$banner->banner_url}}" target="_blank">
            @else
            <a>
            @endif
                <figure class="image">
                    <img data-src="{{$banner->banner_image_url}}" class="lazyload" />
                </figure>
            </a>
        </div>
        @endforeach
    </div>
    <div class="content has-text-centered">
        <a class="tabs-to" style="color: #bd2e06;" data-target="#promo"><< See more promo >></a>
    </div>
    @endif
    @if($promo_products->first())
    <div class="content has-text-centered" style="background:#bd2e06; margin-top:1.5rem; padding-top:1.5rem; padding-bottom:3.5rem;">
        <p class="title is-4" style="color:white;">Product SALE</p>
        <div class="owl-carousel owl-theme" id="product-promo">
            @foreach($promo_products as $product)
            <div style="margin-right: 0.5rem; margin-left: 0.5rem; background: white;">
                <a class="card target-link" href="#product/{{$product->product_id}}">
                    <div class="card-image">
                        <figure class="image" style="margin:0;">
                            @if(!empty($product->product_image_url))
                            <img data-src="{{$media_url.'/'.$product->product_image_url}}" class="lazyload" />
                            @else
                            <img data-src="https://bulma.io/images/placeholders/96x96.png" class="lazyload" />
                            @endif
                        </figure>
                    </div>
                    <div class="card-content has-text-centered" style="padding:0.5rem;">
                        <p class="title" style="font-size:0.75rem; min-height:4rem;">{{str_replace('TYPE-A', '', $product->product_name)}}</p>
                        <!-- <p class="subtitle is-discount" style="font-size:1.15rem;"><del>IDR {{number_format($product->product_selling_price)}}</del><br> <ins><b>IDR {{number_format($product->product_price)}}</b></ins></p> -->
                        <p class="subtitle is-discount" style="font-size:1.15rem;"><ins><b>IDR {{number_format($product->product_price)}}</b></ins></p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="container">
        <div class="content has-text-centered" style="background:#bd2e06; padding-top:1rem; padding-bottom:1rem;">
            <p class="title is-4" style="color:white;">Category Product</p>
        </div>
        <div style="padding-right:0.75rem;padding-left:0.75rem;">
            <div class="columns is-mobile is-multiline is-centered">
                <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=4&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/AGRICULTURE.jpg')}}">
                            <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Pertanian</p>
                            </div> 
                        </figure>
                    </a>
                </div>
                <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=3&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/LIVESTOCK.jpg')}}">
                            <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Peternakan</p>
                            </div> 
                        </figure>
                    </a>
                </div>
                <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=5&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/FOOD-BEVARAGE.jpg')}}">
                            <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Makanan & Minuman</p>
                            </div> 
                        </figure>
                    </a>
                </div>
                <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=1&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/CONSTRUCTION.jpg')}}">
                             <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Bangunan</p>
                            </div> 
                        </figure>
                    </a>
                </div>
                <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=2&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/WASTE-MANAGEMENT.jpg')}}">
                             <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Pengolah Limbah</p>
                            </div> 
                        </figure>
                    </a>
                </div>
                <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=8&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/GENERAL-USE.jpg')}}">
                             <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Teknologi Tepat guna</p>
                            </div> 
                        </figure>
                    </a>
                </div>
                <!-- <div class="column is-4 is-4-mobile" style="border: 1px solid #ff3860;">
                    <a class="target-link" href="#products?category=7&sort=newest" style="color: #4a4a4a">
                        <figure class="image has-text-centered">
                            <img src="{{asset('images/categories/product-promo-min.jpeg')}}"> -->
                            <!-- <div style="padding: 0.75rem 0;">
                                <p class="" style="color:black;">Teknologi Tepat guna</p>
                            </div> -->
                        <!-- </figure>
                    </a>
                </div> -->
            </div>
        </div>
        @if(!empty($latest_posts))
        <div class="content has-text-centered" style="background:#bd2e06; margin-top:1.5rem; padding-top:1rem; padding-bottom:1rem;">
            <p class="title is-4" style="color:white;">Latest Post</p>
        </div>
        <div class="box" style="border-color: #ff3860;">
            <div class="columns">
            @foreach($latest_posts->forPage(0, 3)->all() as $post)
                <div class="column">
                    <a class="target-link" href="#post/{{$post->post_id}}">
                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-64x64" style="height: auto;">
                                    <img data-src="{{$post->post_image_url}}" class="lazyload" />
                                </p>
                            </figure>
                            <div class="media-content" style="overflow: hidden;">
                                <p class="title is-5">{{$post->post_title}}</p>
                                <p class="subtitle is-6">{{$post->post_category_name}} | Post at : {{date_format(date_create($post->created_at), 'd M Y')}}</p>
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
        @endif
        @if(!empty($new_products))
        <div class="content has-text-centered" style="background:#bd2e06; padding-top:1rem; padding-bottom:1rem;">
            <p class="title is-4" style="color:white;">New Product</p>
        </div>
        <div style="padding-right:0.75rem;padding-left:0.75rem;">
            <div class="columns is-mobile is-multiline">
                @foreach($new_products as $product)
                <div class="column is-6-mobile is-3-desktop" style="border: 1px solid #ff3860;">
                    <a class="card target-link" href="#product/{{$product->product_id}}">
                        <div class="card-image">
                            <figure class="image">
                                @if(!empty($product->product_image_url))
                                <img data-src="{{$media_url.'/'.$product->product_image_url}}" class="lazyload" />
                                @else
                                <img data-src="https://bulma.io/images/placeholders/96x96.png" class="lazyload" />
                                @endif
                            </figure>
                        </div>
                        <div class="card-content has-text-centered">
                            <p class="title is-5">{{str_replace('TYPE-A', '', $product->product_name)}}</p>
                            <!-- <p class="subtitle is-6">IDR {{number_format($product->product_price)}}</p> -->
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="content has-text-centered" style="margin-top:1.5rem;">
            <a class="target-link" href="#products" style="color: #bd2e06;"><< See more product >></a>
        </div>
        @endif
    </div>
</div>
<div id="feed" style="display: none;">
    <div class="container">
        <!-- <div class="content has-text-centered">
            <p class="title is-4">Promotion</p>
        </div> -->
        <p class="buttons" style="flex-wrap:unset; overflow-x:auto;">
            <a class="button filter-feed" data-post="0">
                <span>All</span>
            </a>
            @foreach($feed_categories as $feed_category)
            <a class="button filter-feed" data-post="{{$feed_category->post_category_id}}">
                <span>{{$feed_category->post_category_name}}</span>
            </a>
            @endforeach
        </p>
        @if(!empty($feed_posts))
        <div style="padding-right:0.75rem;padding-left:0.75rem;">
            <div class="columns is-multiline is-mobile">
            @foreach($feed_posts as $post)
                <div class="column is-3-desktop is-6-mobile post-feed post-feed-{{$post->post_category_id}}">
                    <a class="target-link" href="#post/{{$post->post_id}}">
                        <div class="card">
                            <div class="card-image box" style="margin-bottom: 0;">
                                <figure class="image">
                                    <img data-src="{{$post->post_image_url}}" class="lazyload" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="content">
                                    <p class="title is-5">{{$post->post_title}}</p>
                                    <p class="subtitle is-6">{{$post->post_category_name}} | Post at : {{date_format(date_create($post->created_at), 'd M Y')}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
<div id="promo" style="display: none;">
    <div class="container">
        <!-- <div class="content has-text-centered">
            <p class="title is-4">Promotion</p>
        </div> -->
        <p class="buttons" style="flex-wrap:unset; overflow-x:auto;">
            <a class="button filter-promo" data-post="0">
                <span>All</span>
            </a>
            @foreach($promo_categories as $promo_category)
            <a class="button filter-promo" data-post="{{$promo_category->post_category_id}}">
                <span>{{$promo_category->post_category_name}}</span>
            </a>
            @endforeach
        </p>
        @if(!empty($promo_posts))
        <div style="padding-right:0.75rem;padding-left:0.75rem;">
            <div class="columns is-multiline is-mobile">
            @foreach($promo_posts as $post)
                <div class="column is-3-desktop is-6-mobile post-promo post-promo-{{$post->post_category_id}}">
                    <a class="target-link" href="#post/{{$post->post_id}}">
                        <div class="card">
                            <div class="card-image box" style="margin-bottom: 0;">
                                <figure class="image">
                                    <img data-src="{{$post->post_image_url}}" class="lazyload" />
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="content">
                                    <p class="title is-5">{{$post->post_title}}</p>
                                    <p class="subtitle is-6">{{$post->post_category_name}} | Post at : {{date_format(date_create($post->created_at), 'd M Y')}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
        @endif
        @if(!empty($promo_products))
        <div class="content has-text-centered" style="background:#bd2e06; margin-top:1.5rem; padding-top:1rem; padding-bottom:1rem;">
            <p class="title is-4" style="color:white;">Product SALE</p>
        </div>
        <div class="box" style="border-color: #ff3860;">
            <div class="columns is-multiline">
            @foreach($promo_products as $product)
                <div class="column is-6-desktop">
                    <a class="media target-link" href="#product/{{$product->product_id}}">
                        <figure class="media-left">
                            <p class="image is-64x64" style="height: auto;">
                                <img data-src="{{$media_url.'/'.$product->product_image_url}}" class="lazyload" />
                            </p>
                        </figure>
                        <div class="media-content" style="overflow: hidden;">
                            <p class="title is-6">{{$product->product_name}}</p> 
                            <!-- <p class="subtitle is-6 is-discount"><del>IDR {{number_format($product->product_selling_price)}}</del> <ins><b>IDR {{number_format($product->product_price)}}</b></ins></p> -->
                            <p class="subtitle is-6 is-discount"><ins><b>IDR {{number_format($product->product_price)}}</b></ins></p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
<div class="content has-text-centered" style="border-top: 1px solid #ff3860; padding-top: 1rem; margin-top: 1rem;">
    <p class="title is-6">Our payment support:</p>
    <div style="font-size: 2rem; margin-top: 1.5rem;">
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/visa.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/mastercard.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/amex.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://www.klikbca.com" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/bca.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://bankmandiri.co.id" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/mandiri.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://bri.co.id" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/bri.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/link.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="http://alfamartku.com" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/alfamart.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://indomaret.co.id/" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/indomaret.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://www.pegadaian.co.id" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/pegadaian.jpg')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="http://www.posindonesia.co.id" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/pos-indo.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://www.ovo.id/" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/ovo.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://www.kredivo.com/" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/kredivo.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="https://www.akulaku.com/" style="text-decoration: none;" target="_blank">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/akulaku2.jpeg')}}" style="height: 1.75rem;">
            </span>
        </a>
    </div>
</div>
<div class="content has-text-centered" style="padding-top: 1rem; margin-top: 1rem;">
    <p class="title is-6">Our shipping support:</p>
    <div style="font-size: 2rem; margin-top: 1.5rem;">
    <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/jnt.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/jne.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/tiki.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/ninja.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/wahana.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <!-- <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/pandu.png')}}" style="height: 1.75rem;">
            </span>
        </a>
        <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/gobox.png')}}" style="filter: grayscale(100%); height: 1.75rem;">
            </span>
        </a> -->
        <!-- <a href="#" style="text-decoration: none;">
            <span class="icon has-text-info" style="width: auto;">
                <img src="{{asset('images/support-logo/indah.png')}}" style="filter: grayscale(100%); height: 1.75rem;">
            </span>
        </a> -->
    </div>
</div>
<div class="content has-text-centered" style="padding-top: 1rem; margin-top: 1rem;">
    <p class="title is-6">Certificate, Copyright Product and Certified  Brand</p>
    <a href="http://asm.acm-indonesia.com/" target="_blank" style="text-decoration: none;">
        <img src="{{asset('images/support-logo/logo-iso-baru.jpeg')}}" style="height: 4.5rem;">
    </a>
    <a href="https://pdki-indonesia.dgip.go.id/index.php/paten/cWNQRGd3V2RRUVJNRjBNc0ZFeUxJdz09?q=pipil+cengkeh+&type=1" target="_blank" style="text-decoration: none;">
        <img style="height: 4.5rem; width: auto;" src="{{asset('images/etc-logo/copyright-product.jpg')}}">
    </a>
    <a href="https://pdki-indonesia.dgip.go.id/index.php/merek/R1Y1SDZPV1ZLczdhYmxHZEh4MUhsdz09?q=CA&type=1&skip=20" target="_blank" style="text-decoration: none;">
        <img style="height: 4.5rem; width: auto;" src="{{asset('images/etc-logo/certified-brand.jpg')}}">
    </a>
</div>
<div class="content has-text-centered" style="padding-top: 1rem; margin-top: 1rem;">
    <p>Apakah Anda masih memiliki pertanyaan?</p>
    <p>Untuk pertanyaan lebih lanjut tentang produk dan kemitraan</p>
</div>
<div style="padding-right:0.75rem;padding-left:0.75rem;">
    <div class="columns" style="padding-top: 1rem; margin-top: 1rem;">
        <div class="column has-text-centered">
            <span class="icon">
                <i class="fa fa-envelope-o" style="color:#bd2e06; font-size:3.5rem;"></i>
            </span>
            <br>
            Kontak kami melalui email ke<br>
            <a href="mailto:customerservice@cahayaagro.com" style="color: #bd2e06;">customerservice@cahayaagro.com</a>
        </div>
        <div class="column has-text-centered">
            <span class="icon">
                <i class="fa fa-phone" style="color:#bd2e06; font-size:3.5rem;"></i>
            </span>
            <br>
            Telepon ke 03199450671 / 081132030159<br>
            Jam kerja hari Senin s/d Sabtu, pukul 8.00 WIB s/d 15.00 WIB <br>
            Hari Minggu dan Hari Libur Besar lainnya TUTUP
        </div>
    </div>
</div>
<div style="padding-right:0.75rem;padding-left:0.75rem;">
    <div class="columns" style="padding-top: 1rem; margin-top: 1rem;">
        <div class="column has-text-centered">
            <div class="content has-text-centered" style="padding-top: 1rem; margin-top: 1rem;">
                <p>Follow juga sosial media kami</p>
                <div style="font-size: 2rem; margin-top: 1.5rem;">
                <a href="https://www.facebook.com/cahayaagrotekniksby" target="_blank" style="text-decoration: none;">
                        <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                            <!-- <i class="fa fa-facebook" style="color: #bd2e06;"></i> -->
                            <img src="{{asset('images/support-logo/facebook.png')}}" style="width: 1.4rem; height: 1.4rem;">
                        </span>
                    </a>
                    <a href="https://www.instagram.com/cahayaagroteknik/" target="_blank" style="text-decoration: none;">
                        <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                            <!-- <i class="fa fa-instagram" style="color: #bd2e06;"></i> -->
                            <img src="{{asset('images/support-logo/instagram.png')}}" style="width: 1.4rem; height: 1.4rem; ">
                        </span>
                    </a>
                    <a href="https://www.youtube.com/channel/UCE87q9lRZKhyEYpVtCE6R2g" target="_blank" style="text-decoration: none;">
                        <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                            <!-- <i class="fa fa-youtube-play" style="color: #bd2e06;"></i> -->
                            <img src="{{asset('images/support-logo/youtube.png')}}" style="width: 1.4rem; height: 1.4rem;">
                        </span>
                    </a>
                    <a href="https://www.tiktok.com/@cahayaagro" target="_blank" style="text-decoration: none;">
                        <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                            <img src="{{asset('images/support-logo/tik-tok.png')}}" style="width: 1.4rem; height: 1.4rem;">
                            
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="column has-text-centered">
            <div class="content has-text-centered" style="padding-top: 1rem; margin-top: 1rem;">
                <p>Kami juga tersedia di E-Commerce</p>
                <div class="content-logo">
                    <a target="_blank" href="https://www.blibli.com/brand/cahaya-agro">
                        <img style="height: 3rem; width: auto;" src="{{asset('images/mp/blibli-min.jpg')}}">
                    </a>
                    <a target="_blank" href="https://shopee.co.id/cahayaagroteknik?categoryId=135&itemId=7049858515">
                        <img style="height: 3rem; width: auto;" src="{{asset('images/mp/shopee-min.jpg')}}">
                    </a>
                    <br>
                    <a target="_blank" href="https://www.bukalapak.com/u/subambang153">
                        <img style="height: 3rem; width: auto;" src="{{asset('images/mp/bukalapak-min.jpg')}}">
                    </a>
                    <a target="_blank" href="https://tokopedia.link/akZlb4owHab">
                        <img style="height: 3rem; width: auto;" src="{{asset('images/mp/tokopedia-min.jpg')}}">
                    </a>
                    <br>
                    <!-- <a target="_blank" href="https://www.olx.co.id/profile/105547547">
                        <img style="height: 3rem; width: auto;" src="{{asset('images/mp/olx-min.jpg')}}">
                    </a> -->
                    <a target="_blank" href="https://www.lazada.co.id/shop/cahaya-agro">
                        <img style="height: 3rem; width: auto;" src="{{asset('images/mp/lazada.png')}}">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content has-text-centered" style="padding-top: 1rem; margin-top: 1rem;">
    <dt>
        <dl style="font-size: 10px;"><b>Copyright 2021</b>: <a href="https://cahayaagro.com" style="color: #bd2e06;"> PT Cahaya Agro Teknik</a></dl>
    </dt>
</div>

<script>
    $(document).ready(function (){
        hideBack();
    });
    $("#banner-promo").owlCarousel({
        items:1,
        lazyLoad:true,
        loop:true,
        mouseDrag:false,
        touchDrag:false,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:false
    });
    $("#product-promo").owlCarousel({
        responsive:{
            0:{
                items:1
            },
            320:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:4
            },
            1440:{
                items:6
            }
        },
        stagePadding: 30,
        lazyLoad:true,
        autoplay:false,
        nav:true,
        navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"]
    });

    $(document).on('click', '.tabs li, .tabs-to', function(){
        var item = $(this);
        var target = item.attr('data-target');
        $('.tabs li').each(function() {
            $(this).removeClass('is-active');
            $($(this).attr('data-target')).hide();
        });

        item.addClass('is-active');
        $(target).show();
    });

    $(document).ready(function(){
        @if(Cookie::get('newsletter') != 'true')
        @if(\App\Models\Setting::where('setting_code', 'newsletter_config')->first()->setting_value == '1')
        swal({
            text: 'Jadilah yang pertama untuk mengetahui produk baru, penawaran spesial, dan produk terlaris kami. Masukkan email kamu di sini',
            input: 'email',
            imageUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7dqkohs4cyHC6OtxWNUr5QBcHX0bnJVSd3t8pU4tHRgTAZZwV',
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Newsletter',
            showCancelButton: true,
            confirmButtonText: 'Ya, saya mau',
            showLoaderOnConfirm: true,
            animation: false,
            customClass: 'animated tada',
            preConfirm: (login) => {
                return fetch(base_url + `subscribe/${login}`)
                .then(response => {
                    if (!response.ok) {
                    throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    swal.showValidationError(
                    `Request failed: ${error}`
                    )
                })
            },
            allowOutsideClick: () => !swal.isLoading()
            }).then((result) => {
            if (result.value) {
                swal('Good job', result.value.message, 'success');
            }
        })
        @else 
        swal({
            html:'{!!\App\Models\Setting::where('setting_code', 'newsletter_custom')->first()->setting_value!!}'
        })
        @endif
        @endif

        $(document).on('click', '.filter-feed', function(){
            var filter = $(this).attr('data-post');
            if(filter == 0){
                $('.post-feed').fadeIn();
            }
            else if(filter == 3){
                $('.post-feed').not('.post-feed-' + filter).fadeOut();
                $('.post-company').not('.post-company-' + filter).fadeOut();
                $('.post-csr').not('.post-csr-' + filter).fadeOut();
                $('.post-artikel').not('.post-artikel-' + filter).fadeOut();
                $('.post-testimoni').fadeIn();
            }
            else if(filter == 4){
                $('.post-feed').not('.post-feed-' + filter).fadeOut();
                $('.post-company').not('.post-company-' + filter).fadeOut();
                $('.post-testimoni').not('.post-testimoni-' + filter).fadeOut();
                $('.post-artikel').not('.post-artikel-' + filter).fadeOut();
                $('.post-csr').fadeIn();
            }
            else if(filter == 6){
                $('.post-feed').not('.post-feed-' + filter).fadeOut();
                $('.post-testimoni').not('.post-testimoni-' + filter).fadeOut();
                $('.post-csr').not('.post-csr-' + filter).fadeOut();
                $('.post-artikel').not('.post-artikel-' + filter).fadeOut();
                $('.post-company').fadeIn();
            }else if(filter == 10){
                $('.post-feed').not('.post-feed-' + filter).fadeOut();
                $('.post-testimoni').not('.post-testimoni-' + filter).fadeOut();
                $('.post-csr').not('.post-csr-' + filter).fadeOut();
                $('.post-company').not('.post-company-' + filter).fadeOut();
                $('.post-artikel').fadeIn();
            }else{
                $('.post-feed-' + filter).fadeIn();
                $('.post-feed').not('.post-feed-' + filter).fadeOut();
                $('.post-company-' + filter).fadeIn();
                $('.post-company').not('.post-company-' + filter).fadeOut();
            }
        })

        
        $(document).on('click', '.filter-feed', function(){
            var filter = $(this).attr('data-post');
            if(filter == 0){
                $('.post-feed').fadeIn();
            }else{
                $('.post-feed-' + filter).fadeIn();
                $('.post-feed').not('.post-feed-' + filter).fadeOut();
            }
        })
        $(document).on('click', '.filter-promo', function(){
            var filter = $(this).attr('data-post');
            if(filter == 0){
                $('.post-promo').fadeIn();
            }else{
                $('.post-promo-' + filter).fadeIn();
                $('.post-promo').not('.post-promo-' + filter).fadeOut();
            }
        })
    });
</script>
