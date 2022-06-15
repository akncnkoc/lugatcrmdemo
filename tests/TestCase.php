<?php

namespace Tests;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication, DatabaseMigrations;

  public \Faker\Generator $faker;
  protected User $user;
  protected string $plainToken;

  protected function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory()
      ->create();
    $this->plainToken = Sanctum::actingAs($this->user)
      ->createToken($this->user->email)->plainTextToken;
    $this->withHeader("token", $this->plainToken);
    $this->faker = Factory::create('tr_TR');
    $this->faker->addProvider(new \FakerEcommerce\Ecommerce($this->faker));
    $this->withoutExceptionHandling();
  }
}
