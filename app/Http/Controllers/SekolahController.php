<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view sekolah', ['only' => ['index']]);
        $this->middleware('permission:profil sekolah', ['only' => ['profil']]);
        $this->middleware('permission:create sekolah', ['only' => ['add']]);
        $this->middleware('permission:update sekolah', ['only' => ['update']]);
        $this->middleware('permission:delete sekolah', ['only' => ['delete']]);
    }

    public function index() {
        $sekolah = Sekolah::orderBy('id_sekolah', 'desc')->get();
        return view('pages.sekolah.daftar-sekolah')->with(['sekolah' => $sekolah]);
    }

    public function profil() {
        $id_sekolah = session()->get('id_sekolah');
        $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->first();
        return view('pages.sekolah.profil-sekolah')->with(['sekolah' => $sekolah]);
    }

    public function add() {
        return view('pages.sekolah.tambah-sekolah');
    }

    public function update($id_sekolah) {
        $sekolah = Sekolah::where(['id_sekolah' => $id_sekolah])->first();
        return view('pages.sekolah.update-sekolah')->with(['sekolah' => $sekolah]);
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $nama_sekolah = $request->nama_sekolah;
        $sekolah = Sekolah::orWhere('nama_sekolah', 'like', '%' . $nama_sekolah . '%')->get();

        $data = ['nama_sekolah' => $nama_sekolah];
        if(count($sekolah) == 0) {
            $save = Sekolah::insert($data);
            if($save) {
                $response['message'] = 'Data berhasil disimpan.';

                return response()->json($response, 200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Tidak dapat menyimpan data.';

                return response()->json($response, 200);

            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Data sekolah sudah ada.';

            return response()->json($response, 200);
        }
    }

    public function edit(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_sekolah = $request->id_sekolah;
        $nama_sekolah = $request->nama_sekolah;
        $npsn_nsss = $request->npsn_nsss;
        $tanggal_berdiri = $request->tanggal_berdiri;
        $alamat = $request->alamat;
        $kabupaten = $request->kabupaten;
        $kecamatan = $request->kecamatan;
        $provinsi = $request->provinsi;

        $save = Sekolah::where(['id_sekolah' => $id_sekolah])->update([
            'nama_sekolah' => $nama_sekolah,
            'npsn_nsss' => $npsn_nsss,
            'tanggal_berdiri' => $tanggal_berdiri,
            'alamat' => $alamat,
            'kabupaten' => $kabupaten,
            'kecamatan' => $kecamatan,
            'provinsi' => $provinsi,
        ]);

        if($save) {
            $response['success'] = true;
            $response['message'] = 'Data berhasil disimpan.';

            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak dapat menyimpan data.';

            return response()->json($response, 200);
        }
    }

    public function bangunan_edit(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_sekolah = $request->id_sekolah;
        $status_tanah = $request->status_tanah;
        $luas_tanah = $request->luas_tanah;
        $luas_bangunan = $request->luas_bangunan;
        $luas_pekarangan = $request->luas_pekarangan;
        $luas_kebun = $request->luas_kebun;

        $save = Sekolah::where(['id_sekolah' => $id_sekolah])->update([
            'status_tanah' => $status_tanah,
            'luas_tanah' => $luas_tanah,
            'luas_bangunan' => $luas_bangunan,
            'luas_pekarangan' => $luas_pekarangan,
            'luas_kebun' => $luas_kebun,
        ]);

        if($save) {
            $response['success'] = true;
            $response['message'] = 'Data berhasil disimpan.';

            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak dapat menyimpan data.';

            return response()->json($response, 200);
        }
    }

    public function delete(Request $request) {
        $id_sekolah = $request->id_sekolah;

        $delete = Sekolah::where('id_sekolah', $id_sekolah)
            ->first()
            ->delete();

        if ($delete) {
            return response()
                ->json(
                    [
                        'success' => true,
                        'message' => 'Data sekolah berhasil dihapus.',
                    ],
                    200,
                );
        } else {
            return response()
                ->json(
                    [
                        'success' => false,
                        'message' => 'Data sekolah gagal dihapus.',
                    ],
                    200,
                );
        }
    }
}
