<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Dompet;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Bulan
{
    public $value;
    public $text;

    public function __construct($value, $text)
    {
        $this->value = $value;
        $this->text = $text;
    }
}

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'PAJ') {
            $data = Transaksi::with(['dompet', 'kategori', 'pics'])
                ->where(
                    [
                        ['keterangan', 'like', '%' . $request->q . '%'],
                        ['user_id', '=', Auth::user()->id]
                    ]
                )
                ->orderBy($request->sortby, $request->sortbydesc)
                ->paginate($request->per_page);
        } else {
            if ($request->tglMulai) {
                $data = Transaksi::with(['dompet', 'kategori', 'pics'])
                    ->where('keterangan', 'like', '%' . $request->q . '%')
                    ->whereBetween('tanggal_transaksi', [$request->tglMulai, $request->tglAkhir])
                    ->orderBy($request->sortby, $request->sortbydesc)
                    ->paginate($request->per_page);
            } else {
                $data = Transaksi::with(['dompet', 'kategori', 'pics'])
                    ->where('keterangan', 'like', '%' . $request->q . '%')
                    ->orderBy($request->sortby, $request->sortbydesc)
                    ->paginate($request->per_page);
            }
        }

        return response()->json([
            'status' => 'OK',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategoris = [];
        $pics = [];
        $transaksi = new Transaksi();
        $transaksi->tanggal_transaksi = $request->get('tanggal_transaksi');
        $transaksi->keterangan = $request->get('keterangan');
        $transaksi->pemasukan = $request->get('pemasukan');
        $transaksi->pengeluaran = $request->get('pengeluaran');
        $transaksi->terverifikasi = Auth::user()->role == 'Bendahara' ? 1 : 0;
        $transaksi->user_id = Auth::user()->id;
        foreach ($request->kategori as $kategori) {
            array_push($kategoris, $kategori['id']);
        }

        $dompet = Dompet::find($request->get('dompet'));
        $transaksi->dompet()->associate($dompet);

        if (!$transaksi->save()) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Gagal menambah transaksi'
            ], 500);
        }
        $transaksi->kategori()->sync($kategoris, false);

        if ($request->pics) {
            foreach ($request->pics as $pic) {
                array_push($pics, $pic['id']);
            }
            $transaksi->pics()->sync($pics, false);
        }

        if ($request->get('kegiatan')) {
            if (!$kegiatan = Kegiatan::find($request->get('kegiatan'))) {
                return response()->json([
                    'status' => 'GAGAL',
                    'pesan' => 'Kegiatan tidak ditemukan'
                ], 500);
            }

            $transaksi->kegiatan()->sync($kegiatan, false);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $transaksi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'OK',
            'data' => Transaksi::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->tanggal_transaksi = $request->get('tanggal_transaksi');
        $transaksi->keterangan = $request->get('keterangan');
        $transaksi->pemasukan = $request->get('pemasukan');
        $transaksi->pengeluaran = $request->get('pengeluaran');
        $transaksi->keterangan = $request->get('keterangan');

        $dompet = Dompet::find($request->get('dompet'));
        $transaksi->dompet()->associate($dompet);

        $kategori = Kategori::find($request->get('kategori'));
        $transaksi->kategori()->sync($kategori, false);
        foreach ($request->pics as $pic) {
            $pics = User::find($pic['id']);
            $transaksi->pics()->sync($pics, false);
        }

        if ($request->get('kegiatan')) {
            if (!$kegiatan = Kegiatan::find($request->get('kegiatan'))) {
                return response()->json([
                    'status' => 'GAGAL',
                    'pesan' => 'Kegiatan tidak ditemukan'
                ], 500);
            }

            $transaksi->kegiatan()->sync($kegiatan, false);
        }

        if (!$transaksi->save()) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Gagal mengubah transaksi'
            ], 500);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $transaksi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Transaksi::find($id)->delete()) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Gagal menghapus transaksi'
            ], 500);
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function verifikasi(Request $request, $id)
    {
        $transaksi = Transaksi::where('id', $request->id)->first();
        $transaksi->terverifikasi = $request->terverifikasi;
        $transaksi->save();
    }

    public function addAktivitas(Request $request)
    {
        $kegiatan = Kegiatan::where('id', $request->get('kegiatan_id'))->first();
        $transaksi = Transaksi::where('id', $request->get('transaksi_id'))->first();

        if (!$kegiatan->transaksi()->sync($transaksi, false)) {
            return response()->json([
                'status' => 'GAGAL'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'kegiatan' => $kegiatan,
            'transaksi' => $transaksi,
        ]);
    }

    public function addAktivitasPilih(Request $request)
    {
        $kegiatan = Kegiatan::where('id', $request->kegiatan)->first();
        $transaksis = $request->transaksi;

        try {
            $kegiatan->transaksi()->sync($transaksis, false);
        } catch (Throwable $err) {
            return response()->json([
                'status' => 'ERR',
                'msg' => $err
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'data' => [
                'kegiatan' => $kegiatan,
                'transaksi' => $transaksis
            ]
        ]);
    }

    public function tanggalTransaksi()
    {
        $data = Transaksi::all();
        $tahun = [];
        $bulan = [];
        foreach ($data as $trans) {
            $tgl = strtotime($trans->tanggal_transaksi);
            array_push($tahun, date('Y', $tgl));
            array_push($bulan, new Bulan(date('m', $tgl), date('F', $tgl)));
        }
        return response()->json([
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    public function all(Request $request)
    {
        $transaksi = Transaksi::orderBy('tanggal_transaksi', 'DESC')->get();
        $kegiatan_transaksi = Kegiatan::with('transaksi')->where('id', $request->id)->first();

        return response()->json([
            'status' => 'OK',
            'data' => $transaksi->diff($kegiatan_transaksi->transaksi)
        ]);
    }
}
