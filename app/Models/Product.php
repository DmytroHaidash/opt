<?php

namespace App\Models;

use App\Http\Resources\ImageDisplayResource;
use App\Http\Resources\ImageUploadResource;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany, MorphMany};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Str;


/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property array|null $content
 * @property int $is_published
 * @property int $has_pickup
 * @property int $has_delivery
 * @property int|null $city_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read City|null $city
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read mixed $cover
 * @property-read AnonymousResourceCollection $gallery
 * @property-read mixed $thumb
 * @property-read mixed $translations
 * @property-read AnonymousResourceCollection $uploads
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read User $user
 * @property-read Collection|Value[] $values
 * @property-read int|null $values_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereContent($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereHasDelivery($value)
 * @method static Builder|Product whereHasPickup($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsPublished($value)
 * @method static Builder|Product whereLatitude($value)
 * @method static Builder|Product whereLongitude($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUserId($value)
 * @mixin Eloquent
 * @property string|null $published_at
 * @property string|null $address
 * @property-read Collection|Favorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read bool $in_favorites
 * @method static Builder|Product whereAddress($value)
 * @method static Builder|Product wherePublishedAt($value)
 */
class Product extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'user_id', 'title', 'content', 'is_published', 'published_at', 'has_delivery', 'has_pickup',
        'latitude', 'longitude', 'address', 'city_id', 'published_requested_at', 'views_count', 'price_arranged'
    ];

    protected $translatable = [
        'title', 'content'
    ];

    protected $with = [
        'user', 'values'
    ];

    /* Relations */

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->with('city')
            ->withDefault([
                'name' => 'н/д',
                'email' => 'н/д',
                'phone' => 'н/д',
                'city_id' => 1
            ]);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(Value::class);
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

    /**
     * @return MorphMany
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /* Accessors */

    /**
     * @return AnonymousResourceCollection
     */
    public function getUploadsAttribute(): AnonymousResourceCollection
    {
        return ImageUploadResource::collection($this->getMedia());
    }

    /**
     * @return array
     */
    public function getGalleryAttribute(): array
    {
        return $this->getMedia()->map(function (Media $media) {
            return new ImageDisplayResource($media, 'large');
        })->all();
    }

    /**
     * @return mixed
     */
    public function getCoverAttribute()
    {
        return optional($this->getFirstMedia())->getFullUrl();
    }

    /**
     * @return mixed
     */
    public function getThumbAttribute()
    {
        return optional($this->getFirstMedia())->getFullUrl('thumb');
    }

    /* Helpers */

    public function getPath()
    {
        return [$this->getKey(), Str::slug($this->title)];
    }

    /* Setup */

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 48, 48)
            ->width(48)
            ->height(48)
            ->sharpen(10);

        $this->addMediaConversion('large')
            ->fit(Manipulations::FIT_CROP, 480, 480)
            ->width(480)
            ->height(480)
            ->sharpen(10);
    }

    /**
     * @return bool
     */
    public function getInFavoritesAttribute(): bool
    {
        return $this->favorites()->where('user_id', Auth::user()->id)->exists();
    }

    /**
     * Store viewed articles and count up
     */
    public function handleViewed()
    {
        if (!session()->has('viewed_products')) {
            session()->put('viewed_products', []);
        }

        $viewed = collect(session()->get('viewed_products'));

        if (!$viewed->contains($this->id)) {
            $viewed->prepend($this->id);
            session()->put('viewed_products', $viewed->all());

            $this->update([
                'views_count' => $this->views_count + 1,
            ]);
        }
    }

    /**
     * Boot up model
     */
    protected static function boot()
    {
        parent::boot();

        if (app('router')->currentRouteNamed('client.*') && !app('router')->currentRouteNamed('client.profile.*')) {
            self::addGlobalScope('available', function (Builder $builder) {
                $builder->where('is_published', 1)
                    ->whereHas('user', function ($query) {
                        $query->where('active', 1);
                    });
            });
        }
    }
}
