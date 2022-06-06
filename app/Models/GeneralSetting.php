<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeneralSetting
 *
 * @property int $critical_stock_warning
 * @property int $critical_stock_number
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereCriticalStockNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting whereCriticalStockWarning($value)
 * @mixin \Eloquent
 */
class GeneralSetting extends Model
{

  public $timestamps = false;
  public $incrementing = false;
  protected $guarded = [];
  protected $primaryKey = null;
}
