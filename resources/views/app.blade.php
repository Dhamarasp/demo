<!doctype html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui">
        <meta name="token" content="{{csrf_token()}}">
        <meta name="theme-color" content="#000000">

        <title>Cahaya Agro | Produksi Mesin - Mesin Teknologi Tepat Guna</title>
        <link rel="shortcut icon" href="{{asset('images/5af0169b2c147686442223.jpg')}}">
        <link rel="manifest" href="{{asset('manifest.json')}}">
        
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <base href="{{url('')}}/">

        <meta name="ogTitle" property="og:title" content="Cahaya Agro | Produksi Mesin - Mesin Teknologi Tepat Guna">
        <meta name="ogDescription" property="og:description" content="">
        <meta name="ogImage" property="og:image" content="{{asset('images/5af0169b2c147686442223.jpg')}}">
        <meta name="ogUrl" property="og:url" content="{{env('APP_URL', '/')}}">

        <meta name="apple-mobile-web-app-title" content="Cahaya Agro | Produksi Mesin - Mesin Teknologi Tepat Guna">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <link rel="apple-touch-icon" href="{{asset('images/5af0169b2c147686442223.jpg')}}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{asset('images/5af0169b2c147686442223.jpg')}}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{asset('images/5af0169b2c147686442223.jpg')}}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{asset('images/5af0169b2c147686442223.jpg')}}">

        @stack('meta')
        
        <!-- external src -->
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,600">
        
        <!-- internal src -->
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/izitoast-1.3.0/dist/css/iziToast.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/nprogress-0.2.0/nprogress.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/animated.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/bulma-0.6.2/css/bulma.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/bulma-quickview/dist/bulma-quickview.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/bulma-calendar/dist/bulma-calendar.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/owlcarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/owlcarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('vendor/sweetalert2-7.18.0/dist/sweetalert2.min.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/flag-icon/flag-icon.min.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/style.css?id='.uniqid())}}">

        <script>
            var base_url = document.getElementsByTagName('base')[0].getAttribute('href');
        </script>
        <!-- <script async src="https://s.widgetwhats.com/wwwa.js" data-wwwa="2516"></script> -->
    </head>
    <body>
        @yield('content')
        <div class="content is-hidden-desktop" style="height:2rem;">
        </div>
    </body>
    
    
    <!-- internal src -->
    <script type="text/javascript" src="{{asset('vendor/jquery-2.2.0/jquery-2.2.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/izitoast-1.3.0/dist/js/iziToast.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/nprogress-0.2.0//nprogress.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/bulma-quickview/dist/bulma-quickview.js?id='.uniqid())}}"></script>
    <script type="text/javascript" src="{{asset('vendor/owlcarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/sweetalert2-7.18.0/dist/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/app-bulma.js?id='.uniqid())}}"></script>

    <!-- external src -->
    
    <script type="text/javascript" src="https://www.jacklmoore.com/js/jquery.zoom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js" integrity="sha256-h2tMEmhemR2IN4wbbdNjj9LaDIjzwk2hralQwfJmBOE=" crossorigin="anonymous"></script>
    @stack('scripts')
    <script>
    @if(Session::has('toast-error'))
        $(window).load(function(){
            iziToast.warning({ title: 'Oops', message: '{{Session::get('toast-error')}}', position: 'topRight' });
        });
    @endif
    @if(Session::has('toast-success'))
        $(window).load(function(){
            iziToast.success({ title: 'Good job', message: '{{Session::get('toast-success')}}', position: 'topRight' });
        });
    @endif
    @if(Session::has('swal-error'))
        $(window).load(function(){
            swal('Oops', '{{Session::get('swal-error')}}', 'error');
        });
    @endif
    @if(Session::has('swal-success'))
        $(window).load(function(){
            swal('Good job', '{{Session::get('swal-success')}}', 'success');
        });
    @endif
    
    </script>
    <script>
        function searchActive(){
            if($('#search-bar').hasClass('is-active')){
                $('#search-bar').removeClass('is-active');
            }else{
                $('#search-bar').addClass('is-active');
                document.getElementById("search-text").focus();
            }
        }

        $(document).ready(function(){
            $("#search-text").on('keyup', function (e) {
                if(e.keyCode == 13) {
                    loadURI('search?q='+ $('#search-text').val());
                    $('#search-text').val('');
                }
            });
        });
    </script>
    @if(env('APP_ENV', 'local') == 'production')
    <!-- <script async data-id="2935" src="{{asset('js/wajs.min.js?v=1')}}"></script> -->
    <!-- <script async data-id="2516" src="{{asset('js/wajs.min.js?v=1')}}"></script> -->
    <script async src="https://s.widgetwhats.com/wwwa.js" data-wwwa="2516"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107066470-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-107066470-1');
    </script>

    <script charset="UTF-8" src="//cdn.sendpulse.com/9dae6d62c816560a842268bde2cd317d/js/push/3227885c9ef0f976c0ccc908e193bcc8_1.js" async></script>

    <script>
        $(document).on("click", "#okewa-floating_popup .okewa-multiple_cs .okewa-chat div[class*='list-cs_']:not('.offline')", function () {
            ga("gtag_UA_107066470_1.send", {
                hitType: 'event',
                eventAction: 'click',
                eventCategory: 'Open Whatsapp Chat',
                eventLabel: 'open-wa'
            });
        })
    </script>
    @endif
</html>

<!-- Build with Laravel 5.5, php7.2.7 for www.cahayaagro.com -->
<!-- Copyright 2019 Mataduniadigital & Rio Ramadhan (https://gitlab.com/riordhn) (https://github.com/riordhn) -->