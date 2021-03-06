<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CargoType
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CargoType extends Model
{
  public $timestamps = false;
  protected $guarded = [];
}
