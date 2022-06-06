<?php

namespace Tests\Unit;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Safe;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
//  use DatabaseTransactions;

  public function test_can_create_expense()
  {
    $safe = Safe::factory()->create();
    $expense_type = ExpenseType::factory()->create();
    $data = [
      'price' => $this->faker->numberBetween(10, 50),
      'safe_id' => $safe->id,
      'date' => $this->faker->date('d-m-Y'),
      'expense_type_id' => $expense_type->id
    ];

    $this->post(route('expense.store'), $data)
      ->assertStatus(200);
  }

  public function test_can_update_expense()
  {
    $expense = Expense::factory()->create();
    $safe = Safe::factory()->create();
    $expense_type = ExpenseType::factory()->create();
    $data = [
      'price' => $this->faker->numberBetween(10, 50),
      'safe_id' => $safe->id,
      'date' => $this->faker->date('d-m-Y'),
      'expense_type_id' => $expense_type->id,
      'id' => $expense->id
    ];
    $this->post(route('expense.update'), $data)
      ->assertStatus(200);
  }

  public function test_can_delete_expense()
  {
    $expense = Expense::factory()->create();
    $this->post(route('expense.delete'), ['id' => $expense->id])
      ->assertStatus(200);
  }

  public function test_can_list_expense()
  {
    $expense = Expense::factory()->create();

    $this->post(route('expense.get'), ['id' => $expense->id])
      ->assertStatus(200)
      ->assertJsonStructure(['id', 'price', 'safe_id', 'expense_type_id', 'comment']);
  }
}
