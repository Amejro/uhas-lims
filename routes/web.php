<?php

use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadPdfController;
use App\Http\Controllers\PaymentReceiptController;
use App\Http\Controllers\RecommendationController;

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



Route::get('/{record}/pdf', [DownloadPdfController::class, 'download'])->name('samples.pdf.download');

Route::get('/{payment}/receipt', [PaymentReceiptController::class, 'download'])->name('receipt.pdf.download');

Route::get('/{record}/recommendations', [RecommendationController::class, 'print'])->name('recommendations');

// Route::get('/mail', function () {
//     // Mail::to('amejro19@gmail.com')->send(new App\Mail\UserCreated('password'));
//     // return new App\Mail\UserCreated('password');
// });

// Route::get('/technicians', function () {

//     $recepients = User::with('role')->whereHas('role', function ($query) {
//         $query->where('code', 'technician')->orWhere('code', 'admin');
//     })->get();

//     return $recepients;
// });

// require __DIR__.'/auth.php';
