<?php $__env->startSection('title', 'Pesanan Berhasil'); ?>

<?php $__env->startSection('content'); ?>
<div class="font-sans max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-md p-6 md:p-10 text-center">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-100 shadow-sm">
            <i class="bi bi-check-lg text-green-500 text-4xl"></i>
        </div>
        
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil!</h2>
        <p class="text-gray-600 font-medium mb-8">Terima kasih telah berbelanja di AlkhoMart</p>

        <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 md:p-6 text-left mb-8">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-gray-500">Kode Transaksi</span>
                <strong class="text-sm font-bold text-gray-900"><?php echo e($order->kode_transaksi); ?></strong>
            </div>
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-medium text-gray-500">Tanggal</span>
                <strong class="text-sm font-semibold text-gray-900"><?php echo e($order->created_at->format('d M Y, H:i')); ?></strong>
            </div>
            
            <hr class="border-gray-200 mb-4">
            
            <div class="space-y-3 mb-4">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700 font-medium"><?php echo e($item->nama_produk); ?> <span class="text-gray-400">× <?php echo e($item->jumlah); ?></span></span>
                        <span class="text-sm font-semibold text-gray-900">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <hr class="border-gray-200 mb-4">
            
            <div class="flex justify-between items-center">
                <strong class="text-base font-bold text-gray-900">Total Pembayaran</strong>
                <strong class="text-xl font-bold text-blue-600">
                    Rp <?php echo e(number_format($order->total_harga, 0, ',', '.')); ?>

                </strong>
            </div>
        </div>

        <a href="<?php echo e(route('pembeli.products')); ?>" class="inline-flex justify-center items-center bg-blue-600 text-white hover:bg-blue-700 font-semibold py-3 px-8 rounded-lg shadow-sm transition-colors w-full sm:w-auto gap-2">
            <i class="bi bi-arrow-left"></i> Lanjut Belanja
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/pembeli/checkout/success.blade.php ENDPATH**/ ?>