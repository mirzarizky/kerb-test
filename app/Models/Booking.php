<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Booking
 *
 * @property int $id
 * @property int $bay_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $start_time
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bay $bay
 * @property-read \App\Models\User $leaser
 * @method static \Database\Factories\BookingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'bay_id',
        'user_id',

        'start_time',
        'paid_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'paid_at'    => 'datetime'
    ];

    public function bay()
    {
        return $this->belongsTo(Bay::class, 'bay_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
