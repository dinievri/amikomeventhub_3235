@extends('layouts.app')

@section('content')

<div class="container mx-auto py-20 text-center">

<h1 class="text-4xl font-bold text-green-600">

Pembayaran Berhasil

</h1>

<p class="mt-5">

Order ID :

<strong>

{{ $transaction->order_id }}

</strong>

</p>

<p>

Email :

<strong>

{{ $transaction->customer_email }}

</strong>

</p>

<p class="mt-4">

Terima kasih telah membeli tiket.

</p>

</div>

@endsection