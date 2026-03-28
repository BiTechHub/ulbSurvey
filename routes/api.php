<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewApiController;



Route::post('/android-login', [NewApiController::class, 'androidLogin']);



Route::middleware('api.token')->group(function () {

    Route::get('/house-form-data/{type}', [NewApiController::class, 'houseFormData']);
    Route::get('/dashboard-data', [NewApiController::class, 'dashboard_data']);

    Route::post('/gen-house-number', [NewApiController::class, 'genHouseNumber']);

    Route::post('/pending-personal-details', [NewApiController::class, 'getPendingPersonalDetails']);
    Route::post('/rejected-new-house', [NewApiController::class, 'rejected_new_house']);
    Route::post('/rejected-personal-details', [NewApiController::class, 'rejected_personal_details']);
   Route::post('/survey-details', [NewApiController::class, 'notVerified_personal_details']);
  Route::post('/verified-personal-details', [NewApiController::class, 'verified_personal_details']);



  
    Route::get('/personal-details/{id}', [NewApiController::class, 'getPersonalDetails']);
    Route::post('/update-personal-details', [NewApiController::class, 'saveUpdatePersonalDetails']);

    Route::post('/personalDetails_step_1', [NewApiController::class, 'personalDetails_step_1']);
    Route::post('/personalDetails_step_2', [NewApiController::class, 'personalDetails_step_2']);
    Route::post('/personalDetails_step_3', [NewApiController::class, 'personalDetails_step_3']);

});

Route::middleware('api.token')->get('/dropdown-house-details', [NewApiController::class, 'dropdownHouseDetails']);



