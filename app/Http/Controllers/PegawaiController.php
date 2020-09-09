<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('q')) {
            $data = User::where('name', 'LIKE', '%'.$request->get('q').'%')
                ->paginate($request->get('per_page'));
        } else {
            $data = User::paginate($request->get('per_page'));
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
        $user = new User();
        $user->id = $request->npk;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status ? false : true;
        $user->password = Hash::make($request->password);
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $pegawai = User::where('id', $id)->first();

        try {
            $pegawai->status = $request->status;
            $pegawai->role = $request->role;
            $pegawai->save();
        } catch(Throwable $err) {
            return response()->json([
                'status' => 'ERR',
                'msg' => $err
            ], 500);
        }

        return response()->json([
            'status' => 'OK',
            'data' => $pegawai
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
        //
    }
}
