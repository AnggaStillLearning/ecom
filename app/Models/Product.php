<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Tambahkan ini
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // ✅ Tambahkan ini

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];
}
