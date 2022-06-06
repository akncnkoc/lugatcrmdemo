<?php

namespace App\Models;

use App\Observers\StaffObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Staff
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $salary
 * @property int|null $salary_safe_id
 * @property int|null $staff_role_id
 * @property string|null $comment
 * @property float $default_invoice_share
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read Collection|\App\Models\InvoiceStaff[] $invoice_staffs
 * @property-read int|null $invoice_staffs_count
 * @property-read Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read Collection|\App\Models\StaffPayment[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Safe|null $salary_safe
 * @property-read \App\Models\StaffRole|null $staff_role
 * @method static Builder|Staff newModelQuery()
 * @method static Builder|Staff newQuery()
 * @method static \Illuminate\Database\Query\Builder|Staff onlyTrashed()
 * @method static Builder|Staff query()
 * @method static Builder|Staff whereComment($value)
 * @method static Builder|Staff whereCreatedAt($value)
 * @method static Builder|Staff whereDefaultInvoiceShare($value)
 * @method static Builder|Staff whereDeletedAt($value)
 * @method static Builder|Staff whereEmail($value)
 * @method static Builder|Staff whereId($value)
 * @method static Builder|Staff whereName($value)
 * @method static Builder|Staff wherePhone($value)
 * @method static Builder|Staff whereSalary($value)
 * @method static Builder|Staff whereSalarySafeId($value)
 * @method static Builder|Staff whereStaffRoleId($value)
 * @method static Builder|Staff whereSurname($value)
 * @method static Builder|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Staff withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Staff withoutTrashed()
 * @mixin Eloquent
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
