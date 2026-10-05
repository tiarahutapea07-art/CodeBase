<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingGood extends Model
{
    protected $fillable = ['product_id', 'quantity', 'destination', 'date', 'user_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}