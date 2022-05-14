<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::all();

        return response()->json([
            'data' => $workers
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

        $worker = new Worker($request->post());

        $worker->save();
        $address = new Address($request->post());
        $address->addressable_id = $worker->id;
        $address->addressable_type = $worker->getMorphClass();
        $address->save();
        $worker->address = $address;

        return response()->json([
            'message' => 'Trabajador añadido con éxito',
            'data' => $worker
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Worker $worker)
    {

        $worker->address = $worker->address;

        return response()->json([
            'data' => $worker
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        
        //$validated = $this->validateData($request);

        $worker->fill($request->post())->save();
        $address = $worker->address;
        $address->fill($request->post())->save();
        return response()->json([
            'message' => 'Trabajador actualizado con éxito',
            'data' => $address
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();

        return response()->json([
            'message' => 'Trabajador eliminado con éxito'
        ]);

    }

    private function validateData(Request $request){
        return $request->validate([
            'name' => 'required|string|max:50',
            'last_name_1' => 'required|string|max:50',
            'last_name_2' => 'string|max:50',
            'phone' => 'required|string|max:15',
            'note' => 'string',
            'address_1' => 'required|string',
            'address_2' => 'string',
            'city' => 'required|string|max:50',
            'postalcode' => 'required|string|max:15',
            'country' => 'required|string|max:50',
            'email' => 'required|email'
        ]);
    }
}
