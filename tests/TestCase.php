<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;
  public \Faker\Generator $faker;

  protected function setUp(): void
  {
    parent::setUp();
    $this->faker = Factory::create('tr_TR');
    $this->artisan('db:seed');
    $this->withoutExceptionHandling();
  }
}
