<div class="content has-text-centered is-gap">
    <p class="title is-5">Transaksi Saya</p>
</div>
@if($transactions->first())
<div style="padding-right:0.75rem;padding-left:0.75rem;">
    <div class="columns is-mobile is-multiline">
        @foreach($transactions as $transaction)
        <div class="column is-12-mobile is-12-desktop" style="border: 1px solid #ff3860;">
            <a class="target-link" href="transaction/detail/{{$transaction->transaction_number}}">
                <div class="content" style="overflow: hidden;">
                    <p class="title is-5">INV NO: {{explode('CAT', $transaction->transaction_number)[0].'/CAT/'.substr(explode('CAT', $transaction->transaction_number)[1], 0, 2).'/'.substr(explode('CAT', $transaction->transaction_number)[1], 2)}}</p>
                    <p class="subtitle is-6">
                    Tanggal transaksi: {{date_format(date_create($transaction->created_at), 'd M Y H:i')}} WIB<br>
                    Total Transaksi: IDR {{number_format($transaction->transaction_subtotal)}}<br>
                    @if($transaction->transaction_status == 0)
                    Status: <b style="color:red;">Belum terbayar</b></p>
                    @elseif($transaction->transaction_status == 1)
                    Status: <b style="color:blue;">Dalam proses pelunasan</b></p>
                    @elseif($transaction->transaction_status == 2)
                    Status: <b style="color:green;">Lunas</b></p>
                    @elseif($transaction->transaction_status == 3)
                    Status: <b style="color:green;">In shipping</b></p>
                    @elseif($transaction->transaction_status == 4)
                    Status: <b style="color:green;">Delivered</b></p>
                    @elseif($transaction->transaction_status == 10)
                    Status: <b style="color:green;">Expired</b></p>
                    @endif
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="box">
    <div class="content has-text-centered">
        <p class="subtitle is-6">Belum ada transaksi</p>
    </div>
</div>
@endif
<script>
    $(document).ready(function  () {
        hideBack();
    });
</script>