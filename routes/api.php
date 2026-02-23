<?php

declare(strict_types=1);

use App\Http\Controllers\StorePing;
use Illuminate\Support\Facades\Route;

Route::post('/ping', StorePing::class)->name('pings.store'); // Would use enum for name in production app