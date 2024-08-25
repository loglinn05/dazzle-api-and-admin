<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public $timestamps = false;

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
