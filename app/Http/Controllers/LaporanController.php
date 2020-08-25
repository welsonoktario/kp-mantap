<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Dompet;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function load(Request $request)
    {
        $jenis = $request->get('jenis');
        $dompet = $request->get('dompet');
        if ($jenis == 'tahun') {
            if ($dompet != 0) {
                $data = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $request->get('tahun'));
            } else {
                $data = Transaksi::whereYear('tanggal_transaksi', $request->get('tahun'));
            }
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

            if ($dompet != 0) {

                $nama_dompet = Dompet::find($dompet)->first();

                $tahun_sebelum = DB::select('
                    SELECT sum(pemasukan)-sum(pengeluaran) transaksi_sebelumnya
                    from transaksis
                    where YEAR(tanggal_transaksi) < ' . $tahun . ' AND dompet_id = ' . $dompet . '
                ');

                $data = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $tahun);
                $pemasukan = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $tahun)->sum('pemasukan');
                $pengeluaran = Transaksi::where('dompet_id', $dompet)->whereYear('tanggal_transaksi', $tahun)->sum('pengeluaran');



                $pdf = PDF::loadView('laporan2', [
                    'data' => $data->orderBy('tanggal_transaksi', 'asc')->get(),
                    'tahun' => $tahun,
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                    'total' => $pemasukan - $pengeluaran,
                    'dompet' => $nama_dompet->nama,
                    'tahun_sebelum' => $tahun_sebelum,
                ]);
            } else {
                $nama_dompet = "Semua";
                $tahun_sebelum = DB::select('
                    SELECT sum(pemasukan)-sum(pengeluaran) transaksi_sebelumnya
                    from transaksis
                    where YEAR(tanggal_transaksi) < ' . $tahun . '
                ');

                $data = Transaksi::whereYear('tanggal_transaksi', $tahun);
                $pemasukan = Transaksi::whereYear('tanggal_transaksi', $tahun)->sum('pemasukan');
                $pengeluaran = Transaksi::whereYear('tanggal_transaksi', $tahun)->sum('pengeluaran');


                $pdf = PDF::loadView('laporan2', [
                    'data' => $data->orderBy('tanggal_transaksi', 'asc')->get(),
                    'tahun' => $tahun,
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                    'total' => $pemasukan - $pengeluaran,
                    'dompet' => $nama_dompet,
                    'tahun_sebelum' => $tahun_sebelum
                ]);
            }
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
