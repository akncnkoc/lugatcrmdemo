<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $authorized_person
 * @property string|null $custom_contact_information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupplierRegularPayment[] $regular_payments
 * @property-read int|null $regular_payments_count
 * @method static Builder|Supplier newModelQuery()
 * @method static Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Query\Builder|Supplier onlyTrashed()
 * @method static Builder|Supplier query()
 * @method static Builder|Supplier whereAuthorizedPerson($value)
 * @method static Builder|Supplier whereCreatedAt($value)
 * @method static Builder|Supplier whereCustomContactInformation($value)
 * @method static Builder|Supplier whereDeletedAt($value)
 * @method static Builder|Supplier whereEmail($value)
 * @method static Builder|Supplier whereId($value)
 * @method static Builder|Supplier whereName($value)
 * @method static Builder|Supplier wherePhone($value)
 * @method static Builder|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Supplier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Supplier withoutTrashed()
 * @mixin Eloquent
 */
class Supplier extends Model
{
  use SoftDeletes;
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    //TODO: make observer hereeee
  }


  public function regular_payments()
  {
    return $this->hasMany(SupplierRegularPayment::class, 'supplier_id')
      ->withTrashed();
  }

}
