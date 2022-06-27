<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ExpenseType
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\ExpenseTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExpenseType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExpenseType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExpenseType withoutTrashed()
 * @mixin \Eloquent
 */
class ExpenseType extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected static $logAttributes = [];
  public $timestamps = false;
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
  }
}
