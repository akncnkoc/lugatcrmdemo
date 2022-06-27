<?php

namespace App\Models;

use App\Observers\SafeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Safe
 *
 * @property int $id
 * @property string $name
 * @property string $total
 * @property int $currency_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SafeLog[] $safe_logs
 * @property-read int|null $safe_logs_count
 * @method static \Database\Factories\SafeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Safe newQuery()
 * @method static \Illuminate\Database\Query\Builder|Safe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Safe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Safe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Safe withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Safe withoutTrashed()
 * @mixin \Eloquent
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
