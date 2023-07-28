<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/companies",
     *     summary="Get a list of companies",
     *     tags={"Companies"},
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
        $companies = Company::all();

        // Transform the data using the CompanyResource
        return CompanyResource::collection($companies);
    }

    /**
     * @OA\Post(
     *     path="/api/companies",
     *     summary="Create a new company",
     *     tags={"Companies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Company Name"),
     *             @OA\Property(property="parent_company_id", type="integer", default=null),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Company created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CompanyResource")
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
    public function store(CompanyRequest $request)
    {
        $validatedData = $request->validated();

        // Process the data and save it to the database
        $company = Company::create($validatedData);

        // Transform and return the newly created resource
        return new CompanyResource($company);
    }

    /**
     * @OA\Get(
     *     path="/api/companies/{company}",
     *     summary="Get a single company",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="company",
     *         in="path",
     *         required=true,
     *         description="The ID of the company",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CompanyResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found"
     *     )
     * )
     */
    public function show(Company $company)
    {
        // Return the single resource using the CompanyResource
        return new CompanyResource($company);
    }

    /**
     * @OA\Put(
     *     path="/api/companies/{company}",
     *     summary="Update an existing company",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="company",
     *         in="path",
     *         required=true,
     *         description="The ID of the company",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Updated Company Name"),
     *             @OA\Property(property="parent_company_id", type="integer", default=null),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CompanyResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found"
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
    public function update(CompanyRequest $request, Company $company)
    {
        $validatedData = $request->validated();

        // Update the company data and save to the database
        $company->update($validatedData);

        // Return the updated resource using the CompanyResource
        return new CompanyResource($company);
    }

    /**
     * @OA\Delete(
     *     path="/api/companies/{company}",
     *     summary="Delete a company",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="company",
     *         in="path",
     *         required=true,
     *         description="The ID of the company",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company deleted successfully",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Company deleted successfully"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found"
     *     )
     * )
     */
    public function destroy(Company $company)
    {
        // Delete the company from the database
        $company->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Company deleted successfully'], 200);
    }
    
}
