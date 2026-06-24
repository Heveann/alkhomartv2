@extends('layouts.app')
@section('title', 'About Us')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
    <div class="text-center mb-16">
        <h1 class="font-serif-elegant text-4xl md:text-6xl font-black text-black mb-6">Our Story.</h1>
        <p class="font-sans-clean text-gray-500 text-lg">Redefining modern retail with simplicity and elegance.</p>
    </div>

    <div class="w-full aspect-[21/9] bg-gray-100 rounded-2xl overflow-hidden mb-16">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Storefront" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
    </div>

    <div class="max-w-3xl mx-auto font-sans-clean text-gray-600 leading-relaxed text-lg">
        <p class="mb-6">
            Berdiri sejak tahun 2024, AlkhoMart lahir dari sebuah ide sederhana: menyediakan pakaian berkualitas tinggi dengan desain yang tak lekang oleh waktu (timeless). Kami percaya bahwa gaya hidup modern membutuhkan kesederhanaan, di mana setiap potongan pakaian dapat dengan mudah dipadupadankan.
        </p>
        <p class="mb-6">
            Kami berkomitmen untuk menggunakan material terbaik dan proses produksi yang etis. Setiap koleksi yang kami luncurkan dirancang dengan cermat untuk memberikan kenyamanan maksimal bagi para penggunanya.
        </p>
        <div class="border-l-4 border-black pl-6 py-2 my-10">
            <p class="font-serif-elegant text-2xl md:text-3xl text-black italic m-0">"Kesederhanaan adalah bentuk kemewahan yang paling tinggi."</p>
        </div>
        <p>
            Kunjungi toko online kami dan temukan berbagai macam produk yang akan menyempurnakan hari Anda. Terima kasih telah menjadi bagian dari perjalanan AlkhoMart.
        </p>
    </div>
</div>
@endsection
