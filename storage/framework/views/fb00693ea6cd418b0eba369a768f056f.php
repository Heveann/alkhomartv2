<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'AlkhoMart'); ?> — Discover Your Style</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <style>
        .font-serif-elegant { font-family: 'Playfair Display', serif; }
        .font-sans-clean { font-family: 'Inter', sans-serif; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans-clean antialiased text-gray-900 bg-white selection:bg-black selection:text-white">

    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled, 'border-b border-gray-100': scrolled }"
         class="fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="font-serif-elegant text-2xl font-bold tracking-tighter">
                        AlkhoMart.
                    </a>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex space-x-10">
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="text-sm font-medium hover:text-gray-500 transition-colors <?php echo e(request()->routeIs('pembeli.products') ? 'text-black border-b border-black pb-0.5' : 'text-gray-500 hover:border-b hover:border-gray-500 pb-0.5'); ?>">Shop</a>
                    <a href="<?php echo e(route('pembeli.collection')); ?>" class="text-sm font-medium hover:text-gray-500 transition-colors <?php echo e(request()->routeIs('pembeli.collection') ? 'text-black border-b border-black pb-0.5' : 'text-gray-500 hover:border-b hover:border-gray-500 pb-0.5'); ?>">Collection</a>
                    <a href="<?php echo e(route('pembeli.about')); ?>" class="text-sm font-medium hover:text-gray-500 transition-colors <?php echo e(request()->routeIs('pembeli.about') ? 'text-black border-b border-black pb-0.5' : 'text-gray-500 hover:border-b hover:border-gray-500 pb-0.5'); ?>">About</a>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm font-medium text-gray-500 hover:text-black transition-colors">Dashboard Admin</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Icons (Cart, User) -->
                <div class="hidden lg:flex items-center space-x-6">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isPembeli()): ?>
                            <a href="<?php echo e(route('pembeli.cart')); ?>" aria-label="Keranjang Belanja" class="relative text-black hover:text-gray-500 transition p-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded">
                                <!-- Heroicon: shopping-bag -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                                <?php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('jumlah'); ?>
                                <?php if($cartCount > 0): ?>
                                    <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[18px] h-[18px] text-[10px] font-bold text-white bg-black rounded-full">
                                        <?php echo e($cartCount); ?>

                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                        
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" aria-haspopup="true" :aria-expanded="open" class="flex items-center gap-2 text-sm font-medium text-black hover:text-gray-500 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded p-1">
                                <!-- Heroicon: user -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                                <span class="max-w-[100px] truncate hidden xl:inline"><?php echo e(explode(' ', auth()->user()->name)[0]); ?></span>
                            </button>
                            
                            <div x-show="open" x-transition x-cloak class="absolute right-0 mt-4 w-48 bg-white border border-gray-100 shadow-xl py-2">
                                <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-widest mb-1">Akun Saya</div>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition" type="submit">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if(!request()->routeIs('login') && !request()->routeIs('register')): ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-black hover:text-gray-500 transition">Masuk</a>
                            <a href="<?php echo e(route('register')); ?>" class="text-sm font-medium text-black border border-black px-4 py-2 hover:bg-black hover:text-white transition">Daftar</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isPembeli()): ?>
                            <a href="<?php echo e(route('pembeli.cart')); ?>" class="text-black relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                                <?php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('jumlah'); ?>
                                <?php if($cartCount > 0): ?>
                                    <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[18px] h-[18px] text-[10px] font-bold text-white bg-black rounded-full"><?php echo e($cartCount); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka menu navigasi" :aria-expanded="mobileMenuOpen" class="text-black focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded p-1">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" x-collapse x-cloak class="lg:hidden bg-white border-b border-gray-100 shadow-sm absolute top-full left-0 w-full">
            <div class="px-4 py-6 space-y-4">
                <a href="<?php echo e(route('pembeli.products')); ?>" class="block px-3 py-2 text-lg font-medium <?php echo e(request()->routeIs('pembeli.products') ? 'text-black' : 'text-gray-500'); ?>">Shop</a>
                <a href="<?php echo e(route('pembeli.collection')); ?>" class="block px-3 py-2 text-lg font-medium <?php echo e(request()->routeIs('pembeli.collection') ? 'text-black' : 'text-gray-500'); ?>">Collection</a>
                <a href="<?php echo e(route('pembeli.about')); ?>" class="block px-3 py-2 text-lg font-medium <?php echo e(request()->routeIs('pembeli.about') ? 'text-black' : 'text-gray-500'); ?>">About</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 text-lg font-medium text-gray-500">Dashboard Admin</a>
                    <?php endif; ?>
                    <div class="border-t border-gray-100 pt-6 mt-4">
                        <div class="px-3 text-sm font-medium text-gray-400 mb-2">Akun: <?php echo e(auth()->user()->name); ?></div>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="block w-full text-left px-3 py-2 text-lg font-medium text-gray-500 hover:text-black" type="submit">
                                Keluar
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <?php if(!request()->routeIs('login') && !request()->routeIs('register')): ?>
                        <div class="flex flex-col gap-4 mt-6 px-3">
                            <a href="<?php echo e(route('login')); ?>" class="w-full text-center py-3 border border-black font-medium text-black">Masuk</a>
                            <a href="<?php echo e(route('register')); ?>" class="w-full text-center py-3 bg-black text-white font-medium">Daftar</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="min-h-[calc(100vh-350px)] pt-20">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- 9. Footer Modern -->
    <footer class="bg-white pt-24 pb-12 border-t border-gray-100 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">
                <!-- Brand -->
                <div>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="font-serif-elegant text-3xl font-bold tracking-tighter mb-6 block text-black">
                        AlkhoMart.
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8">
                        Menyediakan koleksi fashion minimalis dan elegan untuk melengkapi gaya hidup modern Anda.
                    </p>
                    <div class="flex space-x-5">
                        <a href="#" class="text-gray-400 hover:text-black transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-black transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-black mb-6 uppercase tracking-widest text-xs">Shop</h4>
                    <ul class="space-y-4">
                        <li><a href="<?php echo e(route('pembeli.products')); ?>" class="text-gray-500 hover:text-black text-sm transition-colors">All Products</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Women's Collection</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Men's Collection</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">New Arrivals</a></li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h4 class="font-bold text-black mb-6 uppercase tracking-widest text-xs">Information</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-black mb-6 uppercase tracking-widest text-xs">Customer Service</h4>
                    <ul class="space-y-4">
                        <li class="text-gray-500 text-sm flex items-start">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                            support@alkhomart.com
                        </li>
                        <li class="text-gray-500 text-sm flex items-start">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0l6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z"></path></svg>
                            +62 812 3456 7890
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">&copy; 2026 AlkhoMart. All rights reserved.</p>
                <!-- Payment methods placeholder -->
                <div class="flex gap-4">
                    <svg class="w-8 h-8 text-gray-200" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="currentColor"/></svg>
                    <svg class="w-8 h-8 text-gray-200" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="currentColor"/></svg>
                    <svg class="w-8 h-8 text-gray-200" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="currentColor"/></svg>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery & SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-toast { padding: 12px 16px !important; }
        .swal2-toast .swal2-icon { margin: 0 12px 0 0 !important; width: 28px !important; height: 28px !important; }
    </style>
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                color: '#fff',
                iconColor: '#fff',
                customClass: {
                    popup: 'font-sans shadow-lg rounded-lg border-0',
                    title: 'font-medium text-sm m-0',
                    timerProgressBar: 'bg-white/30'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            <?php if(session('success')): ?>
                Toast.fire({ icon: 'success', title: '<?php echo e(session('success')); ?>', background: '#10b981' });
            <?php endif; ?>

            <?php if(session('error')): ?>
                Toast.fire({ icon: 'error', title: '<?php echo e(session('error')); ?>', background: '#ef4444' });
            <?php endif; ?>
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/layouts/app.blade.php ENDPATH**/ ?>