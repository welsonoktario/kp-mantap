<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* $data = DB::select(
            'select k.id id, k.pic pic, k.keterangan keterangan, (sum(t.pemasukan)-sum(t.pengeluaran)) total, count(t.id) jumlah
            from kegiatans k left join (kegiatan_transaksis kt inner join transaksis t on kt.transaksi_id = t.id) on k.id = kt.kegiatan_id
            group by k.id'
        ); */
        if ($request->has('q')) {
            $data = Kegiatan::where('keterangan', 'like', '%'.$request->q.'%')
                ->orderBy($request->sortby, $request->sortbydesc)
                ->withCount('transaksi')
                ->withSum(['transaksi:pemasukan as total_pemasukan', 'transaksi:pengeluaran as total_pengeluaran'])
                ->paginate($request->per_page);
        } else {
            $data = Kegiatan::withCount('transaksi')
                ->withSum(['transaksi:pemasukan as total_pemasukan', 'transaksi:pengeluaran as total_pengeluaran'])
                ->paginate($request->per_page);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $data
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
    public function show(Request $request, $id)
    {
        $data = Transaksi::with(['dompet', 'kategori', 'pics'])
                ->whereHas('kegiatan', function($q) use($id) {
                    return $q->where('id', '=', $id);
                })
                ->where('keterangan', 'like', '%'.$request->q.'%')
                ->orderBy($request->sortby, $request->sortbydesc)
                ->paginate($request->per_page);

        return response()->json([
            'status' => 'OK',
            'data' => $data,
            'kegiatan' => Kegiatan::where('id', $id)->first()
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
