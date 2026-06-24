<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="mb-12 border-b border-black pb-4 flex items-end justify-between">
        <h1 class="text-4xl font-black text-black tracking-tighter">Keranjang Anda.</h1>
        <p class="text-gray-500 font-medium hidden sm:block"><?php echo e($carts->count() > 0 ? $carts->sum('jumlah') . ' Items' : 'Kosong'); ?></p>
    </div>

    <?php if($carts->count() > 0): ?>
        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Main Cart Items -->
            <div class="w-full lg:w-2/3">
                <div class="flex flex-col gap-8">
                    <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-8 border-b border-gray-100 relative group">
                            <div class="flex items-center gap-6 w-full sm:w-auto mb-4 sm:mb-0">
                                <?php if($cart->product->gambar): ?>
                                    <div class="w-24 h-32 bg-[#F9F9F9] overflow-hidden shrink-0">
                                        <img src="<?php echo e(asset('storage/' . $cart->product->gambar)); ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-24 h-32 bg-gray-50 flex items-center justify-center shrink-0">
                                        <i class="bi bi-image text-gray-300 text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex flex-col">
                                    <a href="<?php echo e(route('pembeli.products.show', $cart->product)); ?>" class="text-lg font-medium text-black hover:text-gray-500 transition mb-1"><?php echo e($cart->product->nama_produk); ?></a>
                                    <div class="text-sm text-gray-500 mb-3">Rp <?php echo e(number_format($cart->product->harga, 0, ',', '.')); ?></div>
                                    <form action="<?php echo e(route('pembeli.cart.destroy', $cart)); ?>" method="POST" class="mt-auto">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5 inline-block"
                                                onclick="return confirm('Hapus item ini dari keranjang?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-8">
                                <form action="<?php echo e(route('pembeli.cart.update', $cart)); ?>" method="POST" class="flex items-center border-b border-gray-300 py-1">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <span class="text-xs font-bold uppercase text-gray-400 mr-3">Qty</span>
                                    <input type="number" name="jumlah" value="<?php echo e($cart->jumlah); ?>"
                                           min="1" max="<?php echo e($cart->product->stok); ?>"
                                           class="w-12 text-center text-lg text-black font-medium bg-transparent focus:outline-none"
                                           onchange="this.form.submit()">
                                </form>
                                
                                <div class="text-lg font-medium text-black">
                                    Rp <?php echo e(number_format($cart->product->harga * $cart->jumlah, 0, ',', '.')); ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Sidebar Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-[#F9F9F9] p-8 lg:p-10 sticky top-24">
                    <h3 class="text-xl font-black text-black mb-8 tracking-tighter">Ringkasan</h3>
                    
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500">Subtotal (<?php echo e($carts->sum('jumlah')); ?> item)</span>
                        <span class="font-medium text-black">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between items-center mb-8 pb-8 border-b border-gray-200">
                        <span class="text-gray-500">Pengiriman</span>
                        <span class="text-gray-400 text-sm">Dihitung saat checkout</span>
                    </div>
                    
                    <div class="flex justify-between items-end mb-10">
                        <span class="text-black font-bold uppercase tracking-widest text-sm">Total</span>
                        <span class="text-3xl font-medium text-black">
                            Rp <?php echo e(number_format($total, 0, ',', '.')); ?>

                        </span>
                    </div>
                    
                    <a href="<?php echo e(route('pembeli.checkout')); ?>" class="w-full bg-black text-white hover:bg-gray-800 font-medium text-sm tracking-widest uppercase py-5 px-4 transition-colors flex justify-center items-center mb-4">
                        Lanjut ke Checkout
                    </a>
                    
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="w-full bg-transparent border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-4 transition-colors flex justify-center items-center">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="py-32 flex flex-col items-center justify-center text-center">
            <h3 class="text-3xl md:text-4xl font-black text-black mb-4 tracking-tighter">Keranjang Anda Kosong</h3>
            <p class="text-lg text-gray-500 mb-10 max-w-md">Sepertinya Anda belum memilih produk apa pun. Temukan gaya esensial Anda sekarang.</p>
            <a href="<?php echo e(route('pembeli.products')); ?>" class="border-b-2 border-black text-black hover:text-gray-500 hover:border-gray-500 font-medium text-sm tracking-widest uppercase pb-1 transition-colors">
                Mulai Belanja
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/pembeli/cart/index.blade.php ENDPATH**/ ?>