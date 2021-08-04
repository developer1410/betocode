<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organisation
 *
 * @property int         id
 * @property string      name
 * @property int         owner_user_id
 * @property Carbon      trial_end
 * @property bool        subscribed
 * @property Carbon      created_at
 * @property Carbon      updated_at
 * @property Carbon|null deleted_at
 * @property User        owner
 *
 * @package App
 */
class Organisation extends Model
{
    use SoftDeletes;

    public const TRIAL_PERIOD_DURATION_DAYS = 30;

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $dates = [
        'trial_end',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id', 'id');
    }

    /**
     * Scope a query to only include deposits filtered by 'where' condition based on filter array.
     *
     * @param Builder $query
     * @param string $filter
     * @return Builder
     */
    public function scopeFiltered(Builder $query, string $filter)
    {
        if ($filter == 'subbed') {
            return $query->where('subscribed', 1);
        } elseif ($filter == 'trial') {
            return $query->where('subscribed', 0);
        }
        return $query;
    }
}
