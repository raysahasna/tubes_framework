@extends('layout')

@section('konten')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pembayaran dengan Midtrans</div>
                <div class="card-body">
                    <p>Silakan klik tombol di bawah untuk melanjutkan pembayaran melalui Midtrans:</p>
                    <button id="pay-button" class="btn btn-primary btn-lg">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need to show the snap popup.
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                /* You may add your own implementation here */
                console.log(result);
                alert("Transaksi berhasil!");
                window.location = "{{ route('invoice.show', ['transaksi' => $orderId]) }}"; // Ganti 'id' dengan 'transaksi' // Redirect ke halaman invoice
            },
            onPending: function(result) {
                /* You may add your own implementation here */
                console.log(result);
                alert("Menunggu pembayaran!");
            },
            onError: function(result) {
                /* You may add your own implementation here */
                console.log(result);
                alert("Pembayaran gagal!");
            },
            onClose: function() {
                /* You may add your own implementation here */
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        })
    });
</script>
<script type="text/javascript"
  src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection