<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezvousController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\SalleDeConsultationController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\EmailController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/type/{type}', [UserController::class, 'getUsersByType']);
//  Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('rendezvous', RendezvousController::class);
    Route::apiResource('specialites', SpecialiteController::class);
    Route::get('/medecins/{medecin_id}/disponibilites', [UserController::class, 'getMedecinDisponibilites']);
    Route::get('/medecins', [UserController::class, 'getMedecins']);
    Route::get('/patients', [UserController::class, 'getPatients']);
    Route::get('/patients/{id}', [UserController::class, 'show']);
    Route::get('/patient-rv/{patientId}', [RendezvousController::class, 'getRendezvousByPatient']);
    Route::post('/medecins', [MedecinController::class, 'store']);
    Route::apiResource('salles-de-consultation', SalleDeConsultationController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/medecin/dashboard', [UserController::class, 'medecinDashboard']);
    Route::get('/medecin/rendezvous', [RendezvousController::class, 'getRendezvousByMedecin']);
    Route::get('/slots/check-availability/{id}', [SlotController::class, 'checkAvailability']);
    Route::get('/slots', [SlotController::class, 'index']);
    Route::get('/slots/medecin/{medecinId}', [SlotController::class, 'getSlotsByMedecin']);
    Route::get('medecin/{id}', [SlotController::class, 'getSlotsByMedecin']);
    Route::post('/slots', [SlotController::class, 'store']);
    Route::get('/slots/check/{id}', [SlotController::class, 'checkAvailability']);
    Route::post('/slots/reserve', [SlotController::class, 'reserveSlot']);
    Route::post('/slots', [SlotController::class, 'addSlot']);
    Route::post('/send-email', [EmailController::class, 'sendEmail']);

   
 

    
//  });

 Route::get('slots', [SlotController::class, 'index']); // Désactive auth
Route::get('/medecins/recherche', [MedecinController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

