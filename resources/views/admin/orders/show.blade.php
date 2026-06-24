@extends('layouts.admin')
@section('title', 'Detail Pesanan')
@section('topbar-title', 'Detail Pesanan')

@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-header-title">
            <div class="page-header-icon"><i class="bi bi-receipt"></i></div>
            Detail Pesanan <span style="font-size: 1rem; color: var(--gray-light); margin-left: 0.5rem; font-family: monospace;">{{ $order->kode_transaksi }}</span>
        </h1>
        <div class="page-header-subtitle">Informasi lengkap terkait pesanan pelanggan</div>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.orders.pdf', $order) }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: Order Info -->
    <div class="lg:col-span-4">
        <div class="card h-full">
            <div class="card-header">
                <i class="bi bi-info-circle mr-2"></i> Informasi Transaksi
            </div>
            <div class="card-body">
                <div class="bg-slate-100 p-4 mb-6 rounded-lg border border-slate-200">
                    <div class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--gray-light);">Total Tagihan</div>
                    <div class="text-3xl font-bold text-blue-600">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>
                    @if($order->tipe == 'kasir')
                        <hr class="my-3 border-slate-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-slate-500 font-medium">Uang Dibayar:</span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($order->uang_dibayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500 font-medium">Kembalian:</span>
                            <span class="font-bold text-emerald-600">Rp {{ number_format($order->kembalian, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-5">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--gray-light);">Pelanggan</div>
                        <div class="font-bold" style="color: var(--dark);">{{ $order->user?->name ?? 'Walk-in Customer' }}</div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Tipe</div>
                            @if($order->tipe == 'online')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-blue-50 text-blue-600"><i class="bi bi-globe mr-1.5"></i>Online</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-slate-100 text-slate-600"><i class="bi bi-shop mr-1.5"></i>Kasir</span>
                            @endif
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Status</div>
                            @if($order->status == 'selesai')
                                <span class="badge badge-success"><i class="bi bi-check-circle mr-1"></i>Selesai</span>
                            @elseif($order->status == 'dibatalkan')
                                <span class="badge badge-danger"><i class="bi bi-x-circle mr-1"></i>Dibatalkan</span>
                            @else
                                <span class="badge badge-warning"><i class="bi bi-clock mr-1"></i>Pending</span>
                                @if($order->tipe == 'online')
                                <div class="mt-2 flex gap-1">
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn btn-success" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;" onclick="confirmStatusUpdate(event, this.form, 'Tandai pesanan ini sebagai selesai?', 'Ya, Selesai!', '#00ac69', 'success')"><i class="bi bi-check-lg mr-1"></i>Selesai</button>
                                    </form>
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="dibatalkan">
                                        <button type="submit" class="btn btn-danger" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;" onclick="confirmStatusUpdate(event, this.form, 'Apakah Anda yakin ingin membatalkan pesanan ini?', 'Ya, Batalkan!', '#e81500', 'warning')"><i class="bi bi-x-lg mr-1"></i>Batal</button>
                                    </form>
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--gray-light);">Tanggal Pesanan</div>
                        <div class="font-bold" style="color: var(--dark);">{{ $order->created_at->format('d F Y, H:i') }} WIB</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Order Items -->
    <div class="lg:col-span-8">
        <div class="card h-full">
            <div class="card-header">
                <i class="bi bi-cart3 mr-2"></i> Rincian Produk
            </div>
            <div class="card-body p-0">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th class="p-3 text-xs font-bold uppercase" style="color: var(--dark);">Produk</th>
                                <th class="p-3 text-xs font-bold uppercase text-right" style="color: var(--dark);">Harga</th>
                                <th class="p-3 text-xs font-bold uppercase text-center" style="color: var(--dark);">Jumlah</th>
                                <th class="p-3 text-xs font-bold uppercase text-right" style="color: var(--dark);">Subtotal</th>
                                <th class="p-3 text-xs font-bold uppercase text-right" style="color: var(--dark);">Laba</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalLaba = 0; @endphp
                            @foreach($order->items as $item)
                                @php
                                    $laba = ($item->harga - $item->harga_modal) * $item->jumlah;
                                    $totalLaba += $laba;
                                @endphp
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td class="p-3">
                                        <div class="font-bold" style="color: var(--dark);">{{ $item->nama_produk }}</div>
                                        @if($item->product && $item->product->stok <= 5)
                                            <div class="text-xs text-red-500 mt-1 font-medium">(Sisa Stok: {{ $item->product->stok }})</div>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right" style="color: var(--gray);">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="p-3 text-center font-bold" style="color: var(--dark);">{{ $item->jumlah }}x</td>
                                    <td class="p-3 text-right font-bold" style="color: var(--dark);">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="p-3 text-right">
                                        <span class="badge badge-success">+Rp {{ number_format($laba, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="border-top: 2px solid var(--border-color); background-color: rgba(33, 40, 50, 0.03);">
                                <td colspan="3" class="p-3 text-right text-xs font-bold uppercase" style="color: var(--gray-light);">
                                    Total Keseluruhan
                                </td>
                                <td class="p-3 text-right font-bold text-lg" style="color: var(--primary);">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-right font-bold text-lg" style="color: #00ac69;">
                                    +Rp {{ number_format($totalLaba, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
