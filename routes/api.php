<?php

use App\Http\Api\Controllers\Activations\CreateActivationController;
use App\Http\Api\Controllers\Activations\DeleteActivationController;
use App\Http\Api\Controllers\Activations\ShowActivationController;
use App\Http\Api\Controllers\Activations\UpdateCurrentVersionController;
use App\Http\Api\Controllers\HandleGitHubWebhookController;
use App\Http\Api\Controllers\PriceController;
use App\Http\Api\Controllers\SatisAuthenticationController;
use App\Http\Api\Controllers\ShowLicenseController;
use App\Http\Api\Controllers\ShowReleaseController;
use App\Http\Controllers\SignedProductLicenseController;
use Illuminate\Support\Facades\Route;

Route::post('satis/authenticate', SatisAuthenticationController::class)->middleware('auth:license-api');

Route::prefix('webhooks')->group(function () {
    Route::post('github', HandleGitHubWebhookController::class);
});

Route::post('activations', CreateActivationController::class);
Route::post('activations/{activation:uuid}/show', ShowActivationController::class);
Route::post('activations/{activation:uuid}/version', UpdateCurrentVersionController::class);
Route::delete('activations/{activation:uuid}', DeleteActivationController::class);

Route::get('price/{purchasable}/{countryCode}', PriceController::class);

Route::get('license/{license:key}', ShowLicenseController::class);
