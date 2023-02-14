<?php

use App\Http\Controllers\Api\MMOPL\FareController;
use App\Http\Controllers\Api\Settlement\SettlementController;
use App\Http\Controllers\LogFile\LogController;
use App\Http\Controllers\Callback\callbackController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::post('/get/fare', [FareController::class, 'getFare'])->name('fare');


// SETTLEMENT
Route::middleware(['basic_auth'])->group(function () {
    Route::post('get/settlement/issue', [SettlementController::class, 'getIssueUnsettledData'])->name('settlement.issue');
    Route::post('get/settlement/refund', [SettlementController::class, 'getRefundUnsettledData'])->name('settlement.refund');
    Route::post('set/settlement/issue', [SettlementController::class, 'setIssueUnsettledData'])->name('settlement.post.issue');
    Route::post('set/settlement/refund', [SettlementController::class, 'setRefundUnsettledData'])->name('settlement.post.refund');
});


Route::post('/create/log/{id}',[LogController::class,'CreateLogFile']);

Route::post('/payment/s2s/{id}',[LogController::class,'makeLog']);


//Route::post('/payment/status/{id}',[CallbackController::class,'PaymentCallback']);
