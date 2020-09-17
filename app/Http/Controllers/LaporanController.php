<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\Dompet;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function load(Request $request)
    {
        $jenis = $request->get('jenis');
        $dompet = $request->get('dompet');
        
        $kategori = [];

        if ($request->get('kategori') !== NULL){
            $kategori = explode(",", $request->get('kategori'));
            $query = '
                SELECT 
                    t.id id, 
                    t.tanggal_transaksi tanggal_transaksi, 
                    t.keterangan keterangan, 
                    t.pemasukan pemasukan, 
                    t.pengeluaran pengeluaran, 
                    t.dompet_id dompet_id, 
                    t.user_id user_id, 
                    t.terverifikasi terverifikasi, 
                    t.link link

                FROM transaksis t inner join 
                    (kategori_transaksis kt inner join 
                    kategoris k on k.id = kt.kategori_id) on t.id = kt.transaksi_id
                
                WHERE k.id IN('.$request->get('kategori').')
            ';

            if ($jenis == 'tahun') {
                $tahun = $request->get('tahun');
                $query = $query." AND YEAR(t.tanggal_transaksi) = $tahun";
            } else if ($jenis == 'tanggal') {
                $tanggal_mulai = date($request->get('tanggal_mulai'));
                $tanggal_akhir = date($request->get('tanggal_akhir'));
                $query = $query." AND t.tanggal_transaksi BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
                // $query = $query.' AND t.tanggal_transaksi BETWEEN '.$tanggal_mulai.' AND '.$tanggal_akhir.'';
            }
            if ($dompet != 0) {
                $query = $query." AND t.dompet_id = $dompet";
            }

            $query = $query.' ORDER BY t.tanggal_transaksi ASC';
            $transaksi_kategori = DB::select($query);
            // dd($query);
            $data = $transaksi_kategori;

            // $data = ['saya','kamu'];
            
            // dd($data);
            return $data;
        }
        
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
            if ($dompet != 0){
                $data = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir]);
            } else {
                $data = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir]);
            }
        }

        return $data->orderBy('tanggal_transaksi', 'ASC')->get();
    }

    public function pdf(Request $request)
    {
        $jenis = $request->get('jenis');
        $dompet = $request->get('dompet');
        $tanggal_mulai = "";
        $tanggal_akhir = "";
        $tahun = "";
        $pemasukan = 0;
        $pengeluaran = 0;
        $kategori = [];

        ////////////////////////////////////////////////////////////////////////////
        if ($request->get('kategori') !== NULL){
            $kategori = explode(",", $request->get('kategori'));
            $query = '
                SELECT 
                    t.id id, 
                    t.tanggal_transaksi tanggal_transaksi, 
                    t.keterangan keterangan, 
                    t.pemasukan pemasukan, 
                    t.pengeluaran pengeluaran, 
                    t.dompet_id dompet_id, 
                    t.user_id user_id, 
                    t.terverifikasi terverifikasi, 
                    t.link link

                FROM transaksis t inner join 
                    (kategori_transaksis kt inner join 
                    kategoris k on k.id = kt.kategori_id) on t.id = kt.transaksi_id
                
                WHERE k.id IN('.$request->get('kategori').')
            ';

            if ($jenis == 'tahun') {
                $tahun = $request->get('tahun');
                $query = $query." AND YEAR(t.tanggal_transaksi) = $tahun";
            } else if ($jenis == 'tanggal') {
                $tanggal_mulai = date($request->get('tanggal_mulai'));
                $tanggal_akhir = date($request->get('tanggal_akhir'));
                $query = $query." AND t.tanggal_transaksi BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";
            }
            if ($dompet != 0) {
                $query = $query." AND t.dompet_id = $dompet";
                $dompet = Dompet::find($dompet)->first();
                $dompet = $dompet->nama;
            } else {
                $dompet = "Semua";
            }
            
            $query = $query.' ORDER BY t.tanggal_transaksi ASC';
            $transaksi_kategori = DB::select($query);
            $data = $transaksi_kategori;

            $kategoris = [];
            $temp;
            foreach ($kategori as $idkat) {
                $temp = Kategori::find($idkat);
                $kategoris[] = $temp->nama;
            }
            // dd($temp);
            // dd($temp);
            
            $pdf = PDF::loadView('laporanKategori', [
                'data' => $data,
                'tahun' => $tahun,
                'mulai' => $tanggal_mulai,
                'akhir' => $tanggal_akhir,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'total' => $pemasukan - $pengeluaran,
                'dompet' => $dompet,
                'kategori' => $kategoris
            ]);

            return $pdf->stream('data.pdf');

        }
        ////////////////////////////////////////////////////////////////////////////



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
        } else if ($jenis == 'tanggal') {
            $tanggal_mulai = date($request->get('tanggal_mulai'));
            $tanggal_akhir = date($request->get('tanggal_akhir'));

            if ($dompet != 0){
                // dd(date("Y", $tanggal_mulai));
                $nama_dompet = Dompet::find($dompet)->first();
                $tahun_sebelum = DB::select('
                    SELECT sum(pemasukan)-sum(pengeluaran) transaksi_sebelumnya
                    from transaksis
                    where tanggal_transaksi < "' . $tanggal_mulai . '" AND dompet_id = ' . $dompet . '
                ');

                $data = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir]);
                $pemasukan = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->sum('pemasukan');
                $pengeluaran = Transaksi::where('dompet_id', $dompet)->whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->sum('pengeluaran');
    
                $pdf = PDF::loadView('laporan2', [
                    'mulai' => $tanggal_mulai,
                    'akhir' => $tanggal_akhir,
                    'data' => $data->orderBy('tanggal_transaksi', 'asc')->get(),
                    'tahun' => 0,
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
                    where tanggal_transaksi < "' . $tanggal_mulai . '"
                ');

                $data = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir]);
                $pemasukan = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->sum('pemasukan');
                $pengeluaran = Transaksi::whereBetween('tanggal_transaksi', [$tanggal_mulai, $tanggal_akhir])->sum('pengeluaran');
    
                $pdf = PDF::loadView('laporan2', [
                    'mulai' => $tanggal_mulai,
                    'akhir' => $tanggal_akhir,
                    'data' => $data->orderBy('tanggal_transaksi', 'asc')->get(),
                    'tahun' => 0,
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                    'total' => $pemasukan - $pengeluaran,
                    'dompet' => $nama_dompet,
                    'tahun_sebelum' => $tahun_sebelum,
                ]);
            }
        }
        return $pdf->stream('data.pdf');
    }
}
