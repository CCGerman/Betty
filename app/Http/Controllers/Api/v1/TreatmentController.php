<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\UploaderHelper;
use App\Http\Controllers\Controller;
use App\Models\Billable;
use App\Models\Image;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treatments = Treatment::all();
        
        foreach($treatments as &$treatment){
            $treatment->getInfo();
        }

        return response()->json([
            'data' => $treatments
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

        $treatment = new Treatment($request->post());
        $treatment->save();

        $billable = new Billable($request->post());
        $billable->billable_id = $treatment->id;
        $billable->billable_type = $treatment->getMorphClass();
        $billable->save();


        $image = $this->uploadImage($request);
        if($image){
            $image->imageable_id = $treatment->id;
            $image->imageable_type = $treatment->getMorphClass();
            $image->save();
        }

        $treatment->getInfo();

        return response()->json([
            'message' => 'Tratamiento añadido con éxito',
            'data' => $treatment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        $treatment->getInfo();

        return response()->json([
            'data' => $treatment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        //$validated = $this->validateData($request);

        $treatment->fill($request->post())->save();
        $bill = $treatment->bill;
        $bill->fill($request->post())->save();

        $image = $this->uploadImage($request);
        if($image){
            $image->imageable_id = $treatment->id;
            $image->imageable_type = $treatment->getMorphClass();
            $image->save();
        }

        $treatment->getInfo();

        return response()->json([
            'message' => 'Tratamiento actualizado con éxito',
            'data' => $treatment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        $treatment->bill->delete();
        foreach($treatment->image as $image){
            $image->delete();
        }
        $treatment->delete();

        return response()->json([
            'message' => 'Tratamiento eliminado con éxito'
        ]);
    }


    private function uploadImage(Request $request){

        $file = $request->file('image');

        if($file) {
            $url = UploaderHelper::uploadImage($request->file('image'));
            $image = new Image([
                'url' => $url,
                'description' => $request->post('image_description')
            ]);
            return $image;
        }
    }

    private function validateData(Request $request){
        
        return $request->validate([
            'duration' => 'required|integer|min:0',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'image_description' => 'string'
        ]);
    }
}
