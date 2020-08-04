<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;

class ExportController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('export', ['data' => $data]);
    }

    public function export()
    {
        $data = User::all();
        $pdf = PDF::loadView('export', ['data' => $data]);
        return $pdf->stream('data.pdf');
    }
}
