<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // WAJIB DITAMBAHKAN AGAR BISA CREATE & UPDATE
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'user_id',
    ];

    // Relasi ke tabel user (Opsional tapi penting untuk nampilin nama owner)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}