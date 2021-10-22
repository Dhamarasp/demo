@push('meta')
@endpush 

@extends('app')
@section('content')
@include('partials/side-menu')
@include('partials/header-nav')
@if(Cookie::get('apps-version') != 'true')
<div class="has-text-centered div is-custom is-apps" id="apploader" style="display: none;">
@else
<div class="has-text-centered div is-custom" id="apploader" style="display: none;">
@endif
    <button class="button is-loading is-loader"></button>
</div>
@if(Cookie::get('apps-version') != 'true')
<div class="div is-custom" id="appcontent">
@else
<div class="div is-custom is-apps" id="appcontent">
@endif
</div>
@endsection 

@push('scripts')
<script>
    $(document).ready(function  () {
        var original_title = location.hash;
        var target_url = original_title.replace('#','');
        if (target_url == '' || target_url == '/' || target_url == 'undefined') {
            loadURI('home');
        }else{
            loadURI(target_url);
        }

        if(isMobile.iOS()){
            $('#l-ps').hide();
        }

        if(isMobile.Android()){
            $('#l-as').hide();
        }
    });

    $(document).on('click', 'a.target-link', function(e){
        e.preventDefault();
        var item = $(this);
        var target_url = item.attr('href').replace('#','');
        location.hash = target_url;
        // loadURI(target_url);
    });

    // User's mouse is inside the page.
    document.onmouseover = function() {
        window.innerDocClick = true;
    }

    // User's mouse has left the page.
    document.onmouseleave = function() {
        window.innerDocClick = false;
    }

    window.onhashchange = function() {
        // if (window.innerDocClick) {
            //Your own in-page mechanism triggered the hash change
        // } else {
            //Browser back button was clicked
            var original_title = location.hash;
            var target_url = original_title.replace('#','');
            if (target_url == '' || target_url == '/' || target_url == 'undefined') {
                loadURI('home');
            }else{
                loadURI(target_url);
            }
        // }
    }

    function hideBack(){
        $('.navbar-menu').show();
        $('.navbar-back').hide();
    }

    function back(target_url){
        $('.navbar-menu').hide();
        $('.navbar-back').show();
        $('.navbar-back').attr('href', target_url);
    }

    function loadingContent(content){
        if($('#apploader').is(':visible')){
            
            $('#appcontent').show();
            $('#apploader').hide();
        }else{
            
            $('#appcontent').hide();
            $('#apploader').show();
        }
        
    }

    function ajaxPostRequest(target_url, success_function, data){
        data = typeof data !== 'undefined' ? data : null;
        $.ajax({
            type: 'POST',
            url: base_url + target_url,
            async: false,
            data: data,
            success: success_function
        });
    }

    function isEmptyHtml(el){
        return !$.trim(el.html())
    }

    function loadURI(target_url, content, history) {
        content = typeof content !== 'undefined' ? content : 'appcontent';
        history = typeof history !== 'undefined' ? history : target_url;
        // loadingContent(content);
        NProgress.start();
        $.ajax({
            type: 'GET',
            url: base_url + target_url,
            contentType: false,
            success: function (data) {
                location.hash = history;
                $("#" + content).html(data);
                NProgress.done();
                // loadingContent(content);
            },
            error: function (xhr, status, error) {
                // alert(xhr.responseText);
            }
        });
    }

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
</script>
@endpush