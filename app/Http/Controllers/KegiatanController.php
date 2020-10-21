<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            $data = Kegiatan::with('pegawai')
                ->where('keterangan', 'like', '%' . $request->q . '%')
                ->orderBy($request->sortby, $request->sortbydesc)
                ->withCount('transaksi')
                ->withSum(['transaksi:pemasukan as total_pemasukan', 'transaksi:pengeluaran as total_pengeluaran']);
        } else {
            $data = Kegiatan::withCount('transaksi')
                ->withSum(['transaksi:pemasukan as total_pemasukan', 'transaksi:pengeluaran as total_pengeluaran']);
        }

        if ($request->has('dashboard')) {
            $data = $data->havingRaw('total_pemasukan - total_pengeluaran > ?', [0]);
        }


        return response()->json([
            'status' => 'OK',
            'data' => $data->paginate($request->per_page)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pics = [];
        $kegiatan = new Kegiatan();
        $kegiatan->keterangan = $request->get('keterangan');
        foreach ($request->pics as $pic) {
            array_push($pics, $pic['id']);
        }

        if ($kegiatan->save()) {
            $kegiatan->pegawai()->sync($pics);

            return response()->json([
                'status' => 'OK',
                'data' => $kegiatan::with('pegawai'),
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
    public function show(Request $request, $id)
    {
        $data = Transaksi::with(['dompet', 'kategori', 'pics'])
            ->whereHas('kegiatan', function ($q) use ($id) {
                return $q->where('id', '=', $id);
            })
            ->where('keterangan', 'like', '%' . $request->q . '%')
            ->orderBy($request->sortby, $request->sortbydesc)
            ->paginate($request->per_page);

        return response()->json([
            'status' => 'OK',
            'data' => $data,
            'kegiatan' => Kegiatan::where('id', $id)->first()
        ]);
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
        $pics = [];
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->keterangan = $request->get('keterangan');
        foreach ($request->pics as $pic) {
            array_push($pics, $pic['id']);
        }
        $kegiatan->pegawai()->sync($pics);
        $kegiatan->save();

        if ($kegiatan->save()) {
            return response()->json([
                'status' => 'OK',
                'data' => $kegiatan,
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
        if (Kegiatan::destroy($id)) {
            return response()->json([
                'status' => 'OK'
            ]);
        }

        return response()->json([
            'status' => 'GAGAL'
        ]);
    }

    public function detachTransaksi(Request $request, $id)
    {
        $kegiatan = Kegiatan::firstWhere('id', $request->idTrans);
        if (!$kegiatan->transaksi()->detach($id)) {
            return response()->json([
                'status' => 'GAGAL'
            ]);
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }
}
