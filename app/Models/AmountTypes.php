<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AmountTypes
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|AmountTypes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AmountTypes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AmountTypes query()
 * @method static \Illuminate\Database\Eloquent\Builder|AmountTypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmountTypes whereName($value)
 * @mixin \Eloquent
 */
class AmountTypes extends Model
{

  public $timestamps = false;
  protected $guarded = [];
}
