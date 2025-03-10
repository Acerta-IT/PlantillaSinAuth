<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', [
            'holidays' => [], // We'll populate this later
            'workingHours' => [
                'start' => '09:00',
                'end' => '18:00'
            ]
        ]);
    }

    public function update(Request $request)
    {
        // We'll implement this later
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
