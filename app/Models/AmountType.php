<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AmountType
 *
 * @method static \Database\Factories\AmountTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AmountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AmountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AmountType query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|AmountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmountType whereName($value)
 */
class AmountType extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $guarded = [];
}
