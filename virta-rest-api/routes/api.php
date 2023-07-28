<?php
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="VIRTA Companies and Stations API",
 *     description="This API allows you to manage companies and their stations.",
 *     @OA\Contact(
 *         email="support@example.com",
 *         name="API Support Team"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\ChargingStationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('company-test/{company_id}/{latitude}/{longitude}/{radiusInKm}', [CompanyController::class, 'test'])
// ->name('company-test.index');

Route::apiResource('stations', StationController::class)->except(['create', 'edit']);
Route::apiResource('companies', CompanyController::class)->except(['create', 'edit']);
Route::resource('charging-stations', ChargingStationController::class)->only(['index']);