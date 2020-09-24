<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property string $user_id
 * @property string $subject
 * @property string $message
 * @property string|null $name
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereUserId($value)
 * @mixin \Eloquent
 * @property int $is_resolved
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereIsResolved($value)
 */
class Ticket extends Model
{
    public static $SUBJECTS = [
        'financial_questions', 'selling_problem', 'buying_problem', 'offer'
    ];

    protected $fillable = [
        'user_id', 'subject', 'message', 'name', 'phone', 'is_resolved'
    ];

    /* Relations */

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => $this->name ?? 'н/д',
            'phone' => $this->phone ?? 'н/д'
        ]);
    }
}
