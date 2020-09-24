<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Models\Value
 *
 * @property int $id
 * @property int $product_id
 * @property int $unit_id
 * @property float $price
 * @property float|null $discount
 * @property int $step
 * @property int|null $min
 * @property int|null $max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Unit $unit
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Value extends Model
{
    protected $fillable = [
        'product_id', 'unit_id', 'price', 'discount', 'step', 'min', 'max'
    ];

    /* Relations */

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
