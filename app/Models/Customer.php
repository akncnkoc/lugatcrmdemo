<?php

namespace App\Models;

use App\Events\CustomerUpdatedEvent;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $facebook_link
 * @property string|null $twitter_link
 * @property string|null $instagram_link
 * @property string|null $country
 * @property string|null $county
 * @property string|null $district
 * @property string|null $address
 * @property string|null $comment
 * @property string|null $custom_contact_information
 * @property int|null $gender
 * @property int|null $customer_role_id
 * @property string|null $post_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Models\CustomerRole|null $customer_role
 * @property-read mixed $fullname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static \Illuminate\Database\Query\Builder|Customer onlyTrashed()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereAddress($value)
 * @method static Builder|Customer whereComment($value)
 * @method static Builder|Customer whereCountry($value)
 * @method static Builder|Customer whereCounty($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereCustomContactInformation($value)
 * @method static Builder|Customer whereCustomerRoleId($value)
 * @method static Builder|Customer whereDeletedAt($value)
 * @method static Builder|Customer whereDistrict($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereFacebookLink($value)
 * @method static Builder|Customer whereGender($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereInstagramLink($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer wherePostCode($value)
 * @method static Builder|Customer whereSurname($value)
 * @method static Builder|Customer whereTwitterLink($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Customer withoutTrashed()
 * @mixin Eloquent
 * @property int|null $country_id
 * @property int|null $county_id
 * @property int|null $district_id
 * @method static Builder|Customer whereCountryId($value)
 * @method static Builder|Customer whereCountyId($value)
 * @method static Builder|Customer whereDistrictId($value)
 */
class Customer extends Model
{
  use Notifiable;
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
  }
  
  public function getFullAddress()
  {
    if (!empty($this->address)) return $this->address;
    else return implode(' ', [$this->country, $this->county, $this->district]);
  }

  public function customer_role()
  {
    return $this->belongsTo(CustomerRole::class, 'customer_role_id');
  }

  public function invoices()
  {
    return $this->hasMany(Invoice::class, 'customer_id');
  }
}
