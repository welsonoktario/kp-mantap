<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
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

            'data' => DB::select(
                'select k.id id, k.pic pic, k.keterangan keterangan, (sum(t.pemasukan)-sum(t.pengeluaran)) total, count(t.id) jumlah
                from kegiatans k left join (kegiatan_transaksis kt inner join transaksis t on kt.transaksi_id = t.id) on k.id = kt.kegiatan_id
                group by k.id'
            )
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
        $kegiatan = new Kegiatan();
        $kegiatan->keterangan = $request->get('keterangan');
        $kegiatan->pic = $request->get('pic');

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'OK',
            'data' => Kegiatan::where('id', $id)->with(['transaksi', 'transaksi.dompet', 'transaksi.kategori'])->first(),
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
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->keterangan = $request->get('keterangan');
        $kegiatan->pic = $request->get('pic');
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
}
