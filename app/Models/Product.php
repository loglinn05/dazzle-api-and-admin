<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    const UPDATED_AT = null;

    function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class);
    }

    function scopeWithFilters(Builder $query)
    {
        $filterValues = request()->input('filterValues');
        return $query->when(count($filterValues['types']), function ($query) use ($filterValues) {
            $query->whereIn('type_id', $filterValues['types']);
        })
            ->when(count($filterValues['sizes']), function ($query) use ($filterValues) {
                $query->whereHas('sizes', function (Builder $query) use ($filterValues) {
                    $query->whereIn('product_size.size_id', $filterValues['sizes']);
                });
            })
            ->when(count($filterValues['colors']), function ($query) use ($filterValues) {
                $query->whereHas('colors', function (Builder $query) use ($filterValues) {
                    $query->whereIn('color_product.color_id', $filterValues['colors']);
                });
            })
            ->when(count($filterValues['materials']), function ($query) use ($filterValues) {
                $query->whereHas('materials', function (Builder $query) use ($filterValues) {
                    $query->whereIn('material_product.material_id', $filterValues['materials']);
                });
            })
            ->when(count($filterValues['seasons']), function ($query) use ($filterValues) {
                $query->whereHas('seasons', function (Builder $query) use ($filterValues) {
                    $query->whereIn('product_season.season_id', $filterValues['seasons']);
                });
            })
            ->when(count($filterValues['price']), function ($query) use ($filterValues) {
                $query->whereBetween('price', $filterValues['price']);
            })
            ->when(count($filterValues['manufacturers']), function ($query) use ($filterValues) {
                $query->whereIn('manufacturer_id', $filterValues['manufacturers']);
            });
    }
}
