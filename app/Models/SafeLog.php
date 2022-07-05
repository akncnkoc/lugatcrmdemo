<?php

namespace App\Models;

use App\Observers\SafeLogObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\SafeLog
 *
 * @property int $id
 * @property string|null $content
 * @property string $price
 * @property string $normal_price
 * @property int $process_type
 * @property string $commission
 * @property string|null $date
 * @property int $safe_id
 * @property int|null $cash_register_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CashRegister|null $cash_register
 * @property-read Safe|null $safe
 * @method static Builder|SafeLog newModelQuery()
 * @method static Builder|SafeLog newQuery()
 * @method static Builder|SafeLog query()
 * @method static Builder|SafeLog whereCashRegisterId($value)
 * @method static Builder|SafeLog whereCommission($value)
 * @method static Builder|SafeLog whereContent($value)
 * @method static Builder|SafeLog whereCreatedAt($value)
 * @method static Builder|SafeLog whereDate($value)
 * @method static Builder|SafeLog whereId($value)
 * @method static Builder|SafeLog whereNormalPrice($value)
 * @method static Builder|SafeLog wherePrice($value)
 * @method static Builder|SafeLog whereProcessType($value)
 * @method static Builder|SafeLog whereSafeId($value)
 * @method static Builder|SafeLog whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SafeLog extends Model
{
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    SafeLog::observe(SafeLogObserver::class);
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id')->whereNull('deleted_at');
  }

  public function cash_register()
  {
    return $this->belongsTo(CashRegister::class, 'cash_register_id');
  }
}
