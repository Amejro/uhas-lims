<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\SampleTest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;

class DownloadPdfController extends Controller
{
    public function download(Sample $record)
    {



        $tests = $record->tests()->get();



        $producer = $record->producer()->first();
        $dosageForm = $record->dosageForm()->first();



        $data = [

            'sample' => $record,
            'tests' => $tests,
            'producer' => $producer,
            'dosageForm' => $dosageForm

        ];



        $encode_data = json_encode($data);

        $report_data = json_decode($encode_data);



        $reportTemplate = view('reports.pdf', ['report_data' => $report_data])->render();
        $header = view('reports.header')->render();
        $footer = view('reports.footer')->render();

        $pdf = Browsershot::html($reportTemplate)
            ->format('A4')
            ->margins(20, 20, 20, 20)
            ->showBrowserHeaderAndFooter()
            ->headerHtml($header)
            ->footerHtml($footer)
            ->pdf();



        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$record->name}.pdf",

        ]);


        // $sampleTest = SampleTest::where('sample_id', $record->id)->get();
        // // dd($sampleTest[0]->test_result);

        // // $data = [
        // //     [
        // //         'quantity' => 1,
        // //         'description' => '1 Year Subscription',
        // //         'price' => '129.00'
        // //     ]
        // // ];

        // $pdf = Pdf::loadView('reports.pdf', ['result' => $sampleTest[0]->test_result]);

        // return $pdf->download();

    }
}
