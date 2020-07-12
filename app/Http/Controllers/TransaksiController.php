<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'data' => Transaksi::all(),
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
        $transaksi = new Transaksi();
        $transaksi->tanggal_transaksi = $request->get('tanggal');
        $transaksi->keterangan = $request->get('keterangan');
        $transaksi->pemasukan = $request->get('pemasukan');
        $transaksi->pengeluaran = $request->get('pengeluaran');
        $transaksi->user_id = 1;

        $dompet = Dompet::findOrFail($request->get('dompet'));
        $transaksi->dompet()->associate($dompet);

        $kategori = Kategori::findOrFail($request->get('kategori'));
        $transaksi->kategori()->attach($kategori);

        if ($request->get('kegiatan')) {
            $kegiatan = Kegiatan::findOrFail($request->get('kegiatan'));
            $transaksi->kegiatan()->attach($kegiatan);
        }

        if ($transaksi->save()) {
            return response()->json([
                'status' => 'OK',
                'data' => $transaksi
            ]);
        }

        return response()->json([
            'status' => 'GAGAL'
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
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->tanggal_transaksi = $request->get('tanggal');
        $transaksi->keterangan = $request->get('keterangan');
        $transaksi->pemasukan = $request->get('pemasukan');
        $transaksi->pengeluaran = $request->get('pengeluaran');
        $transaksi->keterangan = $request->get('keterangan');

        $dompet = Dompet::findOrFail($request->get('dompet'));
        $transaksi->dompet()->associate($dompet);

        $kategori = Kategori::findOrFail($request->get('kategori'));
        $transaksi->kategori()->sync($kategori, false);

        if ($request->get('kegiatan')) {
            $kegiatan = Kegiatan::findOrFail($request->get('kegiatan'));
            $transaksi->kegiatan()->sync($kegiatan, false);
        }

        if ($transaksi->save()) {
            return response()->json([
                'status' => 'OK',
                'data' => $transaksi
            ]);
        }

        return response()->json([
            'status' => 'GAGAL'
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
        if (Transaksi::destroy($id)) {
            return response()->json([
                'status' => 'OK'
            ]);
        }

        return response()->json([
            'status' => 'GAGAL'
        ]);
    }
}
