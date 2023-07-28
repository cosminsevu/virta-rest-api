<?php

namespace Tests;

use App\Models\Company;
use App\Models\Station;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createOneCompany($args = [])
    {
        return Company::factory()->create($args);
    }

    public function SeedCompanys($args = [])
    {
        Company::factory()->count(10)->create();
    }

    public function createOneStation($args = [])
    {
        return Station::factory()->create($args);
    }

    public function SeedStations($args = [])
    {
        Station::factory()->count(20)->create();
    }

    
}
