<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExpenseType
 *
 * @property int $id
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @method static Builder|ExpenseType newModelQuery()
 * @method static Builder|ExpenseType newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExpenseType onlyTrashed()
 * @method static Builder|ExpenseType query()
 * @method static Builder|ExpenseType whereCreatedAt($value)
 * @method static Builder|ExpenseType whereDeletedAt($value)
 * @method static Builder|ExpenseType whereId($value)
 * @method static Builder|ExpenseType whereName($value)
 * @method static Builder|ExpenseType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExpenseType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExpenseType withoutTrashed()
 * @mixin Eloquent
 * @method static \Database\Factories\ExpenseTypeFactory factory(...$parameters)
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
