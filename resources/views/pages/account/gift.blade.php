@php
    $customer = Auth::user();
@endphp
<div class="content has-text-centered">
    @if($customer->customer_poin == 0)
    <p class="title is-6">CA Gift kamu masih 0 nih, <br><a class="target-link" href="#products?category=&sort=newest">yuk belanja</a></p>
    @else
    <p class="title is-6">CA Gift kamu sudah {{$customer->customer_poin}} nih, <br><a class="target-link" href="#products?category=&sort=newest">tambah lagi yuk</a></p>
    @endif
</div>
<div class="content has-text-centered">
    <p class="subtitle is-6">CA Gift adalah poin hadiah terima kasih untuk kamu yang sudah melakukan pembelanjaan terhadap Cahaya Agro. Poin hadiah ini dapat kamu tukarkan dengan promo-promo menarik dari kami.</p>
</div>
<figure class="image">
    <img src="https://uwm.edu/business/wp-content/uploads/sites/34/2014/03/600x250.gif">
</figure>
<br>
<figure class="image">
    <img src="https://uwm.edu/business/wp-content/uploads/sites/34/2014/03/600x250.gif">
</figure>
<br>
<script>
    $(document).ready(function (){
        hideBack();
    });
</script>