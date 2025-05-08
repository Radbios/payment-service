<?php

use App\Auth;
use App\Http\Controllers\PaymentController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("api_auth")->group(function() {
    Route::get("payment", [PaymentController::class, "index"]);
    Route::post("payment", [PaymentController::class, "pay"])->name("pay");
});
