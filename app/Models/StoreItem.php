<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    protected $fillable = ['item_type', 'item_id', 'category', 'price'];

    public function item()
    {
        return $this->morphTo(null, 'item_type', 'item_id');
    }
}
