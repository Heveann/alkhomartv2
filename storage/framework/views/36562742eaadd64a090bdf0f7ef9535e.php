<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice <?php echo e($order->kode_transaksi); ?></title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; color: #2563eb; }
        .header p { margin: 5px 0 0 0; color: #64748b; }
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th, .items-table td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        .items-table th { background-color: #f8fafc; font-weight: bold; color: #475569; }
        .items-table .text-right { text-align: right; }
        .items-table .text-center { text-align: center; }
        .total-row th, .total-row td { font-weight: bold; background-color: #f8fafc; }
        .footer { text-align: center; color: #64748b; font-size: 12px; margin-top: 50px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-primary { background-color: #dbeafe; color: #1e40af; }
        .badge-secondary { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE PESANAN</h1>
        <p>Alkhomart E-Commerce</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <strong>Informasi Pelanggan:</strong><br>
                <?php echo e($order->user?->name ?? 'Walk-in Customer'); ?><br>
                <?php if($order->user?->email): ?> <?php echo e($order->user->email); ?> <br> <?php endif; ?>
            </td>
            <td width="50%" class="text-right" style="text-align: right;">
                <strong>Detail Transaksi:</strong><br>
                Kode: <?php echo e($order->kode_transaksi); ?><br>
                Tanggal: <?php echo e($order->created_at->format('d F Y, H:i')); ?> WIB<br>
                Tipe: 
                <?php if($order->tipe == 'online'): ?>
                    <span class="badge badge-primary">Online</span>
                <?php else: ?>
                    <span class="badge badge-secondary">Kasir</span>
                <?php endif; ?>
                <br>
                Status:
                <?php if($order->status == 'selesai'): ?>
                    <span class="badge badge-success">Selesai</span>
                <?php elseif($order->status == 'dibatalkan'): ?>
                    <span class="badge badge-danger">Dibatalkan</span>
                <?php else: ?>
                    <span class="badge badge-warning">Pending</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->nama_produk); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($item->harga, 0, ',', '.')); ?></td>
                <td class="text-center"><?php echo e($item->jumlah); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Keseluruhan</td>
                <td class="text-right text-blue-600">Rp <?php echo e(number_format($order->total_harga, 0, ',', '.')); ?></td>
            </tr>
            <?php if($order->tipe == 'kasir'): ?>
            <tr>
                <td colspan="4" class="text-right">Uang Dibayar</td>
                <td class="text-right">Rp <?php echo e(number_format($order->uang_dibayar, 0, ',', '.')); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Kembalian</td>
                <td class="text-right">Rp <?php echo e(number_format($order->kembalian, 0, ',', '.')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Alkhomart.</p>
        <p>Invoice ini merupakan bukti transaksi yang sah.</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/orders/pdf.blade.php ENDPATH**/ ?>