<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class ChargingStationController extends Controller
{
    /**
     * Retrieve charging stations within a certain radius from a given location for a specific company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @OA\Get(
     *     path="/api/charging-stations",
     *     summary="Get charging stations within a certain radius from a given location for a specific company",
     *     tags={"Charging Stations"},
     *     @OA\Parameter(
     *         name="company_id",
     *         in="query",
     *         description="ID of the company to retrieve charging stations for",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         description="Latitude of the location",
     *         required=true,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         description="Longitude of the location",
     *         required=true,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="radiusInKm",
     *         in="query",
     *         description="Radius in kilometers",
     *         required=true,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/StationResource")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity - Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example="The validation error messages.")
     *         ),
     *     ),
     * )
     */
    public function index(Request $request)
    {
        
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radiusInKm' => 'required|numeric',
        ]);

        $company_id = $request->input('company_id');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radiusInKm = $request->input('radiusInKm');

        // $radiusInmeters to use in ST_DISTANCE_SPHERE Function
        $radiusInmeters = $radiusInKm * 1000;

        $company = Company::find($company_id);
        
        if ($company !== null) {
            $stations = $company->getStationsGroupedByLocation($latitude, $longitude, $radiusInmeters);
        } else {
            // Return an empty Collection to simulate an empty result query
            $stations = collect();
        }

        return $stations;
    }
}
