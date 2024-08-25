<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Season extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = ['title'];

    public $timestamps = false;

    function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
