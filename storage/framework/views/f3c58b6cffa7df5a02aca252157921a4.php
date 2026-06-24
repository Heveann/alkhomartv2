<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Discover Your Style | AlkhoMart.</title>

    <!-- Fonts: Use elegant sans-serif and serif for fashion vibe -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|playfair-display:400,600,700,900" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .font-serif-elegant { font-family: 'Playfair Display', serif; }
        .font-sans-clean { font-family: 'Inter', sans-serif; }
        /* Hide scrollbar for Alpine sliders */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans-clean antialiased text-gray-900 bg-white selection:bg-black selection:text-white">

    <!-- 1. Navbar -->
    <!-- Sticky navbar with backdrop blur -->
    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled }"
         class="fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo e(route('landing')); ?>" class="font-serif-elegant text-2xl font-bold tracking-tighter">
                        AlkhoMart.
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-10">
                    <a href="<?php echo e(route('landing')); ?>" class="text-sm font-medium hover:text-gray-500 transition-colors">Home</a>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="text-sm font-medium hover:text-gray-500 transition-colors">Shop</a>
                    <a href="#" class="text-sm font-medium hover:text-gray-500 transition-colors">Collection</a>
                    <a href="#" class="text-sm font-medium hover:text-gray-500 transition-colors">About</a>
                    <a href="#" class="text-sm font-medium hover:text-gray-500 transition-colors">Contact</a>
                </div>

                <!-- Icons (Search, Cart, User) -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(route('pembeli.products.search')); ?>" class="text-black hover:text-gray-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    </a>
                    <a href="<?php echo e(route('pembeli.cart')); ?>" class="text-black hover:text-gray-500 transition relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-black hover:text-gray-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-black hover:text-gray-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-4">
                    <a href="<?php echo e(route('pembeli.cart')); ?>" class="text-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-black focus:outline-none">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" x-collapse x-cloak class="md:hidden bg-white border-t border-gray-100">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="<?php echo e(route('landing')); ?>" class="block px-3 py-3 text-base font-medium text-black">Home</a>
                <a href="<?php echo e(route('pembeli.products')); ?>" class="block px-3 py-3 text-base font-medium text-gray-500 hover:text-black">Shop</a>
                <a href="#" class="block px-3 py-3 text-base font-medium text-gray-500 hover:text-black">Collection</a>
                <a href="#" class="block px-3 py-3 text-base font-medium text-gray-500 hover:text-black">About</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-3 text-base font-medium text-gray-500 hover:text-black">My Account</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="block px-3 py-3 text-base font-medium text-gray-500 hover:text-black">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 2. Hero Section -->
    <!-- Full width banner with large typography -->
    <div class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Fashion Model" class="w-full h-full object-cover object-center" />
            <!-- Soft gradient overlay to ensure text is readable -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="max-w-2xl">
                <span class="block text-sm font-bold tracking-[0.2em] uppercase mb-4 opacity-90">Spring / Summer 2026</span>
                <h1 class="font-serif-elegant text-6xl md:text-8xl font-black leading-tight mb-6">
                    Discover<br/>Your Style.
                </h1>
                <p class="text-lg md:text-xl font-light mb-10 opacity-90 max-w-md">
                    Explore our curated collection of premium essentials designed for the modern individual. Elevate your everyday wardrobe.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="inline-flex justify-center items-center px-8 py-4 bg-white text-black font-medium text-sm tracking-widest uppercase hover:bg-gray-100 transition-colors">
                        Shop Now
                    </a>
                    <a href="#featured" class="inline-flex justify-center items-center px-8 py-4 bg-transparent border border-white text-white font-medium text-sm tracking-widest uppercase hover:bg-white hover:text-black transition-colors">
                        View Collection
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Featured Categories -->
    <section class="py-20 md:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <h2 class="font-serif-elegant text-3xl md:text-4xl font-bold text-black">Shop by Category</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Category 1 -->
                <a href="<?php echo e(route('pembeli.products')); ?>" class="group relative h-96 overflow-hidden rounded-xl shadow-sm">
                    <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Men" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-white/90 backdrop-blur-sm px-8 py-3 text-sm font-bold uppercase tracking-widest text-black">Men</span>
                    </div>
                </a>
                
                <!-- Category 2 -->
                <a href="<?php echo e(route('pembeli.products')); ?>" class="group relative h-96 overflow-hidden rounded-xl shadow-sm lg:-mt-8">
                    <img src="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Women" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-white/90 backdrop-blur-sm px-8 py-3 text-sm font-bold uppercase tracking-widest text-black">Women</span>
                    </div>
                </a>

                <!-- Category 3 -->
                <a href="<?php echo e(route('pembeli.products')); ?>" class="group relative h-96 overflow-hidden rounded-xl shadow-sm lg:mt-8">
                    <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Accessories" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-white/90 backdrop-blur-sm px-8 py-3 text-sm font-bold uppercase tracking-widest text-black">Accessories</span>
                    </div>
                </a>

                <!-- Category 4 -->
                <a href="<?php echo e(route('pembeli.products')); ?>" class="group relative h-96 overflow-hidden rounded-xl shadow-sm">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&auto=format&fit=crop&w=720&q=80" alt="New Arrival" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-white/90 backdrop-blur-sm px-8 py-3 text-sm font-bold uppercase tracking-widest text-black">New Arrival</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- 4. Featured Products -->
    <section id="featured" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif-elegant text-3xl md:text-4xl font-bold text-black mb-4">Trending Now</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Handpicked selections from our newest collection.</p>
            </div>

            <!-- Grid 4 Kolom -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Product Card 1 -->
                <div class="group flex flex-col">
                    <div class="relative w-full aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-sm mb-4">
                        <img src="https://images.unsplash.com/photo-1550614000-4b95d466f914?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Minimalist Coat" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-full">New</span>
                        </div>
                        <!-- Quick View Button -->
                        <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                            <a href="<?php echo e(route('pembeli.products')); ?>" class="block w-full text-center bg-white/90 backdrop-blur text-black font-medium text-sm py-3 rounded-xl shadow-lg hover:bg-black hover:text-white transition-colors">
                                Quick View
                            </a>
                        </div>
                    </div>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="text-lg font-medium text-black hover:text-gray-600 transition">Essential Minimalist Coat</a>
                    <div class="text-gray-500 mt-1">IDR 1.299.000</div>
                </div>

                <!-- Product Card 2 -->
                <div class="group flex flex-col">
                    <div class="relative w-full aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-sm mb-4">
                        <img src="https://images.unsplash.com/photo-1434389678232-06901625f3cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Linen Blend Shirt" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <!-- Quick View Button -->
                        <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                            <a href="<?php echo e(route('pembeli.products')); ?>" class="block w-full text-center bg-white/90 backdrop-blur text-black font-medium text-sm py-3 rounded-xl shadow-lg hover:bg-black hover:text-white transition-colors">
                                Quick View
                            </a>
                        </div>
                    </div>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="text-lg font-medium text-black hover:text-gray-600 transition">Linen Blend Shirt</a>
                    <div class="text-gray-500 mt-1">IDR 459.000</div>
                </div>

                <!-- Product Card 3 -->
                <div class="group flex flex-col">
                    <div class="relative w-full aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-sm mb-4">
                        <img src="https://images.unsplash.com/photo-1591369822096-111151140e29?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Pleated Trousers" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-full">Sale -20%</span>
                        </div>
                        <!-- Quick View Button -->
                        <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                            <a href="<?php echo e(route('pembeli.products')); ?>" class="block w-full text-center bg-white/90 backdrop-blur text-black font-medium text-sm py-3 rounded-xl shadow-lg hover:bg-black hover:text-white transition-colors">
                                Quick View
                            </a>
                        </div>
                    </div>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="text-lg font-medium text-black hover:text-gray-600 transition">Pleated Trousers</a>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-red-600 font-medium">IDR 399.000</span>
                        <span class="text-gray-400 line-through text-sm">IDR 499.000</span>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div class="group flex flex-col">
                    <div class="relative w-full aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-sm mb-4">
                        <img src="https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Leather Tote Bag" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <!-- Quick View Button -->
                        <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                            <a href="<?php echo e(route('pembeli.products')); ?>" class="block w-full text-center bg-white/90 backdrop-blur text-black font-medium text-sm py-3 rounded-xl shadow-lg hover:bg-black hover:text-white transition-colors">
                                Quick View
                            </a>
                        </div>
                    </div>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="text-lg font-medium text-black hover:text-gray-600 transition">Classic Leather Tote</a>
                    <div class="text-gray-500 mt-1">IDR 899.000</div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="<?php echo e(route('pembeli.products')); ?>" class="inline-flex items-center text-sm font-bold uppercase tracking-widest text-black hover:text-gray-500 border-b-2 border-black hover:border-gray-500 transition-all pb-1">
                    View All Products
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- 5. Collection Banner -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-2xl overflow-hidden shadow-lg h-[400px] flex items-center">
                <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" alt="Winter Collection" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/30"></div>
                
                <div class="relative z-10 p-8 md:p-16 max-w-xl">
                    <span class="block text-white text-sm font-bold tracking-widest uppercase mb-2">Limited Edition</span>
                    <h2 class="font-serif-elegant text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">The Winter Essentials.</h2>
                    <p class="text-white/90 mb-8 text-lg">Stay warm without compromising your style. Discover outerwear crafted for the season.</p>
                    <a href="<?php echo e(route('pembeli.products')); ?>" class="inline-block bg-white text-black font-medium text-sm tracking-widest uppercase py-4 px-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all">
                        Explore Collection
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Best Seller Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-serif-elegant text-3xl md:text-4xl font-bold text-black mb-12 text-center">Best Sellers</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Best Seller 1 -->
                <div class="flex gap-4 items-center p-4 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow bg-white">
                    <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Basic Tee" class="w-24 h-24 object-cover rounded-xl shrink-0">
                    <div>
                        <div class="flex text-yellow-400 text-sm mb-1">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <h4 class="font-bold text-black mb-1">Premium Basic Tee</h4>
                        <div class="text-sm font-medium text-gray-500">IDR 199.000</div>
                    </div>
                </div>

                <!-- Best Seller 2 -->
                <div class="flex gap-4 items-center p-4 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow bg-white">
                    <img src="https://images.unsplash.com/photo-1582552938357-32b906df40cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=735&q=80" alt="Denim Jacket" class="w-24 h-24 object-cover rounded-xl shrink-0">
                    <div>
                        <div class="flex text-yellow-400 text-sm mb-1">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <h4 class="font-bold text-black mb-1">Vintage Denim Jacket</h4>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-red-600">IDR 599.000</span>
                            <span class="text-xs text-gray-400 line-through">IDR 799.000</span>
                        </div>
                    </div>
                </div>

                <!-- Best Seller 3 -->
                <div class="flex gap-4 items-center p-4 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow bg-white">
                    <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80" alt="Sneakers" class="w-24 h-24 object-cover rounded-xl shrink-0">
                    <div>
                        <div class="flex text-yellow-400 text-sm mb-1">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <h4 class="font-bold text-black mb-1">Canvas Low-Top</h4>
                        <div class="text-sm font-medium text-gray-500">IDR 899.000</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Testimonials (Alpine.js Slider) -->
    <section class="py-24 bg-gray-50" x-data="{ activeSlide: 0, slides: [
        { name: 'Sarah M.', role: 'Fashion Blogger', text: 'Kualitas pakaian dari AlkhoMart luar biasa. Desain minimalisnya sangat cocok untuk gaya hidup modern saya sehari-hari. Pelayanan pelanggan juga sangat responsif!' },
        { name: 'David W.', role: 'Art Director', text: 'Saya selalu mencari pakaian yang simple namun memiliki detail potongan yang sempurna. AlkhoMart memberikan exactly what I need. Sangat direkomendasikan.' },
        { name: 'Amanda R.', role: 'Creative', text: 'Belanja di sini selalu menjadi pengalaman yang menyenangkan. Navigasi websitenya bersih, dan pesanan selalu tiba dalam packaging yang premium.' }
    ] }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <svg class="w-10 h-10 mx-auto text-gray-300 mb-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path></svg>
            
            <div class="relative min-h-[150px]">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="absolute inset-0">
                        <p class="font-serif-elegant text-xl md:text-3xl text-black italic mb-8 leading-relaxed" x-text="`&quot;${slide.text}&quot;`"></p>
                        <div class="font-bold text-black" x-text="slide.name"></div>
                        <div class="text-sm text-gray-500" x-text="slide.role"></div>
                    </div>
                </template>
            </div>

            <!-- Slider Dots -->
            <div class="flex justify-center gap-2 mt-12">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index" 
                            class="w-2 h-2 rounded-full transition-all duration-300"
                            :class="activeSlide === index ? 'bg-black w-6' : 'bg-gray-300 hover:bg-gray-400'">
                    </button>
                </template>
            </div>
        </div>
    </section>

    <!-- 8. Newsletter -->
    <section class="py-24 bg-white border-b border-gray-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif-elegant text-3xl font-bold text-black mb-4">Join Our Newsletter</h2>
            <p class="text-gray-500 mb-8">Subscribe to receive updates, access to exclusive deals, and more.</p>
            
            <form class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                <input type="email" placeholder="Enter your email address" required
                       class="flex-1 px-6 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition-all">
                <button type="submit" class="px-8 py-4 bg-black text-white font-bold text-sm tracking-widest uppercase rounded-xl hover:bg-gray-800 transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- 9. Footer -->
    <footer class="bg-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">
                <!-- Brand -->
                <div>
                    <a href="<?php echo e(route('landing')); ?>" class="font-serif-elegant text-2xl font-bold tracking-tighter mb-6 block">
                        AlkhoMart.
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Menyediakan koleksi fashion minimalis dan elegan untuk melengkapi gaya hidup modern Anda.
                    </p>
                    <div class="flex space-x-4">
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
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Women's Collection</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Men's Collection</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Accessories</a></li>
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
                <div class="flex gap-4">
                    <svg class="w-8 h-8 text-gray-300" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="currentColor"/></svg>
                    <svg class="w-8 h-8 text-gray-300" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="currentColor"/></svg>
                    <svg class="w-8 h-8 text-gray-300" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="currentColor"/></svg>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/pembeli/landing.blade.php ENDPATH**/ ?>