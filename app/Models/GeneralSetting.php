<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeneralSetting
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralSetting query()
 * @mixin \Eloquent
 */
class GeneralSetting extends Model
{
  public $timestamps = false;
  public $incrementing = false;
  protected $guarded = [];
  protected $primaryKey = null;
}
