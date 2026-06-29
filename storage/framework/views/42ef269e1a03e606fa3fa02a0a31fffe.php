<?php $__env->startSection('title', 'Rekap Pesanan'); ?>
<?php $__env->startSection('topbar-title', 'Rekap Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-header-title">
            <div class="page-header-icon"><i class="bi bi-receipt"></i></div>
            Daftar Pesanan
        </h1>
        <div class="page-header-subtitle">Semua riwayat transaksi pesanan online maupun kasir</div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-6">
    <div class="p-6">
        <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="dibatalkan" <?php echo e(request('status') == 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Tipe</label>
                    <select name="tipe" class="form-select">
                        <option value="">Semua</option>
                        <option value="online" <?php echo e(request('tipe') == 'online' ? 'selected' : ''); ?>>Online</option>
                        <option value="kasir" <?php echo e(request('tipe') == 'kasir' ? 'selected' : ''); ?>>Kasir</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Periode Cepat</label>
                    <select name="period" class="form-select">
                        <option value="">Semua Waktu</option>
                        <option value="1_hour">1 Jam Terakhir</option>
                        <option value="1_day">1 Hari Terakhir</option>
                        <option value="1_week">1 Minggu Terakhir</option>
                        <option value="1_month">1 Bulan Terakhir</option>
                        <option value="1_year">1 Tahun Terakhir</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Bulan</label>
                    <input type="month" name="filter_bulan" class="form-control">
                </div>
                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 btn btn-primary">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <button type="button" onclick="resetAllFilters()" class="btn btn-light px-3" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise" style="margin:0;"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Data -->
<div class="card">
    <div class="card-header flex justify-between items-center z-50">
        <div>
            <i class="bi bi-receipt mr-2"></i> Riwayat Pesanan
        </div>
        <div x-data="{ openExport: false }" class="relative z-10">
            <button @click="openExport = !openExport" @click.away="openExport = false" class="btn btn-light" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                <i class="bi bi-download"></i> Export <i class="bi bi-chevron-down ml-1 text-[10px]" style="margin-right:0;"></i>
            </button>
            <div x-show="openExport" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1" style="display: none;">
                <a href="#" onclick="event.preventDefault(); $('.buttons-excel').click(); openExport = false;" class="block px-4 py-2 text-sm font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    <i class="bi bi-file-earmark-excel mr-2 text-emerald-600"></i> Excel
                </a>
                <a href="#" onclick="event.preventDefault(); let url='<?php echo e(route('admin.orders.exportPdf')); ?>?status='+$('select[name=status]').val()+'&tipe='+$('select[name=tipe]').val()+'&period='+$('select[name=period]').val()+'&filter_bulan='+$('input[name=filter_bulan]').val(); window.open(url, '_blank'); openExport = false;" class="block px-4 py-2 text-sm font-bold text-slate-700 hover:bg-red-50 hover:text-red-700 transition-colors">
                    <i class="bi bi-file-earmark-pdf mr-2 text-red-600"></i> PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto p-4">
            <table id="ordersTable" class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 15%">Kode Transaksi</th>
                        <th style="width: 20%">Pelanggan</th>
                        <th style="width: 15%" class="text-right">Total</th>
                        <th style="width: 10%" class="text-center">Tipe</th>
                        <th style="width: 10%" class="text-center">Status</th>
                        <th style="width: 15%">Tanggal</th>
                        <th style="width: 10%" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    if ($.fn.DataTable.isDataTable('#ordersTable')) {
        $('#ordersTable').DataTable().destroy();
    }
    var table = $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo e(route('admin.orders.index')); ?>",
                data: function (d) {
                    d.status = $('select[name="status"]').val();
                    d.tipe = $('select[name="tipe"]').val();
                    d.period = $('select[name="period"]').val();
                    d.filter_bulan = $('input[name="filter_bulan"]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-slate-500 font-medium' },
                { data: 'kode_transaksi', name: 'kode_transaksi', className: 'text-slate-900 font-bold' },
                { data: 'pelanggan', name: 'user.name', className: 'text-slate-700' },
                { data: 'total_harga', name: 'total_harga', className: 'text-right font-bold text-slate-900' },
                { data: 'tipe', name: 'tipe', className: 'text-center' },
                { data: 'status', name: 'status', className: 'text-center' },
                { data: 'created_at', name: 'created_at', className: 'text-slate-500 font-medium' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-right' }
            ],
            language: {
                search: "Cari Pesanan:",
                lengthMenu: "Tampilkan _MENU_ pesanan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pesanan",
                infoEmpty: "Menampilkan 0 pesanan",
                infoFiltered: "(disaring dari _MAX_ pesanan)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            dom: '<"dt-controls"lf>t<"dt-footer"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'hidden',
                    exportOptions: { 
                        columns: [0, 1, 2, 3, 4, 5, 6],
                        rows: function ( idx, data, node ) {
                            return data.status ? data.status.toLowerCase().includes('selesai') : false;
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    className: 'hidden',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
                }
            ]
        });

        // Custom Filter Logic
        $('form').on('submit', function(e) {
            e.preventDefault();
            table.draw();
        });
    function resetAllFilters() {
        $('select[name="status"]').val('');
        $('select[name="tipe"]').val('');
        $('select[name="period"]').val('');
        $('input[name="filter_bulan"]').val('');
        $('#ordersTable').DataTable().draw();
    }

    // Auto-refresh data every 5 seconds for real-time updates
    setInterval(function() {
        table.ajax.reload(null, false); // false = keep current paging position
    }, 5000);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>