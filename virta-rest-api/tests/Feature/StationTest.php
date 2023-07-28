<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StationTest extends TestCase
{
    use RefreshDatabase;
    private $company;
    private $station;
    /**
     * Test creating a new station.
     *
     * @return void
     */
    public function testCreateStation()
    {
        // preparation
        $this->company = $this->createOneCompany();
        $this->station = $this->createOneStation([
            'company_id' => $this->company->id,
        ]);

        // action
        $response = $this->getJson(route('stations.index'))->json('data');

        // assertion
        $this->assertGreaterThan(0, count($response));
        $this->assertEquals($this->station->name, $response[0]['name']);
        $this->assertDatabaseHas('stations', $this->station->toArray());
    }

    /**
     * Test retrieving a station by ID.
     *
     * @return void
     */
    public function testRetrieveStation()
    {
        // preparation
        $this->company = $this->createOneCompany();
        $this->station = $this->createOneStation([
            'company_id' => $this->company->id,
        ]);

       // action
       $response = $this->getJson(route('stations.show', $this->station->id))
       ->assertOk()
       ->json('data');

       // assertion
       $this->assertEquals($this->station->name, $response['name']);
    }

    /**
     * Test updating a station.
     *
     * @return void
     */
    public function testUpdateStation()
    {
        // preparation
        $this->company = $this->createOneCompany();
        $this->station = $this->createOneStation([
            'company_id' => $this->company->id,
        ]);
        $data = Station::factory()->make();
        $data['company_id'] = $this->company->id;

        // action
        $this->putJson(route('stations.update', $this->station->id), $data->toArray())
            ->assertOk();

        // assertion
        $this->assertDatabaseHas('stations', $data->toArray());
    }

    /**
     * Test deleting a station.
     *
     * @return void
     */
    public function testDeleteStation()
    {
        // preparation
        $this->company = $this->createOneCompany();
        $this->station = $this->createOneStation([
            'company_id' => $this->company->id,
        ]);

        // action
        $this->deleteJson(route('stations.destroy', $this->station->id))
        ->assertOk();

        // action
        $this->assertDatabaseMissing('stations', ['id' => $this->station->id]);
    }
}