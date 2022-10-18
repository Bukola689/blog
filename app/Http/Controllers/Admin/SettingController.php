<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Http\Resources\SettingResource;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Setting $setting)
    {
        return new SettingResource($setting);
    }

    public function update(Request $request,Setting $setting)
    {
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
