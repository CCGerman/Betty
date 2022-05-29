<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\InvoiceHeader;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\InvoiceSerie;
use App\Modules\Address\DTO\AddressDTO;
use App\Modules\Address\Services\AddressService;
use App\Modules\Invoice\Services\InvoiceService;
use GuzzleHttp\Psr7\Header;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{


    private $deleted_invoice_text = 'Compensa la factura';
    protected InvoiceService $invoiceService;
    protected AddressService $addressService;

    public function __construct(InvoiceService $invoiceService, AddressService $addressService){
        $this->invoiceService = $invoiceService;
        $this->addressService = $addressService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('header.address')->get();

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
        $invoice = $this->invoiceService->createInvoice($data['serie']);
        $header = $this->invoiceService->createInvoiceHeader($invoice, $data['client_full_name'], $data['client_document']);
        $addressDTO = new AddressDTO(
            $data['address_1'], $data['address_2'], $data['city'], $data['postalcode'], $data['country']
        );
        $addressable = [
            'id' => $header->id,
            'class' => $header->getMorphClass()
        ];
        $address = $this->addressService->createAddress($addressDTO, $addressable);

        $headerData = [
            'client_full_name' => $header->client_full_name,
            'client_document' => $header->client_document,
            'address_1' => $address->address_1,
            'address_2' => $address->address_2,
            'country' => $address->country,
            'postalcode' => $address->postalcode,
            'city' => $address->city,
        ];

        $invoiceAmount = 0;

        // @todo desacoplar en su propio servicio 
        foreach($data['lines'] as $lineData){
            $lineData['invoice_id'] = $invoice->id;
            $line = new InvoiceLine($lineData);
            $line->updateData();
            $line->save();
            $invoiceAmount += $line->total_amount;
        }

        $invoice->total_amount = $invoiceAmount;
        $invoice->balance = $invoiceAmount;
        $invoice->save();

        //$invoice->address = $address;
        $invoice->getData();
        unset($invoice->header);
        $invoice->header = $headerData;

        return response()->json([
            'message' => 'Factura añadida con éxito',
            'data' => $invoice
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
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
    public function destroy(Invoice $invoice)
    {
        $invoice->getData();

        if(!$invoice->deleted_on){
            $deletedInvoice = new Invoice();
            $deletedInvoice->client_id = $invoice->client_id;
            $deletedInvoice->serie = $invoice->serie;
            $deletedInvoice->number = InvoiceSerie::where('serie', $invoice->serie)->first()->getNumber();
            $deletedInvoice->note = $this->deleted_invoice_text.': '.$invoice->number.'.';
            $deletedInvoice->save();

            $total_amount = 0;

            $header = new InvoiceHeader([
                'client_full_name' => $invoice->header->client_full_name,
                'client_document' => $invoice->header->client_document,
                'invoice_id' => $deletedInvoice->id
            ]);
            $header->save();

            foreach($invoice->invoiceLines as $line){
                $deletedLine = new InvoiceLine();
                $deletedLine->quantity = -1*$line->quantity;
                $deletedLine->discount = $line->discount;
                $deletedLine->billable_id = $line->billable_id;
                $deletedLine->unity_amount = $line->unity_amount;
                $deletedLine->total_amount = -1*$line->total_amount;
                $deletedLine->invoice_id = $deletedInvoice->id;
                //$deletedLine->serie = $deletedInvoice->serie;
                //$deletedLine->number = $deletedInvoice->number;
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
            'client_full_name' => 'required|string',
            'client_document' => 'required|string|min:4|max:25',
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
