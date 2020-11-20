<?php

use App\Http\Middleware\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([ApiKey::class])->group(function () {

    // Patient table route
    Route::post('/signUpPatient', 'PatientController@store');
    Route::post('/getPatientDetailsByUid', 'PatientController@getPatientDetailsByUid');
    
    Route::post('/checkUserExistenceByUid', 'PatientController@checkUserExistenceByUid');


    // Cloud messaging
    Route::post('/testCloudMessage', 'PatientController@testCloudMessage');


    // Blood donor
    Route::post('/addBloodDonor', 'BloodDonorController@addBloodDonor');
    Route::post('/getDonorList', 'BloodDonorController@getDonorList');

    // Blood bank
    Route::post('/getAllBloodBank', 'BloodBankController@getAllBloodBank');
    Route::post('/getBloodBankDataByUid', 'BloodBankController@getBloodBankDataByUid');
    Route::post('/signUpBloodBank', 'BloodBankController@store');
    
    // Blood request controller
    Route::post('/addNewBloodRequest', 'BloodRequestController@addNewBloodRequest');
    Route::post('/getBloodRequest', 'BloodRequestController@index');
    
    //Appointment
    Route::post('/bookNewAppointment', 'AppointmentController@bookNewAppointment');
    Route::post('/getNextAppointment', 'AppointmentController@getNextAppointment');
    Route::post('/getAllAppointment', 'AppointmentController@getAllAppointment');
    Route::post('/getAnAppointmentReports', 'AppointmentController@getAnAppointmentReports');



    //Hospital table route
    Route::post('/getAllHospital', 'HospitalController@index');
    Route::post('/addHospital', 'HospitalController@store');

    //Doctor table route
    Route::post('/signUpDoctor', 'DoctorController@store');
    Route::post('/getDoctorDataByUid', 'DoctorController@getDoctorDataByUid');
    Route::post('/getAllDoctorByHospitalId', 'DoctorController@getAllDoctorByHospitalId');

    //Doctor chamber route
    Route::post('/getDoctorChambersByDoctorId', 'DoctorChamberController@getDoctorChambers');


    // Diagnostic center
    Route::post('/signUpDiagnosticCenter', 'DiagnosticCenterController@store');
    Route::post('/getAllDiagnosticCenter', 'DiagnosticCenterController@index');
    Route::post('/getDiagnosticCenterDataByUid', 'DiagnosticCenterController@getDiagnosticCenterDataByUid');

    // Report
    Route::post('/orderTest', 'ReportController@orderTest');

    // Specialist
    Route::post('/getAllSpecialist', 'SpecialistController@index');
    Route::post('/getAllDoctorBySpecialistId', 'SpecialistController@getAllDoctorBySpecialistId');
});
