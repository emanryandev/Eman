<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TestimonialController;

Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/projects/{id}/clap', [ProjectController::class, 'clap']);
Route::post('/projects/{id}/star', [ProjectController::class, 'star']);
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/subscribe', [SubscriberController::class, 'store']);
Route::post('/testimonials', [TestimonialController::class, 'store']);
