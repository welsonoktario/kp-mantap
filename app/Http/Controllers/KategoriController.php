<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            $data = Kategori::where('nama', 'like', '%'.$request->q.'%')
                ->withCount('transaksi')
                ->orderBy($request->sortby, $request->sortbydesc)
                ->paginate($request->per_page);
        } else {
            $data = Kategori::withCount('transaksi')->get();
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
    public function show($id)
    {
        if (!$kategori = Kategori::where('id', $id)->with(['transaksi', 'transaksi.kategori', 'transaksi.dompet'])->first()) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $kategori,
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
}
