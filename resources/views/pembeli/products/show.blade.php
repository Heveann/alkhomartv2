@extends('layouts.app')
@section('title', $product->nama_produk)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="mb-12">
        <a href="{{ route('pembeli.products') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-black transition-colors border-b border-transparent hover:border-black pb-0.5">
            <i class="bi bi-arrow-left mr-3"></i> Kembali ke Koleksi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
        <!-- Product Image Section -->
        <div class="w-full flex flex-col gap-6" x-data="{ mainImage: '{{ $product->images->count() > 0 ? $product->images->first()->url : ($product->gambar ? asset('storage/' . $product->gambar) : '') }}' }">
            <div class="relative w-full aspect-[4/5] bg-[#F9F9F9] flex items-center justify-center overflow-hidden">
                <template x-if="mainImage">
                    <img :src="mainImage" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover transition-opacity duration-500 ease-out">
                </template>
                <template x-if="!mainImage">
                    <i class="bi bi-image text-gray-200 text-6xl"></i>
                </template>
            </div>
            
            @if($product->images && $product->images->count() > 1)
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                @foreach($product->images as $img)
                <button type="button" @click="mainImage = '{{ $img->url }}'" 
                        class="flex-shrink-0 w-24 h-32 bg-[#F9F9F9] overflow-hidden transition-all focus:outline-none"
                        :class="mainImage === '{{ $img->url }}' ? 'ring-1 ring-black' : 'opacity-60 hover:opacity-100'">
                    <img src="{{ $img->url }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Information Section -->
        <div class="flex flex-col pt-4 lg:pt-10">
            @if($product->category)
                <div class="mb-4">
                    <span class="text-xs font-bold tracking-widest uppercase text-gray-500">
                        {{ $product->category->name }}
                    </span>
                </div>
            @endif
            
            <h1 class="text-4xl md:text-5xl font-black text-black mb-4 tracking-tighter leading-tight">{{ $product->nama_produk }}</h1>
            
            <p class="mb-10">
                <span class="text-2xl font-medium text-gray-600">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
            </p>

            <div class="mb-10 text-gray-600 leading-relaxed text-lg">
                <!-- Fallback description if actual description is not available in model -->
                @if(isset($product->deskripsi) && $product->deskripsi)
                    {!! nl2br(e($product->deskripsi)) !!}
                @else
                    Esensi desain modern yang memberikan kenyamanan maksimal. Dibuat dengan material pilihan untuk kualitas yang tak lekang oleh waktu.
                @endif
            </div>

            <div class="mb-12">
                @if($product->stok > 10)
                    <p class="text-sm font-medium text-gray-500">Tersedia ({{ $product->stok }})</p>
                @elseif($product->stok > 0)
                    <p class="text-sm font-medium text-amber-600">Tersedia Terbatas ({{ $product->stok }})</p>
                @else
                    <p class="text-sm font-medium text-gray-400">Habis Terjual</p>
                @endif
            </div>

            @auth
                @if(auth()->user()->isPembeli() && $product->stok > 0)
                    <form action="{{ route('pembeli.cart.store') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        @if($product->sizes && $product->sizes->count() > 0)
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-4">Ukuran</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->sizes as $size)
                                    <div>
                                        <input type="radio" name="size" id="size_{{ $size->id }}" value="{{ $size->size }}" class="peer hidden" {{ $size->stock <= 0 ? 'disabled' : '' }}>
                                        <label for="size_{{ $size->id }}" class="flex flex-col items-center justify-center min-w-[4.5rem] px-3 py-2 border border-gray-200 cursor-pointer transition-all peer-checked:bg-black peer-checked:text-white peer-checked:border-black hover:border-black peer-disabled:opacity-30 peer-disabled:cursor-not-allowed">
                                            <span class="text-sm font-bold">{{ $size->size }}</span>
                                            <span class="text-[10px] font-normal opacity-70 mt-0.5">Sisa: {{ $size->stock }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="flex flex-col sm:flex-row gap-6 items-end border-t border-gray-100 pt-8">
                            <div class="w-full sm:w-32">
                                <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest mb-4">Kuantitas</label>
                                <input type="number" name="jumlah" class="w-full border-b border-gray-300 bg-transparent py-3 text-center text-xl text-black font-medium focus:outline-none focus:border-black transition-colors"
                                       value="1" min="1" max="{{ $product->stok }}">
                            </div>
                            <div class="w-full sm:flex-1">
                                <button type="submit" class="w-full bg-black text-white hover:bg-gray-800 font-medium text-sm tracking-widest uppercase py-5 px-8 transition-colors">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                @elseif(!auth()->check())
                    <div class="mt-auto border-t border-gray-100 pt-8">
                        <a href="{{ route('login') }}" class="block w-full text-center border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-8 transition-colors">
                            Masuk untuk Membeli
                        </a>
                    </div>
                @else
                    <div class="mt-auto border-t border-gray-100 pt-8">
                        <button class="w-full bg-gray-100 text-gray-400 font-medium text-sm tracking-widest uppercase py-5 px-8 cursor-not-allowed" disabled>
                            Tidak Tersedia
                        </button>
                    </div>
                @endif
            @else
                <div class="mt-auto border-t border-gray-100 pt-8">
                    <a href="{{ route('login') }}" class="block w-full text-center border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-8 transition-colors">
                        Masuk untuk Membeli
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>

@push('styles')
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
@endpush
@endsection
