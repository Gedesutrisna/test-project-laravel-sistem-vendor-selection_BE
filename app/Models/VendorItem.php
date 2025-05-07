<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_item';
    protected $fillable = ['vendor_id', 'item_id', 'price_before', 'price_now'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
