<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['status', 'total'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
