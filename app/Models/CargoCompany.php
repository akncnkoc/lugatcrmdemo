<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CargoCompany
 *
 * @property int $id
 * @property string $name
 * @property string $photo_path
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany wherePhotoPath($value)
 * @mixin \Eloquent
 */
class CargoCompany extends Model
{
  public $timestamps = false;
  protected $guarded = [];
}
