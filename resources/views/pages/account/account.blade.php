@php
    $customer = Auth::user();
@endphp
<div class="content has-text-centered is-gap">
    <p class="title is-5">Hai kak {{$customer->customer_name}}</p>
    @if($customer->customer_poin == 0)
    <p class="title is-6">CA Gift kamu masih 0 nih, <br><a class="target-link" href="#products?category=&sort=newest">yuk belanja</a></p>
    @else
    <p class="title is-6">CA Gift kamu sudah {{$customer->customer_poin}} nih, <br><a class="target-link" href="#products?category=&sort=newest">tambah lagi yuk</a></p>
    @endif
</div>
<aside class="menu">
    <ul class="menu-list">
        <li>
            <a class="target-link" href="#account/edit">
                <span class="icon">
                    <i class="fa fa-user"></i>
                </span>
                    Edit profil
            </a>
        </li>
        <li>
            <a class="target-link" href="#account/address">
                <span class="icon">
                    <i class="fa fa-address-book"></i>
                </span>
                    Daftar alamat tersimpan
            </a>
        </li>
        <li>
            <a class="target-link" href="#wishlist">
                <span class="icon">
                    <i class="fa fa-heart"></i>
                </span>
                Favorit
            </a>
        </li>
        <li>
            <a class="target-link" href="#account/password/change">
                <span class="icon">
                    <i class="fa fa-key"></i>
                </span>
                Ubah password
            </a>
        </li>
        <li>
            <a class="target-link" href="#post/12">
                <span class="icon">
                    <i class="fa fa-question-circle"></i>
                </span>
                FAQ
            </a>
        </li>
        <li>
            <a onclick="signoutAction()">
                <span class="icon">
                    <i class="fa fa-sign-out"></i>
                </span>
                Keluar
            </a>
        </li>
    </ul>
</aside>

<script>
    $(document).ready(function  () {
        hideBack();
    });

    function signoutAction(){
        ajaxPostRequest('account/signout', function(result){
            if(result.status == 200){
                iziToast.success({ title: 'OK', message: result.message });
                // var original_title = location.hash;
                // var target_url = original_title.replace('#','');
                // loadURI(target_url);
                location.reload();
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        });
    }
</script>