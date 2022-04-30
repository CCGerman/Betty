<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\UploaderHelper;
use App\Http\Controllers\Controller;
use App\Models\Billable;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        foreach($products as &$product){
            $product->getInfo();
        }

        return response()->json([
            'data' => $products
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

        $product = new Product($request->post());
        $product->save();

        $billable = new Billable($request->post());
        $billable->billable_id = $product->id;
        $billable->billable_type = $product->getMorphClass();
        $billable->save();

        $image = $this->uploadImage($request);
        if($image){
            $image->imageable_id = $product->id;
            $image->imageable_type = $product->getMorphClass();
            $image->save();
        }

        $product->getInfo();

        return response()->json([
            'message' => 'Producto añadido con éxito',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->getInfo();

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //$validated = $this->validateData($request);

        $product->fill($request->post())->save();
        $bill = $product->bill;
        $bill->fill($request->post())->save();

        $image = $this->uploadImage($request);
        if($image){
            $image->imageable_id = $product->id;
            $image->imageable_type = $product->getMorphClass();
            $image->save();
        }

        $product->getInfo();


        return response()->json([
            'message' => 'Producto actualizado con éxito',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->bill->delete();
        foreach($product->image as $image){
            $image->delete();
        }
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado con éxito'
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
            'stock' => 'required|integer|min:0',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'image_description' => 'string'
        ]);
    }
}
