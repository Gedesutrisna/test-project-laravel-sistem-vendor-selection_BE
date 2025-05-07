<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'vendor_item')
                    ->withPivot(['price_before', 'price_now'])
                    ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
