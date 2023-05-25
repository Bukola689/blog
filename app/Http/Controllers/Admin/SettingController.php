<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Http\Resources\SettingResource;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index($id)
    {
        $setting = Setting::find($id);

        if(!$setting) {
            return response()->json('Setting not found');
        }

        return new SettingResource($setting);
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);

        if(!$setting) {
            return response()->json('Category not found');
        }

        $request->validate([
            'header_logo' => 'required',
            'footer_logo' => 'required',
            'footer_desc' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'youtube' => 'required',
            'about_title' => 'required',
            'about_desc' => 'required',
        ]);

        $setting->header_logo = $request->header_logo;
        $setting->footer_logo  = $request->footer_logo;
        $setting->footer_desc  = $request->footer_desc;
        $setting->email  = $request->email;
        $setting->phone  = $request->phone;
        $setting->address  = $request->address;
        $setting->facebook  = $request->facebook;
        $setting->instagram  = $request->instagram;
        $setting->youtube  = $request->youtube;
        $setting->about_title  = $request->about_title;
        $setting->about_desc  = $request->about_desc;
        $setting->update();

        return response()->json([
            'status' => true,
            'setting' => $setting,
        ]);
    }
}
