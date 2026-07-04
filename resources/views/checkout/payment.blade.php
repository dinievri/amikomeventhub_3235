@extends('layouts.app')

@section('content')

<div class="container mx-auto py-20 text-center">

<h1 class="text-3xl font-bold">

Pembayaran

</h1>

<p class="mt-4">

Order :
{{ $transaction->order_id }}

</p>

<button
id="pay-button"
class="bg-indigo-600 text-white px-6 py-3 rounded mt-6">

Bayar Sekarang

</button>

</div>

<script
src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>

document
.getElementById('pay-button')
.addEventListener('click',function(){

snap.pay(
'{{ $transaction->snap_token }}',
{

onSuccess:function(result){

window.location.href =
"/success/{{ $transaction->order_id }}";

},

onPending:function(result){

alert("Menunggu Pembayaran");

},

onError:function(result){

alert("Pembayaran Gagal");

}

});

});

</script>

@endsection