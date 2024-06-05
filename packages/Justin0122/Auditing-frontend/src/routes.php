<?php

use Illuminate\Support\Facades\Route;
use Justin0122\AuditingFrontend\Http\Controllers\AuditTrailController;

Route::group(['namespace' => 'Justin0122\AuditingFrontend\Http\Controllers', 'middleware' => ['web']], function () {
    Route::get('audit-trail', [AuditTrailController::class, 'index'])->name('audit-trail.index');
});
