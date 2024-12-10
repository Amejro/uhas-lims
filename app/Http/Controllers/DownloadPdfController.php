<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\SampleTest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadPdfController extends Controller
{
    public function download(Sample $record)
    {
        dd($record);

        $sampleTest = SampleTest::where('sample_id', $record->id)->get();
        // dd($sampleTest[0]->test_result);

        // $data = [
        //     [
        //         'quantity' => 1,
        //         'description' => '1 Year Subscription',
        //         'price' => '129.00'
        //     ]
        // ];

        $pdf = Pdf::loadView('reports.pdf', ['result' => $sampleTest[0]->test_result]);

        return $pdf->download();

    }
}
