<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

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
            // 'data' => 
            // 'kegiatan' => Kegiatan::find(1),
            // 'transaksi' => Kegiatan::find(1)->transaksi, 
            
            'data' => Kegiatan::find(1)->with('transaksi')->get()
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
            'data' => [
                Kegiatan::find($id)->with('transaksi')->first()
                /* 'kegiatan' => Kegiatan::find($id),
                'transaksi' => Kegiatan::find($id)->transaksi */
            ],
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
