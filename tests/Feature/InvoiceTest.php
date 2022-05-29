<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_should_return_all_the_invoices_when_requesting_all_invoice_endpoint()
    {
        $user = User::find(1);   
        $response = $this->actingAs($user)->get('/api/invoice');
        $response->assertJsonStructure(['data']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_should_return_a_new_invoice_when_creating_requesting_new_invoice_endpoint()
    {
        $user = User::find(1);
        
        $body = [
            'serie' => 'z',
            'client_full_name' => 'Prueba factura 2',
            'client_document' => 'DNICLIENTE',
            'address_1' => 'address1',
            'city' => 'Ibiza',
            'postalcode' => '07800',
            'country' => 'spain',
            'address_2' => 'address2',
            'lines' => [
                [
                'billable_id' => '1',
                'quantity' => '1',
                'discount' => '10'
                ]
            ]
            ];

        $response = $this->actingAs($user)->post('/api/invoice', $body, [
            'Content-Type' => 'multipart/form-data',
            'Accept' => 'application/json',
        ]);

        $invoice = Invoice::with('header', 'payments', 'invoiceLines')->get()->last();

        // @TODO modelo InvoiceLines hacer casting de unity_amount y total_amount a floats con dos decimales.
        // @TODO castings unity_amount. total_amount en test
        // @TODO eliminar campos de Address y añadirlos en el header.


        $response->assertJson([
            'message' => "Factura añadida con éxito",
            'data' => [
                'number' => $invoice->number,
                'serie' => $body['serie'],
                'id' => $invoice->id,
                'total_amount' => $invoice->total_amount,
                'balance' => $invoice->balance,
                'header' => [
                    'client_full_name' => $body['client_full_name'],
                    'client_document' => $body['client_document'],
                    'address_1' => $body['address_1'],
                    'address_2' => $body['address_2'],
                    'country' => $body['country'],
                    'postalcode' => $body['postalcode'],
                    'city' => $body['city'],
                ],
                'invoice_lines' => [
                    [
                        'quantity' => (int)$body['lines'][0]['quantity'],
                        'discount' => (int)$body['lines'][0]['discount'],
                        'unity_amount' => (float)($invoice->invoiceLines[0]->unity_amount),
                        'total_amount' => (float)($invoice->invoiceLines[0]->total_amount)
                    ]
                ],
                'payments' => []
            ]
        ]);
    }
}