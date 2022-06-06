<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RegularPaymentType
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPaymentType whereName($value)
 * @mixin \Eloquent
 */
class RegularPaymentType extends Model
{
  public $timestamps = false;
  protected $guarded = [];
}
