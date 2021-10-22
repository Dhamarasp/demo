<style>
@media screen and (max-width: 425px) {
    .search-style{
        min-width: 100%;
    }
}
@media screen and (min-width: 426px) {
    .search-style{
        min-width: 70%;
    }
    .align-right{
        right: -20%;
    }
}
</style>
<div id="menu-backdrop"  data-dismiss="quickview"></div>
@if(Cookie::get('apps-version') != 'true')
<nav class="navbar is-link is-fixed-top">
    <div class="navbar-brand">
        <div class="navbar-item is-hidden-mobile is-hidden-tablet-only">
            <span class="icon">
                <img src="{{asset('images/5af0169b2c147686442223.jpg')}}">
            </span>
            &nbsp; &nbsp; Dapatkan promo menarik dengan download aplikasi Cahaya Agro Sekarang Juga
        </div>
        <div class="navbar-item is-hidden-desktop" style="margin-right:auto;">
            <span class="icon">
                <img src="{{asset('images/5af0169b2c147686442223.jpg')}}">
            </span>
            &nbsp; &nbsp; Download di
        </div>
        <a id="l-ps" class="navbar-item is-hidden-desktop" href="https://play.google.com/store/apps/details?id=cahayaagro.cahayaagro.tokoonline">
            <img src="{{asset('images/logo-ps.png')}}" style="width:120px; max-height:42px;">
        </a>
        <a id="l-as" class="navbar-item is-hidden-desktop">
            <img src="{{asset('images/logo-as.png')}}" style="width:120px; max-height:42px;">
        </a>
    </div>
    <div class="navbar-end is-hidden-mobile is-hidden-tablet-only">
        <a class="navbar-item" href="https://play.google.com/store/apps/details?id=cahayaagro.cahayaagro.tokoonline">
            <img src="{{asset('images/logo-ps.png')}}" style="width:120px; max-height:42px;">
        </a>
        <a class="navbar-item">
            <img src="{{asset('images/logo-as.png')}}" style="width:120px; max-height:42px;">
        </a>
    </div>
</nav>
@endif
<div id="search-bar" class="dropdown search-style align-right" style="position: absolute; z-index: 10; ">
    <div class="dropdown-menu search-style">
        <div class="dropdown-content">
            <div class="field" style="margin-right: 1rem; margin-left: 1rem;">
                <p class="control has-icons-left">
                    <input id="search-text" class="input" type="text" placeholder="Search nama produk">
                    <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Desktop Navigation -->
@if(Cookie::get('apps-version') != 'true')
<nav class="navbar is-danger is-primary-color is-fixed-top is-hidden-mobile is-hidden-tablet-only" style="top:3.25rem;">
@else
<nav class="navbar is-danger is-primary-color is-fixed-top is-hidden-mobile is-hidden-tablet-only">
@endif
    <div class="navbar-brand">
        <div class="navbar-menu navbar-item navbar-burger burger is-hidden-mobile" data-show="quickview" data-target="side-menu" style="margin-left: 0; display: none; margin-top: auto; margin-bottom: auto;">
            <span style="top:calc(22% + 10px); height: 3px; width: 25px;"></span>
            <span style="top:calc(22% + 20px); height: 3px; width: 25px;"></span>
            <span style="top:calc(22% + 30px); height: 3px; width: 25px;"></span>
        </div> 
        <a class="navbar-back navbar-item navbar-burger burger target-link" style="margin-left: 0; display: none; margin-top: auto; margin-bottom: auto;" href="">
            <i class="fa fa-arrow-left"></i>
        </a> 
        <div class="navbar-item">
            <a class="target-link" href="#home">
                <img src="{{asset('images/logo-wide-bw.png')}}" style="max-height:7rem;">
            </a>
        </div>
    </div>
    <div class="navbar-end">
        <a class="navbar-item" style="margin-left: auto;" onclick="searchActive()">
            <i class="fa fa-search" style="font-size:2.5rem;"></i>
            <!-- <span>&nbsp; Search</span> -->
        </a>
        <a class="navbar-item target-link" href="#order/cart">
            <i class="fa fa-shopping-cart" style="font-size:2.5rem;"></i>
            <!-- <span>&nbsp; Keranjang Belanja</span> -->
        </a>
        @if(Auth::check())
        <a class="navbar-item" href="#account/gift">
            <i class="fa fa-gift target-link" style="font-size:2.5rem;"></i>
            <span>&nbsp; {{Auth::user()->customer_poin}}</span>
        </a>
        @else
        <a class="navbar-item target-link" href="#account/gift">
            <i class="fa fa-gift" style="font-size:2.5rem;"></i>
            <span>&nbsp; 0</span>
        </a>
        @endif
    </div>
</nav>
<!-- Mobile Navigation -->
@if(Cookie::get('apps-version') != 'true')
<nav class="navbar is-danger is-primary-color is-fixed-top is-hidden-desktop" style="top:3.25rem;">
@else
<nav class="navbar is-danger is-primary-color is-fixed-top is-hidden-desktop">
@endif
    <div class="navbar-brand">
        <div class="navbar-menu navbar-item navbar-burger burger is-hidden-mobile" data-show="quickview" data-target="side-menu" style="margin-left: 0; display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div> 
        <a class="navbar-back navbar-item navbar-burger burger target-link" style="margin-left: 0; display: none;" href="">
            <i class="fa fa-arrow-left"></i>
        </a> 
        <a class="navbar-item target-link" href="#home">
            <img src="{{asset('images/logo-wide-bw.png')}}" height="45">
        </a>
        <a class="navbar-item " style="margin-left: auto;" onclick="searchActive()">
            <i class="fa fa-search"></i>
        </a>
        <a class="navbar-item target-link" href="#order/cart">
            <i class="fa fa-shopping-cart"></i>
        </a>
        @if(Auth::check())
        <a class="navbar-item target-link" href="#account/gift">
            <i class="fa fa-gift"></i>
            <span>&nbsp;{{Auth::user()->customer_poin}}</span>
        </a>
        @else
        <a class="navbar-item target-link" href="#account/gift">
            <i class="fa fa-gift"></i>
            <span>&nbsp;0</span>
        </a>
        @endif
    </div>
</nav>
<nav class="navbar is-fixed-bottom has-shadow is-hidden-desktop">
    <div class="columns is-mobile is-gapless">
        <div class="column" style="text-align:center;">
            <a class="navbar-item target-link" href="#home" style="display:block;">
                <span class="icon">
                    <i class="fa fa-home"></i>
                </span>
                <br>
                <small>Home</small>
            </a>
        </div>
        <div class="column" style="text-align:center;">
            <a class="navbar-item target-link" href="#transaction" style="display:block;">
                <span class="icon">
                    <i class="fa fa-sticky-note"></i>
                </span>
                <br>
                <small>Trx</small>
            </a>
        </div>
        <div class="column" style="text-align:center;">
            <a class="navbar-item target-link" href="#order/cart" style="display:block;">
                <span class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </span>
                <br>
                <small>Cart</small>
            </a>
        </div>
        <div class="column" style="text-align:center;">
            <a class="navbar-item target-link" href="#account" style="display:block;">
                <span class="icon">
                    <i class="fa fa-user"></i>
                </span>
                <br>
                <small>Akun</small>
            </a>
        </div>
        <div class="column" style="text-align:center;">
            
        </div>
    </div>
</nav>