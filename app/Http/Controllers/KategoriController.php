<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->sortby == 'selisih') {
            $data = Kategori::where('nama', 'like', '%' . $request->q . '%')
                ->withCount('transaksi')
                ->withSum('transaksi:pemasukan as total_pemasukan')
                ->withSum('transaksi:pengeluaran as total_pengeluaran')
                ->orderBy(DB::raw("`total_pemasukan` - `total_pengeluaran`"), $request->sortbydesc)
                ->paginate($request->per_page);
        } else {
            $data = Kategori::where('nama', 'like', '%' . $request->q . '%')
                ->withCount('transaksi')
                ->withSum('transaksi:pemasukan as total_pemasukan')
                ->withSum('transaksi:pengeluaran as total_pengeluaran')
                ->orderBy($request->sortby, $request->sortbydesc)
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
        $kategori = new Kategori();
        $kategori->nama = $request->get('nama');
        $kategori->keterangan = $request->get('keterangan');
        $kategori->save();

        if (!$kategori->save()) {
            return response()->json([
                'status' => 'GAGAL'
            ], 500);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $kategori,
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
            ->whereHas('kategori', function ($q) use ($id) {
                return $q->where('id', '=', $id);
            })
            ->where('keterangan', 'like', '%' . $request->q . '%')
            ->orderBy($request->sortby, $request->sortbydesc)
            ->paginate($request->per_page);

        return response()->json([
            'status' => 'OK',
            'data' => $data,
            'kategori' => Kategori::where('id', $id)->first()
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
        $kategori = Kategori::findOrFail($id);
        $kategori->nama = $request->nama;
        $kategori->keterangan = $request->keterangan;
        $kategori->save();

        if (!$kategori->save()) {
            return response()->json([
                'status' => 'GAGAL'
            ], 500);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $kategori,
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
        if (!Kategori::find($id)->delete()) {
            return response()->json([
                'status' => 'GAGAL'
            ], 500);
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function all() {
        return response()->json([
            'status' => 'OK',
            'data' => Kategori::all()
        ]);
    }
}
