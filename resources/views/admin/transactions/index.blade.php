@extends('layouts.admin')

@section('title','Laporan Transaksi')

@section('content')

<div class="bg-white rounded shadow p-6">

<table class="table-auto w-full">

<thead>

<tr>
    <th>Order ID</th>
    <th>Pembeli</th>
    <th>Event</th>
    <th>Status</th>
    <th>Total</th>
</tr>

</thead>

<tbody>

@foreach($transactions as $trx)

<tr>

<td>{{ $trx->order_id }}</td>

<td>
{{ $trx->customer_name }}
</td>

<td>
{{ $trx->event->title }}
</td>

<td>
{{ $trx->status }}
</td>

<td>
Rp {{ number_format($trx->total_price) }}
</td>

</tr>

@endforeach

</tbody>

</table>

{{ $transactions->links() }}

</div>

@endsection