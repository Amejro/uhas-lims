<?php

use App\Http\Controllers\PaymentReceiptController;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadPdfController;

Route::get('/pdf', function () {

    $paymentTemplate = view('pdfs.payment')->render();
    $header = view('pdfs.header')->render();
    $footer = view('pdfs.footer')->render();


    $pdf = Browsershot::html($paymentTemplate)
        ->format('A4')
        ->margins(20, 30, 20, 30)
        ->showBrowserHeaderAndFooter()
        ->headerHtml($header)
        ->footerHtml($footer)
        ->pdf();


    return new Response($pdf, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="example.pdf"',

    ]);

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{record}/pdf', [DownloadPdfController::class, 'download'])->name('samples.pdf.download');

Route::get('/{payment}/receipt', [PaymentReceiptController::class, 'download'])->name('receipt.pdf.download');

// require __DIR__.'/auth.php';
