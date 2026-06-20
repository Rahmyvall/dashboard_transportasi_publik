<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['id', 'en'])) {
        abort(400);
    }

    session(['app_locale' => $locale]);
    return redirect()->back();
});
Route::get('dashboard',[DashboardController::class,'index']);
