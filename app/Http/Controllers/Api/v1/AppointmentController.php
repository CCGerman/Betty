<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Treatment;
use App\Models\Worker;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    //   'show', 'update', 'destroy']);


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all();

        return response()->json([
            'data' => $appointments
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
        $validated = $this->validateData($request);

        $appointment = new Appointment($request->post());
        $appointment->save();

        $appointment->getInfo();

        return response()->json([
            'message' => 'Cita añadida con éxito',
            'data' => $appointment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $appointment->getInfo();

        return response()->json([
            'data' => $appointment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->fill($request->post())->save();

        $appointment->getInfo();

        return response()->json([
            'message' => 'Cita editada con éxito',
            'data' => $appointment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'message' => 'Cita eliminada con éxito'
        ]);
    }


    private function validateData(Request $request){

        return $request->validate([
            'time_start' => 'required|date_format:Y-m-d\TH:i:s|afterorequal:now',
            'time_end' => 'required|date|date_format:Y-m-d\TH:i:s|after:time_start',
            'worker_id' => 'required|exists:workers,id',
            'treatment_id' => 'required|exists:treatments,id',
            'client_id' => 'required|exists:clients,id',
        ]);

    }
}
