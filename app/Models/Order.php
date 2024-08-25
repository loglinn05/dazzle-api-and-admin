<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
