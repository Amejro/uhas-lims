<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;

class PaymentReceiptController extends Controller
{
    public function download(Request $request)
    {
        $id = explode('/', $request->path())[0];

        $payment = Payment::find((int) $id);

        $sample = Sample::find($payment->sample_id);
        $tests = $sample->tests()->get();
        $producer = $sample->producer()->first();


        $data = [
            'payment' => $payment,
            'sample' => $sample,
            'tests' => $tests,
            'producer' => $producer
        ];

        $encode_data = json_encode($data);

        $receipt_data = json_decode($encode_data);

        // dd($receipt_data);




        // dd($payments->paymentRecords()->get());


        // "total_amount" => 1200
        // "amount_paid" => 1200
        // "serial_code" => "ITAM/CA/007/12/24"
        // "balance_due" => 0
        // "status" => "paid"
        // "sample_id" => 8
        // "user_id" => 1
        // "created_at" => "2024-12-09 01:05:56"
        // "updated_at" => "2024-12-09 23:30:11"

        $paymentTemplate = view('pdfs.payment', ['receipt_data' => $receipt_data])->render();
        $header = view('pdfs.header')->render();
        $footer = view('pdfs.footer')->render();


        $pdf = Browsershot::html($paymentTemplate)
            ->format('A4')
            ->margins(20, 20, 20, 20)
            ->showBrowserHeaderAndFooter()
            ->headerHtml($header)
            ->footerHtml($footer)
            ->pdf();

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename={$payment->serial_code}.pdf",

        ]);


    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
