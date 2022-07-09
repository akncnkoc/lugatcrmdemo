<?php

namespace Tests;

use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use FakerEcommerce\Ecommerce;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;
  use DatabaseMigrations;

  public Generator $faker;
  protected User $user;
  protected string $plainToken;

  protected function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory()->create();
    $this->plainToken = Sanctum::actingAs($this->user)->createToken($this->user->email)->plainTextToken;
    $this->withHeader("token", $this->plainToken);
    $this->faker = Factory::create('tr_TR');
    $this->faker->addProvider(new Ecommerce($this->faker));
    $this->withoutExceptionHandling();
    $this->withoutMiddleware(EnsureFrontendRequestsAreStateful::class);
  }
}
