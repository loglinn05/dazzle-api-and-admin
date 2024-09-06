<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'shipping_address',
        'total',
        'status',
    ];

    const UPDATED_AT = null;

    function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('product_quantity');
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
