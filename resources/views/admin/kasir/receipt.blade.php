@extends('layouts.admin')
@section('title', 'Struk Pembayaran')
@section('topbar-title', 'Struk Pembayaran')

@section('content')
<div class="flex justify-center">
    <div class="w-full md:w-7/12 lg:w-5/12">
        <div class="bg-white border border-slate-200 shadow-sm p-6 md:p-8 text-center rounded-2xl" id="receiptCard">
            <!-- Success Icon -->
            <div class="flex items-center justify-center bg-emerald-50 mx-auto mb-4 w-20 h-20 rounded-full border border-emerald-100">
                <i class="bi bi-check2-circle text-emerald-500 text-4xl"></i>
            </div>
            <h4 class="text-xl font-bold text-emerald-600 mb-2 tracking-tight">Transaksi Berhasil!</h4>
            <p class="text-slate-500 text-sm font-medium mb-6">Pembayaran telah terverifikasi dan dicatat</p>

            <!-- Receipt Container -->
            <div class="text-left p-6 mx-auto bg-slate-50 border border-dashed border-slate-300 rounded-xl font-mono max-w-sm">
                <div class="text-center mb-6">
                    <h5 class="text-lg font-bold text-slate-900 mb-1 font-sans tracking-wider">ALKHOMART</h5>
                    <p class="text-xs text-slate-500 font-sans font-medium uppercase tracking-widest">Struk Pembayaran Digital</p>
                </div>

                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-slate-500">No. Invoice:</span>
                    <span class="font-bold text-slate-900">{{ $order->kode_transaksi }}</span>
                </div>
                <div class="flex justify-between text-sm mb-4">
                    <span class="text-slate-500">Tanggal:</span>
                    <span class="font-bold text-slate-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="mb-4 border-t border-dashed border-slate-300"></div>

                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="text-sm">
                            <div class="font-bold text-slate-900 mb-0.5">{{ $item->nama_produk }}</div>
                            <div class="flex justify-between text-slate-500 text-xs">
                                <span>{{ $item->jumlah }} × {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="my-4 border-t border-dashed border-slate-300"></div>

                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-slate-500">Subtotal</span>
                    <span class="font-bold text-slate-900">{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between font-bold mb-3 text-lg text-slate-900 tracking-tight">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between text-sm mb-1.5 text-slate-500">
                    <span>Tunai</span>
                    <span class="font-bold text-slate-900">Rp {{ number_format($order->uang_dibayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-emerald-600 bg-emerald-50 -mx-2 px-2 py-1 rounded">
                    <span>Kembali</span>
                    <span>Rp {{ number_format($order->kembalian, 0, ',', '.') }}</span>
                </div>

                <div class="mt-6 mb-4 border-t border-dashed border-slate-300"></div>
                <p class="text-center text-xs text-slate-500 font-sans font-medium mb-0">Terima kasih atas kunjungan Anda!</p>
            </div>
        </div>

        <div class="flex gap-3 mt-6 justify-center receipt-actions">
            <button onclick="window.print()" class="inline-flex justify-center items-center px-6 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl shadow-sm transition">
                <i class="bi bi-printer mr-2"></i> Cetak Struk
            </button>
            <a href="{{ route('admin.kasir.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition">
                <i class="bi bi-plus-lg mr-2"></i> Transaksi Baru
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body { background: white !important; }
        .sidebar-pro, .topbar-pro, .receipt-actions { display: none !important; }
        .content-pro { margin-left: 0 !important; padding: 0 !important; }
        /* Make receipt full width for POS printer */
        #receiptCard { box-shadow: none !important; border: none !important; margin: 0 !important; padding: 0 !important; background: transparent !important; }
        #receiptCard > div:nth-child(3) {
            border: none !important;
            background: white !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            font-size: 12px !important;
            color: black !important;
        }
        #receiptCard > div:nth-child(3) * { color: black !important; }
        /* Hide success header on print */
        #receiptCard > div:nth-child(1), #receiptCard > h4, #receiptCard > p { display: none !important; }
    }
</style>
@endpush
@endsection
