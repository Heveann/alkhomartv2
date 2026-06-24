<?php if($order->status === 'pending'): ?>
    <div x-data="{ open: false }" class="relative inline-block text-left" @click.away="open = false" @keydown.escape.window="open = false">
        <button @click="open = !open" type="button" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 text-sm font-medium text-slate-700 bg-white/80 backdrop-blur-md border border-slate-200/80 rounded-xl shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05),0_1px_4px_-1px_rgba(0,0,0,0.02)] hover:bg-slate-50 hover:shadow-[0_4px_12px_-3px_rgba(0,0,0,0.08),0_2px_6px_-2px_rgba(0,0,0,0.04)] hover:border-slate-300 transition-all duration-200 ease-out focus:outline-none focus:ring-2 focus:ring-slate-400/20 active:scale-95 group">
            Aksi
            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform duration-200 ease-in-out" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 translate-y-2 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 translate-y-2 scale-95" 
             class="absolute right-0 z-50 w-44 mt-2 origin-top-right bg-white/95 backdrop-blur-xl border border-slate-100 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] ring-1 ring-black/5 divide-y divide-slate-100 focus:outline-none" 
             style="display: none;">
            
            <div class="p-1.5">
                <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST" class="m-0">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" onclick="return confirm('Tandai pesanan ini sebagai selesai?')" class="group flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium text-slate-600 hover:bg-emerald-50/80 hover:text-emerald-700 transition-colors duration-150">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Selesai
                    </button>
                </form>
                <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST" class="m-0 mt-0.5">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="status" value="dibatalkan">
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" class="group flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium text-slate-600 hover:bg-red-50/80 hover:text-red-700 transition-colors duration-150">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batalkan
                    </button>
                </form>
            </div>
            
            <div class="p-1.5">
                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="group flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium text-slate-600 hover:bg-blue-50/80 hover:text-blue-700 transition-colors duration-150">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
<?php else: ?>
    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 text-sm font-medium text-slate-700 bg-white/80 backdrop-blur-md border border-slate-200/80 rounded-xl shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05),0_1px_4px_-1px_rgba(0,0,0,0.02)] hover:bg-slate-50 hover:shadow-[0_4px_12px_-3px_rgba(0,0,0,0.08),0_2px_6px_-2px_rgba(0,0,0,0.04)] hover:border-slate-300 hover:text-blue-600 transition-all duration-200 ease-out focus:outline-none focus:ring-2 focus:ring-slate-400/20 active:scale-95 group">
        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        Detail
    </a>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/orders/partials/action.blade.php ENDPATH**/ ?>