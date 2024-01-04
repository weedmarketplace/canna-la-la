<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings(){
        $general = Settings::where('key','global_settings')->first()->value;//find(2)->value;
        $general = json_decode($general);
        
        $data = Settings::where('key','social_links')->first()->value;
        $data = json_decode($data);

        $taxes = Settings::where('key','taxes')->first()->value;
        $taxes = json_decode($taxes);
        
        view()->share('menu', 'settings');
        view()->share('general', $general);
        view()->share('data', $data);
        view()->share('taxes', $taxes);

        return view('admin.settings');
    }
    public function updateSettingsGeneral(){
        $data = request()->validate([
            'email'=>'string|required|email',
            'phone'=>'string|required',
        ]);
        $row = Settings::where('key','global_settings')->first();
        $row->update([
            "value"=>$data
        ]);
        return json_encode(array('status' => 1));
    }
    public function updateSettingsTax(Request $request){
        $validator = \Validator::make($request->all(), [
            'sales_tax'   => 'nullable|int|between:0,100',
            'excise_tax'   => 'nullable|int|between:0,100',
            'delivery_fee' => 'nullable|numeric',
            'minimum_order' => 'nullable|numeric',
        ]);

        if ($validator->fails())return response()->json(['status'=>0,'errors'=>$validator->errors()->first()]);
        
        $data = request()->all();

        $row = Settings::where('key','taxes')->first();
        $row ->update(['value'=>$data]);

        return json_encode(array('status' => 1));
    }
    public function updateSettings(){
        $data=request()->validate([
            'facebook'   => 'string|nullable',
            'twitter'   => 'string|nullable',
            'instagram'      => 'string|nullable',
            'pinterest'   => 'string|nullable',
        ]);

        $row = Settings::where('key','social_links')->first();
        $row ->update(['value'=>$data]);

        return json_encode(array('status' => 1));
    }
}
