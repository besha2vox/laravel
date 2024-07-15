<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kyslik\ColumnSortable\Sortable;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'id',
        'slug',
        'title',
        'SKU',
        'description',
        'price',
        'discount',
        'quantity',
        'thumbnail',
        'created_at',
        'updated_at'
    ];

    public $sortable = [
        'id',
        'title',
        'SKU',
        'price',
        'quantity',
        'discount',
        'created_at',
        'updated_at'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
