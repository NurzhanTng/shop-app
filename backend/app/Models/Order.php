<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status', // например: pending, processing, completed
    ];

    // Relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relations with order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
