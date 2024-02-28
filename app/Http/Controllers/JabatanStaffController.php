<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\JabatanStaff;
use App\Models\Staff;

class JabatanStaffController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view jabatan', ['only' => ['index']]);
        $this->middleware('permission:create jabatan', ['only' => ['add']]);
        $this->middleware('permission:update jabatan', ['only' => ['update']]);
        $this->middleware('permission:delete jabatan', ['only' => ['delete']]);
    }

    public function index(Request $request) {
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        $jabatan = JabatanStaff::getAll();
        // \dd($jabatan);
        return view('pages.jabatan.daftar-jabatan-staff')->with([
            'jabatan' => $jabatan,
            'tahun_ajar' => $tahun_ajar
        ]);
    }

    public function add() {
        $id_sekolah = session()->get('id_sekolah');
        $staff = Staff::where(['id_sekolah' => $id_sekolah])->get();
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();

        return view('pages.jabatan.tambah-jabatan-staff')->with(['staff' => $staff, 'tahun_ajar' => $tahun_ajar]);
    }

    public function update($id_jabatan_staff) {
        $id_sekolah = session()->get('id_sekolah');
        $staff = Staff::where(['id_sekolah' => $id_sekolah])->get();
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        $jabatan = JabatanStaff::where(['id_jabatan_staff' => $id_jabatan_staff])->first();

        // dd($jabatan->id_ta);
        return view('pages.jabatan.update-jabatan-staff')->with(['staff' => $staff, 'tahun_ajar' => $tahun_ajar, 'jabatan_staff' => $jabatan]);
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_staff = $request->id_staff;
        $jabatan = ($request->jabatan == 'LAINNYA') ? $request->jabatan_lainnya : $request->jabatan;
        $jabatan_staff = JabatanStaff::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_staff' => $id_staff])->get();
        $data = [
            'id_ta' => $id_ta,
            'periode' => $periode,
            'id_staff' => $id_staff,
            'jabatan' => $jabatan,
            'jam_mengajar' => $request->jam_mengajar,
        ];

        if(count($jabatan_staff) > 0) {
            $response['success'] = false;
            $response['message'] = 'Data jabatan sudah ada sudah ada.';

            return response()->json($response, 200);
        } else {
            $save = JabatanStaff::insert($data);
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

        $id_jabatan_staff = $request->id_jabatan_staff;
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_staff = $request->id_staff;
        $jabatan = ($request->jabatan == 'LAINNYA') ? $request->jabatan_lainnya : $request->jabatan;
        $jabatan_staff = JabatanStaff::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_staff' => $id_staff])->get();
        $data = [
            'id_ta' => $id_ta,
            'periode' => $periode,
            'id_staff' => $id_staff,
            'jabatan' => $jabatan,
            'jam_mengajar' => $request->jam_mengajar,
        ];

        $save = JabatanStaff::where(['id_jabatan_staff' => $id_jabatan_staff])->update($data);
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

        $id_jabatan_staff = $request->id_jabatan_staff;
        $delete = JabatanStaff::where(['id_jabatan_staff' => $id_jabatan_staff])
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
