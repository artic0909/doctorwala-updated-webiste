<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorLog;

class VisitorTrackController extends Controller
{
    public function store(Request $request)
    {
        VisitorLog::create([
            'ip_address'   => $request->ip(),
            'page_url'     => $request->input('page_url'),
            'referrer'     => $request->input('referrer'),
            'browser'      => $request->input('browser'),
            'os'           => $request->input('os'),
            'device_type'  => $request->input('device_type'),
            'screen_size'  => $request->input('screen_size'),
            'language'     => $request->input('language'),
            'timezone'     => $request->input('timezone'),
            'country'      => $request->input('country'),   // from IP lookup
            'city'         => $request->input('city'),      // from IP lookup
        ]);

        return response()->json(['status' => 'ok']);
    }
}