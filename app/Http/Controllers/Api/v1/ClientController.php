<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return response()->json([
            'data' => $clients
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

        $client = new Client($request->post());

        $client->save();
        $address = new Address($request->post());
        $address->addressable_id = $client->id;
        $address->addressable_type = $client->getMorphClass();
        $address->save();
        $client->address = $address;

        return response()->json([
            'message' => 'Cliente añadido con éxito',
            'data' => $client
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {

        $client->address = $client->address;

        return response()->json([
            'data' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validated = $this->validateData($request);
        
        $client->fill($request->post())->save();
        return response()->json([
            'message' => 'Cliente actualizado con éxito',
            'data' => $client
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'message' => 'Cliente eliminado con éxito'
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
