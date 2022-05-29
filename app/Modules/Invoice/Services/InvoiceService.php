<?php

namespace App\Modules\Invoice\Services;


use App\Models\Invoice;
use App\Models\InvoiceHeader;
use App\Models\InvoiceSerie;



class InvoiceService {
        
    public function createInvoice(string $serie): Invoice
    {
        $number = InvoiceSerie::where('serie', $serie)->first()->getNumber();
        $invoice = new Invoice([
            'number' => $number,
            'serie' => $serie
        ]);
        $invoice->save();

        return $invoice;
    }

    public function createInvoiceHeader(Invoice $invoice, string $clientFullName, string $clientDocument): InvoiceHeader
    {
        $header = new InvoiceHeader([
            'client_full_name' => $clientFullName,
            'client_document' => $clientDocument,
            'invoice_id' => $invoice->id
        ]);
        $header->invoice_id = $invoice->id;
        $header->save();
        
        return $header;
    }
}
