@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="mb-12 border-b border-black pb-4 flex items-end justify-between">
        <h1 class="text-4xl font-black text-black tracking-tighter">Keranjang Anda.</h1>
        <p class="text-gray-500 font-medium hidden sm:block">{{ $carts->count() > 0 ? $carts->sum('jumlah') . ' Items' : 'Kosong' }}</p>
    </div>

    @if($carts->count() > 0)
        <form action="{{ route('pembeli.checkout') }}" method="GET" class="flex flex-col lg:flex-row gap-8 lg:gap-16"
              x-data="cartManager({{ $carts->toJson() }})">
            <!-- Main Cart Items -->
            <div class="w-full lg:w-2/3">
                <!-- Pilih Semua -->
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200">
                    <input type="checkbox" id="selectAll" x-model="selectAll"
                           class="w-5 h-5 text-black bg-gray-100 border-gray-300 rounded focus:ring-black focus:ring-2 cursor-pointer">
                    <label for="selectAll" class="text-sm font-medium text-black cursor-pointer uppercase tracking-widest">Pilih Semua</label>
                </div>
                
                <div class="flex flex-col gap-8">
                    @foreach($carts as $cart)
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-8 border-b border-gray-100 relative group">
                            <div class="flex items-center gap-4 w-full sm:w-auto mb-4 sm:mb-0">
                                <!-- Checkbox -->
                                <input type="checkbox" name="items[]" value="{{ $cart->id }}" x-model="selectedItems"
                                       class="w-5 h-5 text-black bg-gray-100 border-gray-300 rounded focus:ring-black focus:ring-2 cursor-pointer">
                                
                                @if($cart->product->gambar)
                                    <div class="w-24 h-32 bg-[#F9F9F9] overflow-hidden shrink-0 ml-2">
                                        <img src="{{ asset('storage/' . $cart->product->gambar) }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-24 h-32 bg-gray-50 flex items-center justify-center shrink-0 ml-2">
                                        <i class="bi bi-image text-gray-300 text-3xl"></i>
                                    </div>
                                @endif
                                <div class="flex flex-col ml-2">
                                    <a href="{{ route('pembeli.products.show', $cart->product) }}" class="text-lg font-medium text-black hover:text-gray-500 transition mb-1">{{ $cart->product->nama_produk }}</a>
                                    <div class="text-sm text-gray-500 mb-3">Rp {{ number_format($cart->product->harga, 0, ',', '.') }}</div>
                                    <button form="form-delete-{{ $cart->id }}" type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition border-b border-transparent hover:border-red-500 pb-0.5 inline-block text-left w-max"
                                            onclick="return confirm('Hapus item ini dari keranjang?')">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-8">
                                <div class="flex items-center border-b border-gray-300 py-1">
                                    <span class="text-xs font-bold uppercase text-gray-400 mr-3">Qty</span>
                                    <input type="number" form="form-update-{{ $cart->id }}" name="jumlah" value="{{ $cart->jumlah }}"
                                           min="1" max="{{ $cart->product->stok }}"
                                           class="w-12 text-center text-lg text-black font-medium bg-transparent focus:outline-none"
                                           onchange="document.getElementById('form-update-{{ $cart->id }}').submit()">
                                </div>
                                
                                <div class="text-lg font-medium text-black">
                                    Rp {{ number_format($cart->product->harga * $cart->jumlah, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-[#F9F9F9] p-8 lg:p-10 sticky top-24">
                    <h3 class="text-xl font-black text-black mb-8 tracking-tighter">Ringkasan</h3>
                    
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500">Subtotal (<span x-text="totalItems"></span> item)</span>
                        <span class="font-medium text-black" x-text="formatRupiah(total)">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center mb-8 pb-8 border-b border-gray-200">
                        <span class="text-gray-500">Pengiriman</span>
                        <span class="text-gray-400 text-sm">Dihitung saat checkout</span>
                    </div>
                    
                    <div class="flex justify-between items-end mb-10">
                        <span class="text-black font-bold uppercase tracking-widest text-sm">Total</span>
                        <span class="text-3xl font-medium text-black" x-text="formatRupiah(total)">
                            Rp 0
                        </span>
                    </div>
                    
                    <button type="submit" :disabled="selectedItems.length === 0" 
                            :class="{'opacity-50 cursor-not-allowed': selectedItems.length === 0, 'hover:bg-gray-800': selectedItems.length > 0}"
                            class="w-full bg-black text-white font-medium text-sm tracking-widest uppercase py-5 px-4 transition-colors flex justify-center items-center mb-4">
                        Lanjut ke Checkout
                    </button>
                    
                    <a href="{{ route('pembeli.products') }}" class="w-full bg-transparent border border-black text-black hover:bg-black hover:text-white font-medium text-sm tracking-widest uppercase py-5 px-4 transition-colors flex justify-center items-center">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </form>
        
        <!-- Forms for Delete and Update outside the main form so they don't conflict -->
        @foreach($carts as $cart)
            <form id="form-delete-{{ $cart->id }}" action="{{ route('pembeli.cart.destroy', $cart) }}" method="POST" class="hidden">
                @csrf @method('DELETE')
            </form>
            <form id="form-update-{{ $cart->id }}" action="{{ route('pembeli.cart.update', $cart) }}" method="POST" class="hidden">
                @csrf @method('PATCH')
            </form>
        @endforeach
    @else
        <div class="py-32 flex flex-col items-center justify-center text-center">
            <h3 class="text-3xl md:text-4xl font-black text-black mb-4 tracking-tighter">Keranjang Anda Kosong</h3>
            <p class="text-lg text-gray-500 mb-10 max-w-md">Sepertinya Anda belum memilih produk apa pun. Temukan gaya esensial Anda sekarang.</p>
            <a href="{{ route('pembeli.products') }}" class="border-b-2 border-black text-black hover:text-gray-500 hover:border-gray-500 font-medium text-sm tracking-widest uppercase pb-1 transition-colors">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartManager', (initialCarts) => ({
            selectedItems: initialCarts.map(c => c.id.toString()),
            carts: initialCarts,
            
            get selectAll() {
                return this.selectedItems.length === this.carts.length && this.carts.length > 0;
            },
            set selectAll(value) {
                if (value) {
                    this.selectedItems = this.carts.map(c => c.id.toString());
                } else {
                    this.selectedItems = [];
                }
            },
            
            get total() {
                return this.carts
                    .filter(c => this.selectedItems.includes(c.id.toString()))
                    .reduce((sum, c) => sum + (c.product.harga * c.jumlah), 0);
            },
            
            get totalItems() {
                return this.carts
                    .filter(c => this.selectedItems.includes(c.id.toString()))
                    .reduce((sum, c) => sum + parseInt(c.jumlah), 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('Rp', 'Rp ').replace(',00', '');
            }
        }));
    });
</script>
@endpush
