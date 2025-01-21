<?php

use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadPdfController;
use App\Http\Controllers\PaymentReceiptController;
use App\Http\Controllers\RecommendationController;

Route::get('/pdf', function () {

    // $pdf = Pdf::loadView('pdf.invoice', $data);
    $pdf = Pdf::loadHTML(
        '<html>
    <head>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }

            .page-break {
    page-break-after: always;
}

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            Our Code World
        </header>

        <footer>
            Copyright &copy; <?php echo date("Y");?> 
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
           <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1>
        </main>
    </body>
</html>
'
    );
    return $pdf->stream();


    // $paymentTemplate = view('pdfs.payment')->render();
    // $header = view('pdfs.header')->render();
    // $footer = view('pdfs.footer')->render();


    // $pdf = Browsershot::html($paymentTemplate)
    //     ->format('A4')
    //     ->margins(20, 30, 20, 30)
    //     ->showBrowserHeaderAndFooter()
    //     ->headerHtml($header)
    //     ->footerHtml($footer)
    //     ->pdf();


    // return new Response($pdf, 200, [
    //     'Content-Type' => 'application/pdf',
    //     'Content-Disposition' => 'inline; filename="example.pdf"',

    // ]);

});

Route::get('/oops', function () {
    return view('pages.inactive-account');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



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
