<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Session;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


/**
 * App\Models\Upload
 *
 * @property int $id
 * @property string $user_id
 * @property string $source
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereUserId($value)
 * @mixin \Eloquent
 */
class Upload extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'source'
    ];

    /* Setup */

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->user_id = Auth::check() ? Auth::user()->id : Session::getId();
        });
    }
}
