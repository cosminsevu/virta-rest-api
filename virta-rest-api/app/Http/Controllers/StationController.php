<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Http\Requests\StationRequest;
use App\Http\Resources\StationResource;

class StationController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/stations",
     *     summary="Get a list of stations",
     *     tags={"Stations"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     * )
     */
    public function index()
    {
        $stations = Station::all();

        // Transform the data using the StationResource
        return StationResource::collection($stations);
    }

    /**
     * @OA\Post(
     *     path="/api/stations",
     *     summary="Create a new station",
     *     tags={"Stations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Station Name"),
     *             @OA\Property(property="latitude", type="number", format="float", example=37.7749),
     *             @OA\Property(property="longitude", type="number", format="float", example=-122.4194),
     *             @OA\Property(property="company_id", type="integer", example=1),
     *             @OA\Property(property="address", type="string", example="153 Floreasca Tower"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Station created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StationResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity - Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example="The validation error messages.")
     *         )
     *     ),
     * )
     */
    public function store(StationRequest $request)
    {
        $validatedData = $request->validated();

        // Process the data and save it to the database
        $station = Station::create($validatedData);

        // Transform and return the newly created resource
        return new StationResource($station);
    }

    /**
     * @OA\Get(
     *     path="/api/stations/{station}",
     *     summary="Get a single station",
     *     tags={"Stations"},
     *     @OA\Parameter(
     *         name="station",
     *         in="path",
     *         required=true,
     *         description="The ID of the station",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Station not found"
     *     )
     * )
     */
    public function show(Station $station)
    {
        // Return the single resource using the StationResource
        return new StationResource($station);
    }

    /**
     * @OA\Put(
     *     path="/api/stations/{station}",
     *     summary="Update an existing station",
     *     tags={"Stations"},
     *     @OA\Parameter(
     *         name="station",
     *         in="path",
     *         required=true,
     *         description="The ID of the station",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Updated Station Name"),
     *             @OA\Property(property="latitude", type="number", format="float", example=37.7749),
     *             @OA\Property(property="longitude", type="number", format="float", example=-122.4194),
     *             @OA\Property(property="company_id", type="integer", example=1),
     *             @OA\Property(property="address", type="string", example="Updated Address"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Station updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Station not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity - Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example="The validation error messages.")
     *         )
     *     )
     * )
     */
    public function update(StationRequest $request, Station $station)
    {
        $validatedData = $request->validated();

        // Update the station data and save to the database
        $station->update($validatedData);

        // Return the updated resource using the StationResource
        return new StationResource($station);
    }

    /**
     * @OA\Delete(
     *     path="/api/stations/{station}",
     *     summary="Delete a station",
     *     tags={"Stations"},
     *     @OA\Parameter(
     *         name="station",
     *         in="path",
     *         required=true,
     *         description="The ID of the station",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Station deleted successfully",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Station deleted successfully"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Station not found"
     *     )
     * )
     */
    public function destroy(Station $station)
    {
        // Delete the station from the database
        $station->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Station deleted successfully'], 200);
    }


}