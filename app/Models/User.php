<?php

namespace App\Models;

use App\Http\Resources\ImageUploadResource;
use Auth;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany, MorphMany};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Session;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Str;


/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $role
 * @property int|null $city_id
 * @property int $active
 * @property int|null $ads_in_day
 * @property string $channels
 * @property string|null $telegram_token
 * @property string|null $remember_token
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read City|null $city
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read Collection|Order[] $sales
 * @property-read int|null $sales_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereChannels($value)
 * @method static Builder|User whereCityId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereTelegramToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @method static Builder|User whereAdsInDay($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 */
class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable, InteractsWithMedia, HasTranslations;

    public static $ROLES = [
        'seller', 'buyer', 'admin', 'moderator', 'writer', 'booker', 'carrier'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'role', 'organization', 'phone', 'active', 'city_id',
        'channels', 'telegram_token', 'email_verified_at', 'ads_in_day', 'type_car', 'brand_car', 'price_km', 'tonnage',
        'all_region', 'car_region', 'worked_region', 'published_carrier', 'carrier_description'
    ];

    protected $translatable = [
        'carrier_description'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'email_verified_at'
    ];

    protected $casts = [
        'worked_region' => 'array'
    ];

    /* Relations */

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

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
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function region_car(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'car_region');
    }

    /**
     * @return BelongsToMany
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(
            Order::class,
            'order_seller',
            'seller_id',
            'order_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function carrier_regions(): BelongsToMany
    {
        return $this->belongsToMany(
            Region::class,
            'carrier_region',
            'carrier_id',
            'region_id'
        );
    }

    /**
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * @return MorphMany
     */
    public function favorit():MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /* Helpers */

    /**
     * @param string|array $condition
     * @return bool
     */
    public function hasRole($condition): bool
    {
        if (is_string($condition)) {
            $condition = explode('|', $condition);
        }

        return in_array($this->role, $condition);
    }

    /**
     * @return string|integer
     */
    public static function current()
    {
        return Auth::check() ? Auth::user()->id : Session::getId();
    }

    /* Accessors */

    public function getTruckAttribute()
    {
        return ImageUploadResource::collection($this->getMedia('carrier'));
    }

    public function getCarrierPreviewAttribute()
    {
        return $this->hasMedia('carrier')
            ? $this->getFirstMedia('carrier')->getFullUrl()
            : asset('images/no-avatar.png');
    }
    public function getAvatarAttribute()
    {
        return $this->hasMedia('avatar')
            ? $this->getFirstMedia('avatar')->getFullUrl('thumb')
            : asset('images/no-avatar.png');
    }
    /* Helpers */

    public function getPath()
    {
        return [$this->getKey(), Str::slug($this->name)];
    }
    /* Setup */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl(asset('images/no-avatar.png'))
            ->registerMediaConversions(function (Media $media = null) {
                $this->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 48, 48)
                    ->width(48)
                    ->height(48)
                    ->sharpen(10)
                    ->nonQueued();

                $this->addMediaConversion('large')
                    ->fit(Manipulations::FIT_CROP, 384, 384)
                    ->width(384)
                    ->height(384)
                    ->sharpen(10)
                    ->nonQueued();
            });
    }

    /**
     * @return bool
     */
    public function getInFavoritesAttribute(): bool
    {
        return $this->favorit()->where('user_id', Auth::user()->id)->exists();
    }

    /**
     * BOOT
     */
    protected static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->phone = str_replace([' ', '-', '+'], '', $model->phone);
        });
    }
}
