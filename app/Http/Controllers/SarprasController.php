<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\Sarpras;
use App\Models\Sekolah;
use App\Exports\ReportSarpras;

class SarprasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view sarpras', ['only' => ['index']]);
        $this->middleware('permission:rekap sarpras', ['only' => ['report']]);
    }

    public function index(Request $request) {
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();
        $sarpras = Sarpras::getAll(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah]);

        return view('pages.sarpras.daftar-sarpras')->with(['tahun_ajar' => $tahun_ajar, 'id_ta' => $id_ta, 'periode' => $periode, 'sarpras' => $sarpras]);
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_sarpras = $request->id_sarpras;
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $ruang = $request->ruang;
        $id_sekolah = session()->get('id_sekolah');

        if($id_sarpras) {
            $data = [
                'id_sekolah' => $id_sekolah,
                'id_ta' => $id_ta,
                'periode' => $periode,
                'ruang' => $request->ruang,
                'kondisi' => $request->kondisi,
                'jumlah' => $request->jumlah,
            ];

            $update = Sarpras::where(['id_sarpras' => $id_sarpras])->update($data);
            if($update) {
                $response['message'] = 'Data berhasil diubah';
                return response()->json($response, 200);
            }else {
                $response['success'] = false;
                $response['message'] = 'Data gagal diubah';
                return response()->json($response, 200);
            }
        } else {
            $sarpras = Sarpras::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah, 'ruang' => $ruang])->get();
            if(count($sarpras) > 0) {
                $response['success'] = false;
                $response['message'] = 'Data sudah ada';

                return response()->json($response, 200);
            } else {
                $data = [
                    'id_sekolah' => $id_sekolah,
                    'id_ta' => $id_ta,
                    'periode' => $periode,
                    'ruang' => $request->ruang,
                    'kondisi' => $request->kondisi,
                    'jumlah' => $request->jumlah,
                ];

                $save = Sarpras::insert($data);

                if($save) {
                    $response['message'] = 'Data berhasil disimpan';
                    return response()->json($response, 200);
                }else {
                    $response['success'] = false;
                    $response['message'] = 'Data gagal disimpan';
                    return response()->json($response, 200);
                }
            }
        }

    }

    public function delete(Request $request) {
        $id_sarpras = $request->id_sarpras;

        $delete = Sarpras::where(['id_sarpras' => $id_sarpras])
            ->first()
            ->delete();

        if ($delete) {
            return response()
                ->json(
                    [
                        'success' => true,
                        'message' => 'Data berhasil dihapus.',
                    ],
                    200,
                );
        } else {
            return response()
                ->json(
                    [
                        'success' => false,
                        'message' => 'Data gagal dihapus.',
                    ],
                    200,
                );
        }
    }

    public function report(Request $request) {
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = $request->id_sekolah;

        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();
        $sarpras = Sarpras::getAll(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah]);
        $sekolah = Sekolah::orderBy('id_sekolah', 'desc')->get();

        return view('pages.sarpras.rekap-sarpras')->with(['tahun_ajar' => $tahun_ajar, 'id_ta' => $id_ta, 'periode' => $periode, 'sarpras' => $sarpras, 'id_sek' => $id_sekolah, 'sekolah' => $sekolah]);
    }

    public function cetak($id_ta, $periode, $id_sekolah) {
        $tahun_ajar = TahunAjar::where(['id_ta' => $id_ta])->first();
        return (new ReportSarpras($id_ta, $periode, $id_sekolah))
            ->download('Rekap sarpras TA ' . str_replace('/', '-', $tahun_ajar->tahun_ajar) . ' periode ' . periode($periode) . '.xlsx');
    }
}
