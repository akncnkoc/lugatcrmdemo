<?php

namespace App\Models;

use App\Observers\RegularPaymentObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RegularPayment
 *
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property int $regular_payment_type_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RegularPaymentPeriod[] $periods
 * @property-read int|null $periods_count
 * @property-read \App\Models\RegularPaymentType|null $regular_payment_type
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment whereRegularPaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegularPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RegularPayment extends Model
{
  public $timestamps = false;
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    RegularPayment::observe(RegularPaymentObserver::class);
  }


  public function regular_payment_type()
  {
    return $this->belongsTo(RegularPaymentType::class, 'regular_payment_type_id');
  }

  public function periods()
  {
    return $this->hasMany(RegularPaymentPeriod::class, 'regular_payment_id');
  }
}
