@extends('layouts.app')
@section('title', 'New Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
    <h1 class="font-serif-elegant text-4xl md:text-6xl font-black text-black mb-6">The Winter Collection</h1>
    <p class="font-sans-clean text-gray-500 max-w-2xl mx-auto mb-16 text-lg">Curated pieces designed to keep you warm without compromising your minimal aesthetic.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="relative w-full aspect-[4/5] bg-gray-50 rounded-2xl overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" alt="Collection 1" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-white font-serif-elegant text-3xl font-bold tracking-widest">Outerwear</span>
            </div>
        </div>
        <div class="relative w-full aspect-[4/5] bg-gray-50 rounded-2xl overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1434389678232-06901625f3cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Collection 2" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-white font-serif-elegant text-3xl font-bold tracking-widest">Essentials</span>
            </div>
        </div>
    </div>

    <div class="mt-16">
        <a href="{{ route('pembeli.products') }}" class="inline-flex justify-center items-center px-10 py-4 bg-black text-white font-medium text-sm tracking-widest uppercase rounded-xl hover:bg-gray-800 transition-colors shadow-lg shadow-black/20">
            Shop The Collection
        </a>
    </div>
</div>
@endsection
