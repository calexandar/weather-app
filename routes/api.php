<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather', function (){
    $apiKey= config('services.weatherapi.key');
    $lat = request('lat');
    $lng = request('lng');

    $response = Http::get("http://api.weatherapi.com/v1/forecast.json?key=$apiKey&q=$lat,$lng&days=7&aqi=no&alerts=no");

    return $response->json();
});
