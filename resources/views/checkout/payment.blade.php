@extends('layouts.app')

@section('content')

<div class="container mx-auto py-20 text-center">
    <h1 class="text-3xl font-bold">Pembayaran Tiket</h1>
    <p class="mt-4">Order ID: <strong>{{ $transaction->order_id }}</strong></p>
    <p class="mt-2 text-gray-600">Total Pembayaran: <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>

    {{-- Cek jika snap_token ada --}}
    @if($transaction->snap_token)
        <button id="pay-button" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg mt-6 transition duration-200">
            Bayar Sekarang
        </button>
    @else
        <p class="mt-6 text-red-500 font-semibold">Gagal memuat token pembayaran. Silakan coba checkout ulang.</p>
    @endif
</div>

{{-- Memanggil Midtrans JS dengan fallback ke env jika config kosong --}}
<script 
    src="https://app.sandbox.midtrans.com/snap/snap.js" 
    data-client-key="{{ config('midtrans.client_key', env('MIDTRANS_CLIENT_KEY')) }}">
</script>

<script>
    document.getElementById('pay-button')?.addEventListener('click', function () {
        
        let snapToken = '{{ $transaction->snap_token }}';

        if (!snapToken) {
            alert('Token pembayaran tidak valid.');
            return;
        }

        snap.pay(snapToken, {
            // Jika berhasil, redirect menggunakan route Laravel (lebih aman daripada hardcode URL)
            onSuccess: function(result) {
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },

            // Jika pending (pilih Transfer Bank/Gopay tapi belum bayar)
            onPending: function(result) {
                alert("Menunggu Pembayaran. Silakan selesaikan pembayaran Anda sesuai instruksi Midtrans.");
                window.location.reload();
            },

            // Jika gagal
            onError: function(result) {
                alert("Pembayaran Gagal! Silakan coba lagi.");
                console.error(result);
            },

            // Jika pop-up Midtrans ditutup paksa oleh user
            onClose: function() {
                alert('Anda menutup pop-up sebelum menyelesaikan pembayaran.');
            }
        });
    });
</script>

@endsection