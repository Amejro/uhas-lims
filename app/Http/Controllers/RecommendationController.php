<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;

class RecommendationController extends Controller
{
    public function print(Sample $record)
    {

        $recommendationsTemplate = view('recommendations', ['record' => $record])->render();
        $header = view('reports.header')->render();
        $footer = view('reports.footer')->render();

        $pdf = Browsershot::html($recommendationsTemplate)
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
