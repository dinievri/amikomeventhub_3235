@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-12">
    <div class="bg-white rounded-3xl shadow-xl p-8 text-center border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">QR Code Gate Scanner 🎟️</h2>
        <p class="text-slate-500 mb-6 text-sm">Arahkan kamera ke QR Code Tiket Peserta untuk Check-in</p>

        <!-- Area Kamera Scanner -->
        <div id="reader" class="overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 mb-6"></div>

        <!-- Box Hasil Status Scan -->
        <div id="scan-result" class="hidden p-4 rounded-2xl font-bold text-sm transition-all"></div>
    </div>
</div>

<!-- Library HTML5 QR Code Reader -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Pause sementara kamera biar gak spam scan
        html5QrcodeScanner.clear();

        let resultBox = document.getElementById('scan-result');
        resultBox.classList.remove('hidden');
        resultBox.className = "p-4 rounded-2xl font-bold text-sm bg-blue-50 text-blue-600 mb-6";
        resultBox.innerText = "Memproses tiket ID: " + decodedText + "...";

        // Kirim hasil scan ke Server Laravel
        fetch("{{ route('admin.checkin.process') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ order_id: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                resultBox.className = "p-4 rounded-2xl font-bold text-sm bg-green-100 text-green-700 mb-6";
            } else if(data.status === 'warning') {
                resultBox.className = "p-4 rounded-2xl font-bold text-sm bg-amber-100 text-amber-700 mb-6";
            } else {
                resultBox.className = "p-4 rounded-2xl font-bold text-sm bg-red-100 text-red-700 mb-6";
            }
            resultBox.innerText = data.message;

            // Reset scanner setelah 3 detik
            setTimeout(() => {
                location.reload();
            }, 3000);
        })
        .catch(err => {
            resultBox.className = "p-4 rounded-2xl font-bold text-sm bg-red-100 text-red-700 mb-6";
            resultBox.innerText = "Terjadi kesalahan jaringan!";
        });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection