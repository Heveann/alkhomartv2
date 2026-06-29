
<?php $__env->startSection('title', 'POS Terminal'); ?>
<?php $__env->startSection('topbar-title', 'Point of Sale Terminal'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    [x-cloak] { display: none !important; }
    .cart-items-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .cart-items-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 8px;
    }
    .cart-items-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 8px;
    }
    .cart-items-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:min-h-[calc(100vh-180px)]" x-data="kasir()">
    <!-- LEFT: Product Browser -->
    <div class="lg:col-span-7 h-full">
        <div class="card h-full flex flex-col" style="margin-bottom: 0;">
            <div class="card-header flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <i class="bi bi-grid-3x3-gap mr-2"></i> Product Inventory
                </div>
                <div class="relative w-full sm:w-72">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input type="text" x-model="keyword" class="form-control" style="padding-left: 2.5rem;"
                           placeholder="Filter products...">
                </div>
            </div>

            <!-- Product Selection -->
            <div class="card-body overflow-y-auto pr-2 flex-1 min-h-0" style="max-height: 620px;">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 items-start content-start">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-item" x-show="keyword === '' || '<?php echo e(addslashes(strtolower($product->nama_produk))); ?>'.includes(keyword.toLowerCase())">
                        <div class="bg-white border border-slate-200 hover:border-blue-500 hover:bg-slate-50 rounded-xl p-3 cursor-pointer transition-all duration-200 flex flex-col"
                             @click="addToCart(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->nama_produk)); ?>', <?php echo e($product->harga); ?>, <?php echo e($product->stok); ?>)">
                            <div class="w-full rounded-lg bg-slate-100 mb-3 overflow-hidden flex items-center justify-center" style="aspect-ratio: 1 / 1;">
                                <?php if($product->gambar): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->gambar)); ?>" alt="<?php echo e($product->nama_produk); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="bi bi-image text-slate-300 text-3xl"></i>
                                <?php endif; ?>
                            </div>
                            <div class="text-sm font-medium text-slate-700 mb-3 line-clamp-2 leading-snug">
                                <?php echo e($product->nama_produk); ?>

                            </div>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="font-bold text-slate-900 text-lg">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></span>
                                <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-xs" x-text="'Stok: ' + getSisaStok(<?php echo e($product->id); ?>, <?php echo e($product->stok); ?>)">Stok: <?php echo e($product->stok); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: Transaction Log -->
    <div class="lg:col-span-5 h-full">
        <form action="<?php echo e(route('admin.kasir.process')); ?>" method="POST" class="flex flex-col gap-6 h-full">
            <?php echo csrf_field(); ?>

            <!-- Active Cart -->
            <div class="card flex flex-col flex-1 min-h-0" style="border-top: 0.25rem solid var(--primary); margin-bottom: 0;">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <i class="bi bi-cart3 mr-2"></i> Active Cart
                    </div>
                    <span class="badge badge-primary" x-text="cart.length + ' ITEMS'"></span>
                </div>
                
                <div class="card-body flex flex-col flex-1 min-h-0 p-4">

                <div x-cloak x-show="cart.length === 0" class="flex-1 flex flex-col items-center justify-center py-6 text-slate-500 min-h-0">
                    <i class="bi bi-basket3 text-5xl mb-3 opacity-50"></i>
                    <p class="text-sm">Select products to begin</p>
                </div>

                <div x-cloak x-show="cart.length > 0" class="overflow-y-auto pr-2 space-y-3 cart-items-scroll" style="max-height: 228px;">
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-lg group">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-slate-700 mb-1" x-text="item.name"></div>
                                <div class="text-slate-500 text-xs" x-text="item.qty + ' × IDR ' + formatRupiah(item.price)"></div>
                                <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.id">
                                <input type="hidden" :name="'items['+index+'][jumlah]'" :value="item.qty">
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-slate-900 text-sm" x-text="'IDR ' + formatRupiah(item.price * item.qty)"></span>
                                <button type="button" class="text-slate-400 hover:text-red-500 transition" @click="removeFromCart(item.id)">
                                    <i class="bi bi-trash-fill text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                    <div class="mt-6 pt-4 shrink-0" style="border-top: 1px solid var(--border-color);">
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-bold uppercase tracking-wider" style="color: var(--gray-light);">Subtotal</span>
                            <span class="text-3xl font-bold tracking-tight" style="color: var(--dark);" x-text="'IDR ' + formatRupiah(totalHarga)">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settlement Panel -->
            <div class="card" style="margin-bottom: 0;">
                <div class="card-header">
                    <i class="bi bi-wallet2 mr-2"></i> Settlement
                </div>
                <div class="card-body">
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-2" style="color: var(--gray-light);">Cash Received (Rp)</label>
                        <input type="text" x-model="uangFormatted" @input="handleInput"
                               class="form-control form-control-lg text-3xl font-bold" style="color: var(--dark);"
                               placeholder="0">
                        <input type="hidden" name="uang_dibayar" :value="uang">
                    </div>

                    <div class="p-4 mb-6 border rounded" style="background-color: var(--light); border-color: var(--border-color);">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold uppercase tracking-wider" style="color: var(--gray-light);">Change Due</span>
                            <span class="text-3xl font-bold" x-text="'IDR ' + (uang >= totalHarga && totalHarga > 0 ? formatRupiah(kembalian) : 0)"
                                  :style="uang >= totalHarga && totalHarga > 0 ? 'color: #00ac69;' : 'color: #e81500;'">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 text-lg flex justify-center items-center gap-2" :disabled="!canSubmit">
                        Complete Transaction <i class="bi bi-arrow-right-circle"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('kasir', () => ({
            keyword: '',
            cart: [],
            uangFormatted: '',
            
            get uang() {
                return parseInt(this.uangFormatted.replace(/\D/g, '')) || 0;
            },
            
            handleInput(e) {
                let val = e.target.value.replace(/\D/g, '');
                this.uangFormatted = val ? this.formatRupiah(parseInt(val)) : '';
            },
            
            get totalHarga() {
                return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
            },
            
            get kembalian() {
                return (this.uang || 0) - this.totalHarga;
            },
            
            get canSubmit() {
                return (this.uang || 0) >= this.totalHarga && this.totalHarga > 0;
            },
            
            addToCart(id, name, price, stock) {
                const existing = this.cart.find(item => item.id === id);
                if (existing) {
                    if (existing.qty >= stock) return alert('STOCK_INSUFFICIENT');
                    existing.qty++;
                } else {
                    if (stock <= 0) return alert('OUT_OF_STOCK');
                    this.cart.push({ id, name, price, stock, qty: 1 });
                }
            },
            
            removeFromCart(id) {
                this.cart = this.cart.filter(item => item.id !== id);
            },
            
            getSisaStok(id, originalStock) {
                const item = this.cart.find(i => i.id === id);
                return item ? originalStock - item.qty : originalStock;
            },
            
            formatRupiah(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        }))
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/kasir/index.blade.php ENDPATH**/ ?>