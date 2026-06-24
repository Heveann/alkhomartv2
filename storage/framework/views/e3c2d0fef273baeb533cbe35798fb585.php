<?php $__env->startSection('title', $product->nama_produk); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="mb-12">
        <a href="<?php echo e(route('pembeli.products')); ?>" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-black transition-colors border-b border-transparent hover:border-black pb-0.5">
            <i class="bi bi-arrow-left mr-3"></i> Kembali ke Koleksi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
        <!-- Product Image Section -->
        <div class="w-full flex flex-col gap-6" x-data="{ mainImage: '<?php echo e($product->images->count() > 0 ? $product->images->first()->url : ($product->gambar ? asset('storage/' . $product->gambar) : '')); ?>' }">
            <div class="relative w-full aspect-[4/5] bg-[#F9F9F9] flex items-center justify-center overflow-hidden">
                <template x-if="mainImage">
                    <img :src="mainImage" alt="<?php echo e($product->nama_produk); ?>" class="w-full h-full object-cover transition-opacity duration-500 ease-out">
                </template>
                <template x-if="!mainImage">
                    <i class="bi bi-image text-gray-200 text-6xl"></i>
                </template>
            </div>
            
            <?php if($product->images && $product->images->count() > 1): ?>
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" @click="mainImage = '<?php echo e($img->url); ?>'" 
                        class="flex-shrink-0 w-24 h-32 bg-[#F9F9F9] overflow-hidden transition-all focus:outline-none"
                        :class="mainImage === '<?php echo e($img->url); ?>' ? 'ring-1 ring-black' : 'opacity-60 hover:opacity-100'">
                    <img src="<?php echo e($img->url); ?>" class="w-full h-full object-cover">
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Product Information Section -->
        <div class="flex flex-col pt-4 lg:pt-10">
            <?php if($product->category): ?>
                <div class="mb-4">
                    <span class="text-xs font-bold tracking-widest uppercase text-gray-500">
                        <?php echo e($product->category->name); ?>

                    </span>
                </div>
            <?php endif; ?>
            
            <h1 class="text-4xl md:text-5xl font-black text-black mb-4 tracking-tighter leading-tight"><?php echo e($product->nama_produk); ?></h1>
            
            <p class="mb-10">
                <span class="text-2xl font-medium text-gray-600">IDR <?php echo e(number_format($product->harga, 0, ',', '.')); ?></span>
            </p>

            <div class="mb-10 text-gray-600 leading-relaxed text-lg">
                <!-- Fallback description if actual description is not available in model -->
                <?php if(isset($product->deskripsi) && $product->deskripsi): ?>
                    <?php echo nl2br(e($product->deskripsi)); ?>

                <?php else: ?>
                    Esensi desain modern yang memberikan kenyamanan maksimal. Dibuat dengan material pilihan untuk kualitas yang tak lekang oleh waktu.
                <?php endif; ?>
            </div>

            <div class="mb-12">
                <?php if($product->stok > 10): ?>
                    <p class="text-sm font-medium text-gray-500">Tersedia (<?php echo e($product->stok); ?>)</p>
                <?php elseif($product->stok > 0): ?>
                    <p class="text-sm font-medium text-amber-600">Tersedia Terbatas (<?php echo e($product->stok); ?>)</p>
                <?php else: ?>
                    <p class="text-sm font-medium text-gray-400">Habis Terjual</p>
                <?php endif; ?>
            </div>

            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isPembeli() && $product->stok > 0): ?>
                    <form action="<?php echo e(route('pembeli.cart.store')); ?>" method="POST" class="mt-auto">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        
                        <?php if($product->sizes && $product->sizes->count() > 0): ?>
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-4">Ukuran</label>
                            <div class="flex flex-wrap gap-3">
                                <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <input type="radio" name="size" id="size_<?php echo e($size->id); ?>" value="<?php echo e($size->size); ?>" class="peer hidden" <?php echo e($size->stock <= 0 ? 'disabled' : ''); ?>>
                                        <label for="size_<?php echo e($size->id); ?>" class="flex items-center justify-center min-w-[3rem] px-4 py-3 border border-gray-200 cursor-pointer text-sm font-medium transition-all peer-checked:bg-black peer-checked:text-white peer-checked:border-black hover:border-black peer-disabled:opacity-30 peer-disabled:cursor-not-allowed">
                                            <?php echo e($size->size); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="flex flex-col sm:flex-row gap-6 items-end border-t border-gray-100 pt-8">
                            <div class="w-full sm:w-32">
                                <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-4">Kuantitas</label>
                                <input type="number" name="jumlah" class="w-full border-b border-gray-300 bg-transparent py-3 text-center text-xl text-black font-medium focus:outline-none focus:border-black transition-colors"
                                       value="1" min="1" max="<?php echo e($product->stok); ?>">
                            </div>
                            <div class="w-full sm:flex-1">
                                <button type="submit" class="w-full bg-black text-white hover:bg-gray-800 font-medium text-sm tracking-widest uppercase py-5 px-8 transition-colors">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                <?php elseif(!auth()->check()): ?>
                    <div class="mt-auto border-t border-gray-100 pt-8">
                        <a href="<?php echo e(route('login')); ?>" class="block w-full text-center border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-8 transition-colors">
                            Masuk untuk Membeli
                        </a>
                    </div>
                <?php else: ?>
                    <div class="mt-auto border-t border-gray-100 pt-8">
                        <button class="w-full bg-gray-100 text-gray-400 font-medium text-sm tracking-widest uppercase py-5 px-8 cursor-not-allowed" disabled>
                            Tidak Tersedia
                        </button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="mt-auto border-t border-gray-100 pt-8">
                    <a href="<?php echo e(route('login')); ?>" class="block w-full text-center border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-8 transition-colors">
                        Masuk untuk Membeli
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/pembeli/products/show.blade.php ENDPATH**/ ?>