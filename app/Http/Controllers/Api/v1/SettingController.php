<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index(){
        $setting = Setting::all();
        return response()->json([
            'setting' => $setting
        ]);
    }

    public function store(Request $request){

        $validated = $this->validateRequest($request);
        $settings = [];
        
        foreach($request->post()['settings'] as $entry){
            $setting = Setting::find($entry['key']);
            
            if($setting)
                $setting->value = $entry['value'];
            else
                $setting = new Setting($entry);
        
            $setting->save();
            $settings[] = $setting;
        }

        return response()->json([
            'message' => 'Parámetro actualizado',
            'setting' => $settings
        ]);

    }

    public function destroy(Request $request){
        foreach($request->post()['settings'] as $entry){
            $setting = Setting::find($entry['key']);
            if($setting)
            $setting->delete();
        }
        return response()->json([
            'message' => 'Parámetros eliminados',
        ]);
    }

    public function validateRequest(Request $request){
        return $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'required|string'
        ]);
    }
}
