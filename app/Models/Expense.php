<?php

namespace App\Models;

use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property string $price
 * @property string|null $comment
 * @property string $date
 * @property int|null $expense_type_id
 * @property int|null $safe_id
 * @property int|null $safe_log_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\ExpenseType|null $expense_type
 * @property-read \App\Models\Safe|null $safe
 * @property-read \App\Models\SafeLog|null $safe_log
 * @method static \Database\Factories\ExpenseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereExpenseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereSafeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereSafeLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Expense extends Model
{
  use HasFactory;

  protected $guarded = [];

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
