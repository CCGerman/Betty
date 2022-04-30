<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\InvoiceSerie;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    private $deleted_invoice_text = 'Compensa la factura';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();

        return response()->json([
            'data' => $invoices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return response()->json($request->post());

        $this->validateData($request);

        $data = $request->post();
        $number = InvoiceSerie::where('serie', $data['serie'])->first()->getNumber();
        $data['number'] = $number;
        $invoice = new Invoice($data);
        $invoice->save();

        $address = new Address($request->post());
        $address->addressable_id = $invoice->id;
        $address->addressable_type = $invoice->getMorphClass();
        $address->save();
        $invoice->address = $address;

        $invoiceAmount = 0;

        foreach($data['lines'] as $lineData){
            $lineData['serie'] = $invoice->serie;
            $lineData['number'] = $invoice->number;
            $line = new InvoiceLine($lineData);
            $line->updateData();
            $line->save();
            $invoiceAmount += $line->total_amount;
        }

        $invoice->total_amount = $invoiceAmount;
        $invoice->balance = $invoiceAmount;
        $invoice->save();

        $invoice->getData();

        return response()->json([
            'message' => 'Factura añadida con éxito',
            'data' => $invoice
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $number
     * @param string $serie
     * @return \Illuminate\Http\Response
     */
    public function show($serie, $number)
    {
        $invoice = Invoice::where(['number' => $number], ['serie' => $serie])->first();
        $invoice->getData();

        return response()->json([
            'data' => $invoice
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($serie, $number)
    {
        $invoice = Invoice::where(['number' => $number], ['serie' => $serie])->first();
        $invoice->getData();

        if(!$invoice->deleted_on){
            $deletedInvoice = new Invoice();
            $deletedInvoice->client_id = $invoice->client_id;
            $deletedInvoice->serie = $invoice->serie;
            $deletedInvoice->number = InvoiceSerie::where('serie', $invoice->serie)->first()->getNumber();
            $deletedInvoice->note = $this->deleted_invoice_text.': '.$invoice->number.'.';
            $deletedInvoice->save();

            $total_amount = 0;

            foreach($invoice->invoiceLines as $line){
                $deletedLine = new InvoiceLine();
                $deletedLine->quantity = -1*$line->quantity;
                $deletedLine->discount = $line->discount;
                $deletedLine->billable_id = $line->billable_id;
                $deletedLine->unity_amount = $line->unity_amount;
                $deletedLine->total_amount = -1*$line->total_amount;
                $deletedLine->serie = $deletedInvoice->serie;
                $deletedLine->number = $deletedInvoice->number;
                $deletedLine->save();

                $total_amount += $deletedLine->total_amount;
            }

            $invoice->deleted_on = $deletedInvoice->number;
            $invoice->save();

            $deletedInvoice->total_amount = $total_amount;
            $deletedInvoice->balance = $total_amount;
            $deletedInvoice->save();

            $deletedInvoice->getData();

            return response()->json([
                'message' => 'Factura rectificativa generada.',
                'data' => $deletedInvoice
            ]);
        } else {
            $deletedInvoice = Invoice::where(['number' => $invoice->deleted_on], ['serie' => $invoice->serie])->first();
            $deletedInvoice->getData();
            return response()->json([
                'message' => 'Error. Factura ya retrocedida.',
                'data' => $deletedInvoice
            ]);
        }
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'serie' => 'required|exists:invoice_series,serie',
            'client_id' => [
                'exists:clients,id',
                Rule::requiredIf(
                    InvoiceSerie::where('serie', $request
                        ->all()['serie'])
                        ->first()->simplified == false
                ),
            ],
            'address_1' => 'required|string',
            'address_2' => 'string',
            'city' => 'required|string|max:50',
            'postalcode' => 'required|string|max:15',
            'country' => 'required|string|max:50',
            'lines' => 'array',
            'lines.*.billable_id' => 'required|exists:billables,id',
            'lines.*.quantity' => 'required',
            'lines.*.discount' => 'required|min:0|max:100'
        ]);
    }
}
