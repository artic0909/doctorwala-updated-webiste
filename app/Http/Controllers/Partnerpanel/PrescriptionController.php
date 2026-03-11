<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index($encryptedId)
    {
        return view('partnerpanel.make-prescription', compact('encryptedId'));
    }
}
