<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view staff', ['only' => ['index']]);
        $this->middleware('permission:profil staff', ['only' => ['profil']]);
        $this->middleware('permission:create staff', ['only' => ['add']]);
        $this->middleware('permission:update staff', ['only' => ['update']]);
        $this->middleware('permission:delete staff', ['only' => ['delete']]);
    }

    public function index() {
        $staff = Staff::where(['id_sekolah' => session()->get('id_sekolah')])->orderBy('id_staff', 'desc')->get();
        return view('pages.staff.daftar-staff')->with(['staff' => $staff]);
    }

    public function add() {
        return view('pages.staff.tambah-staff');
    }

    public function update($id_staff) {
        $staff = Staff::where(['id_staff' => $id_staff])->first();

        return view('pages.staff.update-staff')->with(['staff' => $staff]);
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $nip = $request->nip;
        $staff = Staff::where(['nip' => $nip])->get();
        $data = [
            'id_sekolah' => session()->get('id_sekolah'),
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'agama' => $request->agama,
            'golongan' => $request->golongan,
            'tmt' => $request->tmt,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'pendidikan' => $request->pendidikan,
            'jurusan' => $request->jurusan,
            'status' => $request->status,
        ];

        if(count($staff) > 0) {
            $response['success'] = false;
            $response['message'] = 'Data staff sudah ada.';

            return response()->json($response, 200);
        } else {
            $save = Staff::insert($data);
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

        $id_staff = $request->id_staff;
        $data = [
            'id_sekolah' => session()->get('id_sekolah'),
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'agama' => $request->agama,
            'golongan' => $request->golongan,
            'tmt' => $request->tmt,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'pendidikan' => $request->pendidikan,
            'jurusan' => $request->jurusan,
            'status' => $request->status,
        ];

        $save = Staff::where(['id_staff' => $id_staff])->update($data);

        if($save) {
            $response['message'] = 'Data berhasil diubah.';

            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak dapat menyimpan data.';

            return response()->json($response, 200);
        }
    }

    public function delete(Request $request) {
        $id_staff = $request->id_staff;

        $delete = Staff::where('id_staff', $id_staff)
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
