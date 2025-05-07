<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name'];

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_item')
                    ->withPivot(['price_before', 'price_now'])
                    ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

