<?php

namespace App\Models;

use App\Observers\StaffObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Staff
 *
 * @property int $id
 * @property string $name
 * @property string|null $surname
 * @property string|null $phone
 * @property string|null $email
 * @property string $salary
 * @property string|null $comment
 * @property int $gender
 * @property int $staff_role_id
 * @property int|null $salary_safe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StaffPayment[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Safe|null $salary_safe
 * @property-read \App\Models\StaffRole|null $staff_role
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Query\Builder|Staff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereSalarySafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereStaffRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Staff withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Staff withoutTrashed()
 * @mixin \Eloquent
 */
class Staff extends Model
{
  use SoftDeletes;

  protected $guarded = [];
  protected $table = 'staffs';

  protected static function boot()
  {
    parent::boot();
    Staff::observe(StaffObserver::class);
  }

  public function getFullName()
  {
    return trim(implode(' ', array(
      $this->name,
      $this->surname
    )));
  }

  public function staff_role()
  {
    return $this->belongsTo(StaffRole::class, 'staff_role_id')->withTrashed();
  }

  public function invoices()
  {
    return $this->hasMany(Invoice::class, 'staff_id')->withTrashed();
  }

  public function salary_safe()
  {
    return $this->belongsTo(Safe::class, 'salary_safe_id')->withTrashed();
  }

  public function payments()
  {
    return $this->hasMany(StaffPayment::class, 'staff_id');
  }
}
