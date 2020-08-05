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
            $data = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $request->get('tahun'));
        } else if ($jenis == 'bulan') {
            $data = Transaksi::where('dompet_id', $dompet)->whereMonth('tanggal_transaksi', $request->get('bulan'));
        } else if ($jenis == 'tanggal') {
            $tanggal_mulai = date($request->get('tanggal_mulai'));
            $tanggal_akhir = date($request->get('tanggal_akhir'));
            $data = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir]);
        }

        return $data->orderBy('tanggal_transaksi', 'ASC')->get();
    }

    public function pdf(Request $request)
    {
        $jenis = $request->get('jenis');
        $dompet = $request->get('dompet');

        if ($jenis == 'tahun') {
            $tahun = $request->get('tahun');
            $data = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $tahun);
            $pemasukan = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $tahun)->sum('pemasukan');
            $pengeluaran = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $tahun)->sum('pengeluaran');

            $pdf = PDF::loadView('laporan', [
                'data' => $data->orderBy('tanggal_transaksi', 'ASC')->get(),
                'tahun' => $tahun,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'total' => $pemasukan - $pengeluaran
            ]);
        } else if ($jenis == 'bulan') {
            $bulan = $request->get('bulan');
            $data = Transaksi::where('dompet_id', $dompet)->whereMonth('tanggal_transaksi', $bulan);
            $pemasukan = Transaksi::where('dompet_id', $dompet)->whereMonth('tanggal_transaksi', $bulan)->sum('pemasukan');
            $pengeluaran = Transaksi::where('dompet_id', $dompet)->whereMonth('tanggal_transaksi', $bulan)->sum('pengeluaran');

            $pdf = PDF::loadView('laporan', [
                'data' => $data->orderBy('tanggal_transaksi', 'ASC')->get(),
                'bulan' => $bulan,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'total' => $pemasukan - $pengeluaran
            ]);
        } else if ($jenis == 'tanggal') {
            $tanggal_mulai = date($request->get('tanggal_mulai'));
            $tanggal_akhir = date($request->get('tanggal_akhir'));
            $data = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir]);
            $pemasukan = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->sum('pemasukan');
            $pengeluaran = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->sum('pengeluaran');

            $pdf = PDF::loadView('laporan', [
                'data' => $data->orderBy('tanggal_transaksi', 'ASC')->get(),
                'mulai' => $tanggal_mulai,
                'akhir' => $tanggal_akhir,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'total' => $pemasukan - $pengeluaran
            ]);
        }
        return $pdf->stream('data.pdf');
    }
}
