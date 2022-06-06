<?php

namespace App\Models;

use App\Observers\SafeObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Safe
 *
 * @property int $id
 * @property string $name
 * @property int|null $currency_id
 * @property string|null $total
 * @property int $show_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\CurrencyType|null $currency
 * @method static Builder|Safe newModelQuery()
 * @method static Builder|Safe newQuery()
 * @method static \Illuminate\Database\Query\Builder|Safe onlyTrashed()
 * @method static Builder|Safe query()
 * @method static Builder|Safe whereCreatedAt($value)
 * @method static Builder|Safe whereCurrencyId($value)
 * @method static Builder|Safe whereDeletedAt($value)
 * @method static Builder|Safe whereId($value)
 * @method static Builder|Safe whereName($value)
 * @method static Builder|Safe whereShowOrder($value)
 * @method static Builder|Safe whereTotal($value)
 * @method static Builder|Safe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Safe withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Safe withoutTrashed()
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SafeLog[] $safe_logs
 * @property-read int|null $safe_logs_count
 */
class Safe extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    self::observe(SafeObserver::class);
  }


  public function currency()
  {
    return $this->belongsTo(Currency::class, 'currency_id');
  }

  public function safe_logs()
  {
    return $this->hasMany(SafeLog::class, 'safe_id');
  }
}
