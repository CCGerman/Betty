<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        return response()->json([
            'data' => $payments
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
        $this->validateData($request);

        $payment = new Payment($request->post());
        $payment->save();

        $invoice = $payment->invoice;
        $invoice->balance -= $payment->amount;
        $invoice->save();

        $payment->getInfo();

        return response()->json([
            'message' => 'Pago añadido con éxito',
            'data' => $payment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $payment->getInfo();

        return response()->json([
            'data' => $payment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $this->validateData($request);

        $invoice = $payment->invoice;
        $invoice->balance += $payment->amount;
        $invoice->balance -= $request->post()['amount'];
        $invoice->save();

        $payment->fill($request->post());
        $payment->save();

        $payment->getInfo();

        return response()->json([
            'message' => 'Pago editado con éxito',
            'data' => $payment
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;
        $invoice->balance -= $payment->amount;
        $invoice->save();

        $payment->delete();

        return response()->json([
            'message' => 'Pago eliminado con éxito'
        ]);
    }

    private function validateData(Request $request){

        return $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|min:0',
            'number' => 'required|exists:invoices,number',
            'serie' => 'required|exists:invoices,serie',
            'client_id' => 'required|exists:clients,id'
        ]);
    }
}
