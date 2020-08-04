<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function load(Request $request)
    {
        $jenis = $request->get('jenis');
        $dompet = $request->get('dompet');
        if ($jenis == 'tahun') {
            $data = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $request->get('tahun'))->get();
        } else if ($jenis == 'bulan') {
            $data = Transaksi::where('dompet_id', $dompet)->whereMonth('tanggal_transaksi', $request->get('bulan'))->get();
        } else if ($jenis == 'tanggal') {
            $tanggal_mulai = date($request->get('tanggal_mulai'));
            $tanggal_akhir = date($request->get('tanggal_akhir'));
            $data = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->get();
            /* $data = Transaksi::whereBetween([
                ['tanggal_transaksi', '>=', ],
                ['tanggal_transaksi', '<=', date($request->get('tanggal_akhir'))],
            ])->get(); */
        }

        return $data;
    }

    public function export()
    {
        $data = User::all();
        $pdf = PDF::loadView('export', ['data' => $data]);
        return $pdf->stream('data.pdf');
    }
}
