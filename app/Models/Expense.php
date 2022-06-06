<?php

namespace App\Models;

use App\Observers\ExpenseObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property int|null $expense_type_id
 * @property string|null $price
 * @property int|null $safe_id
 * @property string|null $comment
 * @property string|null $receipt_date
 * @property int|null $safe_log_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\ExpenseType|null $expense_type
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static Builder|Expense newModelQuery()
 * @method static Builder|Expense newQuery()
 * @method static \Illuminate\Database\Query\Builder|Expense onlyTrashed()
 * @method static Builder|Expense query()
 * @method static Builder|Expense whereComment($value)
 * @method static Builder|Expense whereCreatedAt($value)
 * @method static Builder|Expense whereDeletedAt($value)
 * @method static Builder|Expense whereExpenseTypeId($value)
 * @method static Builder|Expense whereId($value)
 * @method static Builder|Expense wherePrice($value)
 * @method static Builder|Expense whereReceiptDate($value)
 * @method static Builder|Expense whereSafeId($value)
 * @method static Builder|Expense whereSafeLogId($value)
 * @method static Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Expense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Expense withoutTrashed()
 * @mixin Eloquent
 */
class Expense extends Model
{
  protected $guarded = [];
  use HasFactory;
  protected static function boot()
  {
    parent::boot();
    self::observe(ExpenseObserver::class);
  }
  public function getDateAttribute($value)
  {
    return Carbon::parse($value)->format('Y-m-d');
  }

  public function expense_type()
  {
    return $this->belongsTo(ExpenseType::class, 'expense_type_id');
  }

  public function safe_log()
  {
    return $this->belongsTo(SafeLog::class, 'safe_log_id');
  }

  public function safe()
  {
    return $this->belongsTo(Safe::class, 'safe_id');
  }
}
