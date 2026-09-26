<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'condition',
        'image_url',
    ];

    // Fungsi relasi ini yang sebelumnya belum ada / keliru
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}