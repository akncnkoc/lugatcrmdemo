<?php

namespace App\Models;

use App\Observers\InvoiceExpenseObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\InvoiceExpense
 *
 * @property-read \App\Models\ExpenseType|null $expense_type
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static Builder|InvoiceExpense newModelQuery()
 * @method static Builder|InvoiceExpense newQuery()
 * @method static \Illuminate\Database\Query\Builder|InvoiceExpense onlyTrashed()
 * @method static Builder|InvoiceExpense query()
 * @method static \Illuminate\Database\Query\Builder|InvoiceExpense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InvoiceExpense withoutTrashed()
 * @mixin \Eloquent
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
