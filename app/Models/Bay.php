<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bay
 *
 * @property int $id
 * @property string $name
 * @property int $user_id bay owner
 * @property bool $is_occupied
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $owner
 * @method static \Database\Factories\BayFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bay query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bay whereIsOccupied($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bay whereUserId($value)
 * @mixin \Eloquent
 * @method static Builder|Bay available()
 * @method static Builder|Bay occupied()
 */
class Bay extends Model
{
    use HasFactory;

    protected $table = 'bays';
    protected $fillable = [
        'user_id',

        'name',
        'is_occupied',
    ];

    protected $casts = [
        'is_occupied' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where('is_occupied', false);
    }

    public function scopeOccupied(Builder $query)
    {
        return $query->where('is_occupied', true);
    }
}
