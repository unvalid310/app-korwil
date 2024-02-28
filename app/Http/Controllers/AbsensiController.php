<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\Absensi;
use App\Models\Staff;
use App\Models\JabatanStaff;
use App\Models\Sekolah;
use App\Exports\ReportAbsensiBulanan;
use App\Exports\ReportAbsensi;

class AbsensiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view absensi', ['only' => ['index']]);
        $this->middleware('permission:view absensi bulanan', ['only' => ['index_bulanan']]);
        $this->middleware('permission:rekap absen', ['only' => ['report']]);
    }

    public function index() {
        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();
        return view('pages.absensi.absensi-harian')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function index_bulanan() {
        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();
        return view('pages.absensi.absensi-bulanan')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function proses(Request $request) {
        $id_ta = $request->id_ta;
        $tanggal = $request->tanggal;
        $id_sekolah = session()->get('id_sekolah');

        $staff = JabatanStaff::getAll(['jabatan_staff.id_ta' => $id_ta]);
        $absensi = Absensi::getAbsensiHarian(['absensi.id_ta' => $id_ta, 'absensi.id_sekolah' => $id_sekolah]);

        if (count($absensi) > 0) {
            # code...
            return redirect()->to('/absensi')->with([
                'id_ta' => $id_ta,
                'tanggal' => $tanggal,
                'absensi' => $absensi
            ]);
        } else {
            return redirect()->to('/absensi')->with([
                'id_ta' => $id_ta,
                'tanggal' => $tanggal,
                'staff' => $staff
            ]);
        }
    }

    public function proses_bulanan(Request $request) {
        $id_ta = $request->id_ta;
        $tanggal = explode('-', $request->tanggal);
        $id_sekolah = session()->get('id_sekolah');
        $absensi = Absensi::getAbsensibulanan((int)$tanggal[1], (int)$tanggal[0], $id_sekolah, $id_ta);

        if (count($absensi) > 0) {
            # code...
            return redirect()->to('/absensi/bulanan')->with([
                'id_ta' => $id_ta,
                'tanggal' => $request->tanggal,
                'absensi' => $absensi
            ]);
        } else {
            return redirect()->to('/absensi/bulanan')->with([
                'absensiError' => 'TIdak ada data absensi bulanan.',
                'id_ta' => $id_ta,
                'tanggal' => $request->tanggal,
            ]);
        }
    }

    public function save(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $id_absensi = $request->id_absensi;
        $id_ta = $request->id_ta;
        $id_sekolah = session()->get('id_sekolah');
        $hari = $request->tanggal;
        $id_staff = $request->id_staff;
        $ket = $request->ket;

        if(empty($id_absensi)) {
            foreach ($id_staff as $key => $value) {
                # code...
                $data[$key] = [
                    'id_ta' => $id_ta,
                    'id_staff' => $id_staff[$key],
                    'id_sekolah' => $id_sekolah,
                    'hari' => $hari,
                    'ket' => $ket[$key],
                ];
            }

            $save = Absensi::insert($data);

            if($save) {
                $response['message'] = 'Data berhasil disimpan.';

                return response()->json($response, 200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Tidak dapat menyimpan data.';

                return response()->json($response, 200);
            }
        } else {
            foreach ($id_absensi as $key => $value) {
                # code...
                $data = [
                    'id_ta' => $id_ta,
                    'id_staff' => $id_staff[$key],
                    'id_sekolah' => $id_sekolah,
                    'hari' => $hari,
                    'ket' => $ket[$key],
                ];

                Absensi::where(['id_absensi' => $id_absensi[$key]])->update($data);
            }

            $response['message'] = 'Data berhasil disimpan.';

            return response()->json($response, 200);
        }
    }

    public function report() {
        $sekolah = Sekolah::orderBy('id_sekolah', 'desc')->get();
        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();

        return view('pages.absensi.rekap-absensi')->with(['tahun_ajar' => $tahun_ajar, 'sekolah' => $sekolah]);
    }

    public function report_filter(Request $request) {
        $id_ta = $request->id_ta;
        $tanggal = explode('-', $request->tanggal);
        $id_sekolah = $request->id_sekolah;
        $absensi = Absensi::getAbsensibulanan((int)$tanggal[1], (int)$tanggal[0], $id_sekolah, $id_ta);

        if (count($absensi) > 0) {
            # code...
            return redirect()->to('/rekap/absensi')->with([
                'id_sek' => $id_sekolah,
                'id_ta' => $id_ta,
                'tanggal' => $request->tanggal,
                'absensi' => $absensi
            ]);
        } else {
            return redirect()->to('/rekap/absensi')->with([
                'absensiError' => 'TIdak ada data absensi bulanan.',
                'id_ta' => $id_ta,
                'tanggal' => $request->tanggal,
            ]);
        }
    }

    public function cetak($type, $id_ta, $periode, $id_sekolah) {
        $tahun_ajar = TahunAjar::where(['id_ta' => $id_ta])->first();
        if ($type == 'bulanan') {
            # code...
            return (new ReportAbsensiBulanan($id_ta, $periode, $id_sekolah))
                ->download('Laporan absensi bulanan TA ' . str_replace('/', '-', $tahun_ajar->tahun_ajar) . ' periode ' . periode($periode) . '.xlsx');
        } else {
            return (new ReportAbsensi($id_ta, $periode, $id_sekolah))
                ->download('Rekap absensi TA ' . str_replace('/', '-', $tahun_ajar->tahun_ajar) . ' periode ' . periode($periode) . '.xlsx');
        }

    }
}
