<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\StaffRole
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|StaffRole newModelQuery()
 * @method static Builder|StaffRole newQuery()
 * @method static \Illuminate\Database\Query\Builder|StaffRole onlyTrashed()
 * @method static Builder|StaffRole query()
 * @method static Builder|StaffRole whereCreatedAt($value)
 * @method static Builder|StaffRole whereDeletedAt($value)
 * @method static Builder|StaffRole whereId($value)
 * @method static Builder|StaffRole whereName($value)
 * @method static Builder|StaffRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StaffRole withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StaffRole withoutTrashed()
 * @mixin \Eloquent
 */
class StaffRole extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  public $timestamps = false;
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot(); // TODO: Change the autogenerated stub
    static::addGlobalScope('order', function (Builder $builder) {
      $builder->orderBy('id', 'desc');
    });
    static::saving(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::updating(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::deleting(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
  }
}
