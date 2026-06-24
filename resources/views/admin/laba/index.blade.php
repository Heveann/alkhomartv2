@extends('layouts.admin')
@section('title', 'Rekap Laba')
@section('topbar-title', 'Rekap Laba')

@section('content')
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-header-title">
            <div class="page-header-icon"><i class="bi bi-graph-up-arrow"></i></div>
            Rekap Laba
        </h1>
        <div class="page-header-subtitle">Analisa keuntungan dari seluruh transaksi</div>
    </div>
</div>


<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card h-full" style="border-left: 0.25rem solid var(--primary); margin-bottom: 0;">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: var(--primary);">Total Pendapatan</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-wallet2 text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
    <div class="card h-full" style="border-left: 0.25rem solid #f4a100; margin-bottom: 0;">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: #f4a100;">Total Modal</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-box-seam text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
    <div class="card h-full" style="border-left: 0.25rem solid #00ac69; margin-bottom: 0;">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: #00ac69;">Total Laba Bersih</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-graph-up-arrow text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-6">
    <div class="p-6">
        <form action="{{ route('admin.laba.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="form-control"
                           value="{{ request('tanggal_dari') }}">
                </div>
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="form-control"
                           value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="flex-1 btn btn-primary">
                        <i class="bi bi-funnel-fill"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.laba.index') }}" class="btn btn-light px-3" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise" style="margin:0;"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Data -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-list-ul mr-2"></i> Rincian Transaksi
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto p-4">
            <table id="labaTable" class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 25%">Kode Transaksi</th>
                        <th style="width: 20%">Tanggal</th>
                        <th style="width: 15%" class="text-right">Pendapatan</th>
                        <th style="width: 15%" class="text-right">Modal</th>
                        <th style="width: 20%" class="text-right">Laba</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    if ($.fn.DataTable.isDataTable('#labaTable')) {
        $('#labaTable').DataTable().destroy();
    }
    var table = $('#labaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.laba.index') }}",
                data: function (d) {
                    d.tanggal_dari = $('input[name="tanggal_dari"]').val();
                    d.tanggal_sampai = $('input[name="tanggal_sampai"]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-slate-500 font-medium' },
                { data: 'kode_transaksi', name: 'kode_transaksi', className: 'text-slate-900 font-bold' },
                { data: 'created_at', name: 'created_at', className: 'text-slate-500 font-medium' },
                { data: 'total_harga', name: 'total_harga', className: 'text-right font-bold text-slate-900' },
                { data: 'total_modal', name: 'total_modal', searchable: false, orderable: false, className: 'text-right text-slate-500 font-medium' },
                { data: 'laba_kotor', name: 'laba_kotor', searchable: false, orderable: false, className: 'text-right', render: function(data) {
                    return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">+' + data + '</span>';
                }}
            ],
            language: {
                search: "Cari Transaksi:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 data",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            dom: '<"dt-controls"lf>t<"dt-footer"ip>'
        });

        // The form submit will handle the full page reload to update the top summary cards as well.
</script>
@endpush
