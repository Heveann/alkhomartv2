<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Pesanan</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; color: #2563eb; }
        .header p { margin: 5px 0 0 0; color: #64748b; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        .table th { background-color: #f8fafc; font-weight: bold; color: #475569; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; display: inline-block; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-primary { background-color: #dbeafe; color: #1e40af; }
        .badge-secondary { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP PESANAN</h1>
        <p>Alkhomart E-Commerce | Tanggal Export: <?php echo e(now()->format('d M Y H:i')); ?></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th width="20%">Pelanggan</th>
                <th width="15%" class="text-right">Total</th>
                <th width="10%" class="text-center">Tipe</th>
                <th width="15%" class="text-center">Status</th>
                <th width="20%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($order->kode_transaksi); ?></td>
                <td><?php echo e($order->user?->name ?? 'Walk-in Customer'); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($order->total_harga, 0, ',', '.')); ?></td>
                <td class="text-center">
                    <?php if($order->tipe == 'online'): ?>
                        <span class="badge badge-primary">Online</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Kasir</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if($order->status == 'selesai'): ?>
                        <span class="badge badge-success">Selesai</span>
                    <?php elseif($order->status == 'dibatalkan'): ?>
                        <span class="badge badge-danger">Dibatalkan</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Pending</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pesanan</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Keseluruhan</th>
                <th class="text-right text-blue-600">Rp <?php echo e(number_format($orders->sum('total_harga'), 0, ',', '.')); ?></th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/orders/export_pdf.blade.php ENDPATH**/ ?>