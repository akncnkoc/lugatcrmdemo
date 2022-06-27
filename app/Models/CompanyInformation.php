<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompanyInformation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyInformation query()
 * @mixin \Eloquent
 */
class CompanyInformation extends Model
{
  public $timestamps = false;
  public $incrementing = false;
  protected $guarded = [];
  protected $primaryKey = null;
}
