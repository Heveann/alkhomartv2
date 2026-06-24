<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'total_harga',
        'uang_dibayar',
        'kembalian',
        'status',
        'tipe',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'decimal:2',
            'uang_dibayar' => 'decimal:2',
            'kembalian' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateKode(): string
    {
        return 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
