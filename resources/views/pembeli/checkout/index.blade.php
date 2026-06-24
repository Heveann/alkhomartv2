@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="mb-12 border-b border-black pb-4">
        <h1 class="text-4xl font-black text-black tracking-tighter mb-2">Checkout.</h1>
        <p class="text-gray-500 font-medium">Satu langkah lagi untuk memiliki koleksi pilihan Anda.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-16">
        <!-- List of items -->
        <div class="w-full lg:w-2/3">
            <h3 class="text-xl font-bold text-black mb-8 tracking-wide">Pesanan Anda</h3>
            <div class="flex flex-col gap-6">
                @foreach($carts as $cart)
                    <div class="flex items-center gap-6 pb-6 border-b border-gray-100">
                        @if($cart->product->gambar)
                            <div class="w-20 h-24 bg-[#F9F9F9] overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $cart->product->gambar) }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-20 h-24 bg-gray-50 flex items-center justify-center shrink-0">
                                <i class="bi bi-image text-gray-300 text-2xl"></i>
                            </div>
                        @endif
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <strong class="block text-lg font-medium text-black mb-1">{{ $cart->product->nama_produk }}</strong>
                                <span class="text-sm text-gray-500">Qty: {{ $cart->jumlah }} &times; Rp {{ number_format($cart->product->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-lg font-medium text-black text-right">
                                Rp {{ number_format($cart->product->harga * $cart->jumlah, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Summary -->
        <div class="w-full lg:w-1/3">
            <div class="bg-[#F9F9F9] p-8 lg:p-10 sticky top-24">
                <h3 class="text-xl font-black text-black mb-8 tracking-tighter">Pembayaran</h3>
                
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500">Subtotal ({{ $carts->sum('jumlah') }} item)</span>
                    <span class="font-medium text-black">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between items-center mb-8 pb-8 border-b border-gray-200">
                    <span class="text-gray-500">Pengiriman</span>
                    <span class="font-medium text-black">Gratis</span>
                </div>

                <div class="flex justify-between items-end mb-10">
                    <span class="text-black font-bold uppercase tracking-widest text-sm">Total</span>
                    <span class="text-3xl font-medium text-black">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>

                <form id="checkoutForm" action="{{ route('pembeli.checkout.process') }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmCheckout()" class="w-full bg-black text-white hover:bg-gray-800 font-medium text-sm tracking-widest uppercase py-5 px-4 transition-colors flex justify-center items-center mb-4">
                        Selesaikan Pembayaran
                    </button>
                </form>

                <a href="{{ route('pembeli.cart') }}" class="w-full bg-transparent border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-4 transition-colors flex justify-center items-center">
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmCheckout() {
        Swal.fire({
            title: 'Konfirmasi Pesanan',
            text: "Apakah Anda yakin ingin memproses pesanan ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#000000',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Bayar Sekarang!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'font-sans rounded-none border border-gray-200',
                confirmButton: 'rounded-none font-medium px-6 py-3 tracking-widest uppercase text-sm',
                cancelButton: 'rounded-none font-medium text-white px-6 py-3 tracking-widest uppercase text-sm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkoutForm').submit();
            }
        })
    }
</script>
@endpush
@endsection
