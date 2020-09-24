<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};


/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $buyer_id
 * @property float $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $buyer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $sellers
 * @property-read int|null $sellers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property object|null $details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDetails($value)
 */
class Order extends Model
{
    protected $fillable = [
        'buyer_id', 'total', 'details'
    ];

    protected $casts = [
        'details' => 'object'
    ];

    /* Relations */

    /**
     * @return HasMany
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * @return BelongsTo
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'н/д',
            'email' => 'н/д',
            'phone' => 'н/д',
        ]);
    }

    /**
     * @return BelongsToMany
     */
    public function sellers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'order_seller',
            'order_id',
            'seller_id'
        );
    }
}
