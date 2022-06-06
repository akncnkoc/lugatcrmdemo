<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CargoCompany
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $photo_path
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoCompany wherePhotoPath($value)
 */
class CargoCompany extends Model
{
  public $timestamps = false;
  protected $guarded = [];
}
