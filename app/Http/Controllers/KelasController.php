<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\Staff;
use App\Models\Kelas;

class KelasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view kelas', ['only' => ['index']]);
        $this->middleware('permission:create kelas', ['only' => ['add']]);
        $this->middleware('permission:update kelas', ['only' => ['update']]);
        $this->middleware('permission:delete kelas', ['only' => ['delete']]);
    }

    public function index() {
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        $kelas = Kelas::getAll();

        return view('pages.kelas.daftar-kelas')->with([
            'kelas' => $kelas,
            'tahun_ajar' => $tahun_ajar
        ]);
    }

    public function add() {
        $id_sekolah = session()->get('id_sekolah');
        $staff = Staff::where(['id_sekolah' => $id_sekolah])->get();
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();

        return view('pages.kelas.tambah-kelas')->with(['staff' => $staff, 'tahun_ajar' => $tahun_ajar]);
    }

    public function update($id_kelas) {
        $id_sekolah = session()->get('id_sekolah');
        $staff = Staff::where(['id_sekolah' => $id_sekolah])->get();
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        $kelas = Kelas::where(['id_kelas' => $id_kelas])->first();

        return view('pages.kelas.update-kelas')->with(['staff' => $staff, 'tahun_ajar' => $tahun_ajar, 'kelas' => $kelas]);
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $kelas = $request->kelas;
        $id_ta = $request->id_ta;
        $kelasData = Kelas::where(['kelas' => $kelas, 'id_ta' => $id_ta])->get();
        $data = [
            'id_staff' => $request->id_staff,
            'id_sekolah' => session()->get('id_sekolah'),
            'id_ta' => $id_ta,
            'kelas' => $request->kelas,
            'alias' => $request->alias,
        ];

        if(count($kelasData) > 0) {
            $response['success'] = false;
            $response['message'] = 'Data jabatan sudah ada sudah ada.';

            return response()->json($response, 200);
        } else {
            $save = Kelas::insert($data);
            if($save) {
                $response['message'] = 'Data berhasil disimpan.';

                return response()->json($response, 200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Tidak dapat menyimpan data.';

                return response()->json($response, 200);

            }
        }
    }

    public function edit(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_kelas = $request->id_kelas;
        $data = [
            'id_staff' => $request->id_staff,
            'id_sekolah' => session()->get('id_sekolah'),
            'id_ta' => $request->id_ta,
            'kelas' => $request->kelas,
            'alias' => $request->alias,
        ];

        $save = Kelas::where(['id_kelas' => $id_kelas])->update($data);
        if($save) {
            $response['message'] = 'Data berhasil disimpan.';

            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak dapat menyimpan data.';

            return response()->json($response, 200);

        }
    }

    public function delete(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_kelas = $request->id_kelas;
        $delete = Kelas::where(['id_kelas' => $id_kelas])
            ->first()
            ->delete();

        if ($delete) {
            return response()
                ->json(
                    [
                        'success' => true,
                        'message' => 'Data staff berhasil dihapus.',
                    ],
                    200,
                );
        } else {
            return response()
                ->json(
                    [
                        'success' => false,
                        'message' => 'Data staff gagal dihapus.',
                    ],
                    200,
                );
        }
    }
}
