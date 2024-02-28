<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;

class TahunAjarController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view tahun ajar', ['only' => ['index']]);
    }

    public function index() {
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();

        return view('pages.tahun-ajar.daftar-tahun-ajar')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function save(Request $request) {
        $tahun_ajar = $request->tahun_ajar;
        $periode = $request->periode;

        $ta = TahunAjar::where(['tahun_ajar' => $tahun_ajar])->first();

        if($ta) {
            return redirect()->to('/tahun-ajar')->with('addTAFailed', 'Tahun Ajar sudah ada');
        }

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'periode' => $periode,
        ];

        $save = TahunAjar::insert($data);

        if ($save) {
            # code...
            return redirect()->to('/tahun-ajar')->with('addTASuccess', 'Tahun Ajar berhasil disimpan');
        } else {
            return redirect()->to('/tahun-ajar')->with('addTAFailed', 'Tahun Ajar gagal disimpan');
        }
    }

    public function edit(Request $request) {
        $id_ta = $request->id_ta;
        $tahun_ajar = $request->tahun_ajar;
        $periode = $request->periode;

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'periode' => $periode,
        ];

        $save = TahunAjar::where(['id_ta' => $id_ta])->update($data);

        if ($save) {
            # code...
            return redirect()->to('/tahun-ajar')->with('addTASuccess', 'Tahun Ajar berhasil diubah');
        } else {
            return redirect()->to('/tahun-ajar')->with('addTAFailed', 'Tahun Ajar gagal diubah');
        }
    }

    public function delete(Request $request) {
        $id_ta = $request->id_ta;

        $delete = TahunAjar::where('id_ta', $id_ta)
            ->first()
            ->delete();

        if ($delete) {
            return response()
                ->json(
                    [
                        'success' => true,
                        'message' => 'Data tahun ajar berhasil dihapus.',
                    ],
                    200,
                );
        } else {
            return response()
                ->json(
                    [
                        'success' => false,
                        'message' => 'Data tahun ajar gagal dihapus.',
                    ],
                    200,
                );
        }}
}
