<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CashRegister
 *
 * @property int $id
 * @property string $name
 * @property float $percentage
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceProduct[] $invoice_products
 * @property-read int|null $invoice_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister newQuery()
 * @method static \Illuminate\Database\Query\Builder|CashRegister onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister wherePercentage($value)
 * @method static \Illuminate\Database\Query\Builder|CashRegister withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CashRegister withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashRegister whereUpdatedAt($value)
 */
class CashRegister extends Model
{
  use SoftDeletes;

  public $timestamps = false;
  protected $guarded = [];

  public function invoice_products()
  {
    return $this->hasMany(InvoiceProduct::class)->with('invoice');
  }
}
