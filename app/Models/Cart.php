<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * App\Models\Cart
 *
 * @property int $id
 * @property string $user_id
 * @property int|null $order_id
 * @property int $product_id
 * @property int $value_id
 * @property int $quantity
 * @property mixed|null $final
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Value $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart current()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart unfinished()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereValueId($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    protected $fillable = [
        'user_id', 'value_id', 'product_id', 'order_id', 'quantity', 'final'
    ];

    /* Relations */

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(new User([
            'name' => __('auth.anonymous'),
            'email' => 'н/д',
            'phone' => 'н/д',
            'role' => 'anonymous'
        ]));
    }

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
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(Value::class);
    }

    /* Scopes */

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeUnfinished(Builder $builder): Builder
    {
        return $builder->whereNull('order_id');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeCurrent(Builder $builder): Builder
    {
        return $builder->whereNull('order_id')->where('user_id', (string)User::current());
    }

    /* Helpers */

    public static function getTotal()
    {
        return static::current()->get()->reduce(function ($total, Cart $item) {
            $quantity = $item->quantity;
            $price = $item->value->price;

            return $total += $price * $quantity;
        }, 0);
    }
}
