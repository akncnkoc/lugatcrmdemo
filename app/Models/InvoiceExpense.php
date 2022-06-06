<?php

namespace App\Models;

use App\Observers\InvoiceExpenseObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\InvoiceExpense
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int|null $expense_type_id
 * @property string|null $price
 * @property int|null $safe_id
 * @property int|null $safe_log_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\ExpenseType|null $expense_type
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static Builder|InvoiceExpense newModelQuery()
 * @method static Builder|InvoiceExpense newQuery()
 * @method static \Illuminate\Database\Query\Builder|InvoiceExpense onlyTrashed()
 * @method static Builder|InvoiceExpense query()
 * @method static Builder|InvoiceExpense whereCreatedAt($value)
 * @method static Builder|InvoiceExpense whereDeletedAt($value)
 * @method static Builder|InvoiceExpense whereExpenseTypeId($value)
 * @method static Builder|InvoiceExpense whereId($value)
 * @method static Builder|InvoiceExpense whereInvoiceId($value)
 * @method static Builder|InvoiceExpense wherePrice($value)
 * @method static Builder|InvoiceExpense whereSafeId($value)
 * @method static Builder|InvoiceExpense whereSafeLogId($value)
 * @method static Builder|InvoiceExpense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InvoiceExpense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InvoiceExpense withoutTrashed()
 * @mixin Eloquent
 */
class InvoiceExpense extends Model
{
  use SoftDeletes;

  protected static $logAttributes = [];
  protected $guarded = [];

  protected static function boot()
  {
    parent::boot();
    InvoiceExpense::observe(InvoiceExpenseObserver::class);
    static::addGlobalScope('order', function (Builder $builder) {
      $builder->orderBy('id', 'desc');
    });
    static::saving(function (Model $model) {
      static::$logAttributes = array_keys($model->getDirty());
    });
    static::updating(function (InvoiceExpense $model) {
      static::$logAttributes = array_keys($model->getDirty());
      $safe = $model->safe_log->safe;
      $safe->update([
        'total' => $safe->total + ($model->price)
      ]);
    });
  }

  public function invoice()
  {
    return $this->belongsTo(Invoice::class, 'invoice_id');
  }

  public function expense_type()
  {
    return $this->belongsTo(ExpenseType::class, 'expense_type_id');
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id');
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }

}
