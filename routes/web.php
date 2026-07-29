<?php

use App\Http\Controllers\SignerController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::patch(
    '/signers/{signer}/toggle-status',
    [SignerController::class, 'toggleStatus']
)->name('signers.toggle-status');
Route::resource('signers', SignerController::class)
    ->only(['index', 'create', 'store', 'edit', 'update']);

Route::get(
    '/documents/{document}/original',
    [DocumentController::class, 'viewOriginal']
)->name('documents.original');

Route::post(
    '/documents/{document}/generate-token',
    [DocumentController::class, 'generateToken']
)->name('documents.generate-token');

Route::get(
    '/verify/{token}',
    [VerificationController::class, 'show']
)->name('verification.show');

Route::get(
    '/documents/{document}/qr-code',
    [DocumentController::class, 'viewQrCode']
)->name('documents.qr-code');

Route::post(
    '/documents/{document}/generate-final-pdf',
    [DocumentController::class, 'generateFinalPdf']
)->name('documents.generate-final-pdf');

Route::get(
    '/documents/{document}/final',
    [DocumentController::class, 'viewFinal']
)->name('documents.final');

Route::post(
    '/documents/{document}/publish',
    [DocumentController::class, 'publish']
)->name('documents.publish');

Route::get(
    '/documents/{document}/revoke',
    [DocumentController::class, 'revokeForm']
)->name('documents.revoke-form');

Route::post(
    '/documents/{document}/revoke',
    [DocumentController::class, 'revoke']
)->name('documents.revoke');

Route::get(
    '/verify-file',
    [DocumentController::class, 'verifyFileForm']
)->name('verify.file.form');

Route::post(
    '/verify-file',
    [DocumentController::class, 'verifyFile']
)->name('verify.file');

Route::get(
    '/documents/{document}/qr-editor',
    [DocumentController::class, 'qrEditor']
)->name('documents.qr-editor');

Route::get(
    '/verify/{token}/download',
    [DocumentController::class, 'downloadVerifiedPdf']
)
    ->name('verify.download');

Route::post(
    '/documents/{document}/qr-position',
    [DocumentController::class, 'saveQrPosition']
)->name('documents.save-qr-position');

Route::resource('documents', DocumentController::class)
    ->only(['index', 'create', 'store', 'show']);
