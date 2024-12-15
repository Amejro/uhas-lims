<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Response;

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




    }
}
