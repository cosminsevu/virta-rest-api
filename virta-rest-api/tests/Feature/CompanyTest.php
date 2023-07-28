<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Company;

class CompanyTest extends TestCase
{
    
    use RefreshDatabase;
    private $company;

    /**
     * Test creating a new company.
     *
     * @return void
     */
    public function testCreateCompany()
    {

        // preparation
        $this->company = $this->createOneCompany();

        // action
        $response = $this->getJson(route('companies.index'))->json('data');

        // assertion
        $this->assertGreaterThan(0, count($response));
        $this->assertEquals($this->company->name, $response[0]['name']);
        $this->assertDatabaseHas('companies', $this->company->toArray());
    }

    /**
     * Test retrieving a company by ID.
     *
     * @return void
     */
    public function testRetrieveCompany()
    {
        // preparation
        $this->company = $this->createOneCompany();

        // action
        $response = $this->getJson(route('companies.show', $this->company->id))
        ->assertOk()
        ->json('data');

        // assertion
        $this->assertEquals($this->company->name, $response['name']);

    }

    /**
     * Test updating a company.
     *
     * @return void
     */
    public function testUpdateCompany()
    {
        // preparation
        $data = Company::factory()->make();
        $this->company = $this->createOneCompany();

        // action
        $this->putJson(route('companies.update', $this->company->id), [
            'name' => $data->name,
            ])
            ->assertOk();

       // assertion
       $this->assertDatabaseHas('companies', ['id' => $this->company->id, 'name' => $data->name]);
    }

    /**
     * Test deleting a company.
     *
     * @return void
     */
    public function testDeleteCompany()
    {
        // preparation
        $this->company = $this->createOneCompany();

        // action
        $this->deleteJson(route('companies.destroy', $this->company->id))
              ->assertOk();

        // action
        $this->assertDatabaseMissing('companies', ['id' => $this->company->id]);
    }
}