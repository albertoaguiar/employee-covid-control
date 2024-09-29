<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\EmployeeController;

Route::resource('vaccines', VaccineController::class);
Route::resource('employees', EmployeeController::class);
Route::get('/reports/unvaccinated', [EmployeeController::class, 'generateUnvaccinatedReport'])->name('reports.unvaccinated');

Route::get('/', function () {
    return redirect('/vaccines');
});
