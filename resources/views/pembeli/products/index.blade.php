@extends('layouts.app')
@section('title', 'Discover Your Style')

@section('content')
<div x-data="catalog()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Hero / Header Section -->
    <div class="py-16 md:py-24 max-w-4xl">
        <h1 class="font-serif-elegant text-5xl md:text-7xl font-black text-black mb-6 tracking-tighter leading-tight">Discover<br/>Your Style.</h1>
        <p class="font-sans-clean text-gray-500 font-medium text-lg md:text-xl mb-12 max-w-2xl leading-relaxed">Koleksi terkurasi dari produk-produk terbaik untuk menyempurnakan hari Anda. Elevate your everyday wardrobe.</p>
        
        <form action="{{ route('pembeli.products') }}" method="GET" class="relative max-w-2xl group" @submit.prevent="fetchProducts(keyword)">
            <label for="search" class="sr-only">Cari koleksi, pakaian, atau aksesoris</label>
            <input
                id="search"
                type="text"
                name="search"
                x-model.debounce.400ms="keyword"
                class="w-full pb-4 border-b-2 border-gray-200 bg-transparent focus:border-black transition-colors duration-300 outline-none text-xl md:text-2xl font-medium text-black placeholder-gray-300"
                placeholder="Cari koleksi, pakaian, atau aksesoris..."
                autocomplete="off"
            >
            <span x-cloak x-show="isLoading" class="absolute right-0 top-1/2 -translate-y-1/2 -mt-2">
                <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </span>
            <button aria-label="Cari" class="absolute right-0 top-1/2 -translate-y-1/2 pb-4 text-gray-400 group-hover:text-black transition focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded" type="submit">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>
    </div>

    <div x-cloak x-show="keyword !== ''" class="flex items-center gap-3 mb-12">
        <span class="text-sm text-gray-400">Hasil pencarian untuk</span>
        <span class="text-sm font-bold text-black" x-text="`&quot;${keyword}&quot;`"></span>
        <button @click="resetSearch()" class="text-sm text-gray-400 hover:text-black ml-4 transition border-b border-transparent hover:border-black pb-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded">Hapus pencarian</button>
    </div>

    <!-- Product Grid -->
    <div class="pb-24">
        <!-- Server Rendered State -->
        <div x-show="!isSearchActive">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                    @foreach($products as $product)
                        <div class="group flex flex-col h-full">
                            <div class="relative w-full aspect-square bg-gray-50 rounded-xl overflow-hidden mb-4 shrink-0">
                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}"
                                         alt="{{ $product->nama_produk }}"
                                         class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-gray-200">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                @if($product->stok <= 0)
                                    <div class="absolute inset-0 bg-white/40 backdrop-blur-sm flex items-center justify-center z-10">
                                        <span class="px-4 py-2 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg">Habis</span>
                                    </div>
                                @endif

                                <!-- Quick View / Detail Button on Hover -->
                                <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 z-20">
                                    <a href="{{ route('pembeli.products.show', $product) }}" class="block w-full text-center bg-white/95 backdrop-blur text-black font-medium text-sm py-3 rounded-xl shadow-lg hover:bg-black hover:text-white transition-colors">
                                        Quick View
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('pembeli.products.show', $product) }}" class="text-lg font-medium text-black hover:text-gray-600 transition line-clamp-2">
                                {{ $product->nama_produk }}
                            </a>
                            <div class="text-gray-500 mt-auto pt-2">
                                IDR {{ number_format($product->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-20 flex justify-center">
                    {{ $products->withQueryString()->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center py-32 border-t border-gray-100">
                    <p class="text-gray-400 mb-8 font-medium text-lg">Belum ada produk dalam koleksi ini.</p>
                </div>
            @endif
        </div>

        <!-- Alpine Rendered State (Live Search) -->
        <div x-cloak x-show="isSearchActive">
            <!-- Loading Skeletons -->
            <div x-show="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 animate-pulse">
                <template x-for="i in 6" :key="i">
                    <div>
                        <div class="w-full aspect-square rounded-xl bg-gray-100 mb-4"></div>
                        <div class="h-5 bg-gray-100 w-3/4 mb-2 rounded"></div>
                        <div class="h-4 bg-gray-100 w-1/3 rounded"></div>
                    </div>
                </template>
            </div>

            <!-- Products -->
            <div x-show="!isLoading && products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                <template x-for="p in products" :key="p.id">
                    <div class="group flex flex-col h-full">
                        <div class="relative w-full aspect-square bg-gray-50 rounded-xl overflow-hidden mb-4 shrink-0">
                            <template x-if="p.gambar">
                                <img :src="p.gambar" :alt="p.nama_produk" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                            </template>
                            <template x-if="!p.gambar">
                                <div class="flex items-center justify-center w-full h-full text-gray-200">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </template>
                            
                            <template x-if="p.stok <= 0">
                                <div class="absolute inset-0 bg-white/40 backdrop-blur-sm flex items-center justify-center z-10">
                                    <span class="px-4 py-2 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg">Habis</span>
                                </div>
                            </template>
                            

                            <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0 z-20">
                                <a :href="p.url" class="block w-full text-center bg-white/95 backdrop-blur text-black font-medium text-sm py-3 rounded-xl shadow-lg hover:bg-black hover:text-white transition-colors">
                                    Quick View
                                </a>
                            </div>
                        </div>
                        <a :href="p.url" class="text-lg font-medium text-black hover:text-gray-600 transition line-clamp-2" x-text="p.nama_produk"></a>
                        <div class="text-gray-500 mt-auto pt-2" x-text="p.harga_fmt"></div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="!isLoading && products.length === 0" class="text-center py-32 border-t border-gray-100 mt-12">
                <p class="text-gray-400 mb-8 font-medium text-lg">Tidak ada produk yang cocok dengan "<strong class="text-black" x-text="keyword"></strong>".</p>
                <button @click="resetSearch()" class="text-black font-medium border-b border-black pb-1 hover:text-gray-500 hover:border-gray-500 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded">
                    Kembali ke semua produk
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('catalog', () => ({
            keyword: '{{ request('search') }}',
            isLoading: false,
            isSearchActive: false,
            products: [],
            
            init() {
                this.$watch('keyword', (value) => {
                    if (value !== '{{ request('search') }}' || this.isSearchActive) {
                        this.fetchProducts(value);
                    }
                });
            },
            
            async fetchProducts(keyword) {
                this.isSearchActive = true;
                this.isLoading = true;
                
                const query = keyword.trim();
                
                // Update URL
                const newUrl = query
                    ? `{{ route('pembeli.products') }}?search=${encodeURIComponent(query)}`
                    : '{{ route('pembeli.products') }}';
                history.replaceState(null, '', newUrl);
                
                try {
                    const url = `{{ route('pembeli.products.search') }}?q=${encodeURIComponent(query)}`;
                    const response = await fetch(url, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    
                    if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                    
                    const data = await response.json();
                    this.products = data.products || [];
                } catch (err) {
                    console.error('[Search] Fetch error:', err);
                    this.products = [];
                } finally {
                    this.isLoading = false;
                }
            },
            
            resetSearch() {
                this.keyword = '';
            }
        }))
    });
</script>
@endpush
@endsection

