<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DompetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            if ($request->sortby == 'saldo') {
                $data = Dompet::where('nama', 'like', '%'.$request->q.'%')
                    ->withCount('transaksi')
                    ->withSum(['transaksi:pemasukan as total_pemasukan','transaksi:pengeluaran as total_pengeluaran'])
                    ->orderBy(DB::raw("`total_pemasukan` - `total_pengeluaran`"), $request->sortbydesc)
                    ->paginate($request->get('per_page'));
            } else {
                $data = Dompet::where('nama', 'like', '%'.$request->q.'%')
                    ->withCount('transaksi')
                    ->withSum(['transaksi:pemasukan as total_pemasukan','transaksi:pengeluaran as total_pengeluaran'])
                    ->orderBy($request->sortby, $request->sortbydesc)
                    ->paginate($request->get('per_page'));
            }
        } else {
            $data = DB::select('
                select coalesce(sum(t.pemasukan) - sum(t.pengeluaran), 0) as Saldo, d.id, d.nama
                from dompets d left join transaksis t on d.id = t.dompet_id
                group by d.id, d.nama
            ');
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
    public function show(Request $request, $id)
    {
        $data = Transaksi::with(['dompet', 'kategori', 'pics'])
            ->whereHas('dompet', function($q) use($id) {
                return $q->where('id', '=', $id);
            })
            ->where('keterangan', 'like', '%'.$request->q.'%')
            ->select()->addSelect(DB::raw('(pemasukan - pengeluaran) as selisih'))
            ->orderBy($request->sortby, $request->sortbydesc)
            ->paginate($request->per_page);

        return response()->json([
            'status' => 'OK',
            'data' => $data,
            'dompet' => Dompet::where('id', $id)->first()
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
