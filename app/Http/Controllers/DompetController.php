<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use Illuminate\Http\Request;

class DompetController extends Controller
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
            'data' => Dompet::with('transaksi')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('admin.dompet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dompet = new Dompet();
        $dompet->nama = $request->get('nama');
        $dompet->keterangan = $request->get('keterangan');

        if (!$dompet->save()) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Gagal menyimpam dompet'
            ], 500);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $dompet,
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
        if (!$dompet = Dompet::find($id)) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Dompet tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $dompet,
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
        //return->view('admin.dompet.index');
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
        $dompet = Dompet::find($id);
        $dompet->nama = $request->get('nama');
        $dompet->keterangan = $request->get('keterangan');

        if (!$dompet->save()) {
            return response()->json([
                'status' => 'GAGAL',
                'pesan' => 'Gagal mengubah dompet'
            ], 500);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $dompet,
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
        if (!Dompet::find($id)->delete()) {
            return response()->json([
                'status' => 'GAGAL'
            ], 500);
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }
}
