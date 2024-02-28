<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjar;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaAgama;
use App\Models\SiswaUmur;

class SiswaController extends Controller
{
    //
    protected $type =['awal', 'keluar', 'masuk', 'akhir'];
    protected $warga_negara =['wni', 'wna'];
    protected $usia = ['5', '6', '7', '8', '9', '10', '11', '12', '13'];
    protected $agama = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'LAINNYA'];

    public function __construct()
    {
        $this->middleware('permission:view siswa', ['only' => ['index']]);
    }

    public function index() {
        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();

        return view('pages.siswa.total-siswa')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function umur() {
        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();

        return view('pages.siswa.umur-siswa')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function agama() {
        $tahun_ajar = TahunAjar::orderBy('tahun_ajar', 'desc')->get();

        return view('pages.siswa.agama-siswa')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function filter(Request $request) {
        $data = [];
        $index = 0;
        $type = $this->type;
        $warga_negara = $this->warga_negara;
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $siswa = Siswa::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah])->get();
        $kelas = Kelas::where(['id_ta' => $id_ta, 'id_sekolah' => $id_sekolah])->orderBy('alias', 'asc')->get();

        if(count($siswa) == 0) {
            return redirect()->to('/siswa')->with([
                    'errorSiswa' => 'Data Tahun Ajar dan Periode tidak ada',
                    'kelas' => $kelas,
                    'id_ta' => $id_ta,
                    'periode' => $periode
                ]
            );
        } else {
            foreach ($type as $key => $value) {
                # code...
                foreach ($warga_negara as $i => $wA) {
                    # code...
                    $data_kelas = [];
                    foreach ($kelas as $iK => $kelas_) {
                        # code...
                        $siswa = Siswa::getAll(['id_ta' =>$id_ta, 'periode'=> $periode, 'type' => $type[$key], 'id_kelas' => $kelas_->id_kelas, 'id_sekolah' => $id_sekolah, 'warga_negara' => $warga_negara[$i]]);
                        foreach ($siswa as $iSiswa => $vSiswa);
                        array_push($data_kelas, ['l'=>$vSiswa->l, 'p' => $vSiswa->p]);
                    }
                    $data[$index] = $data_kelas;
                    $index++;
                }
                continue;
            }

            return redirect()->to('/siswa')->with([
                'kelas' => $kelas,
                'id_ta' => $id_ta,
                'periode' => $periode,
                'siswa' => $data
            ]);
        }
    }

    public function filter_umur(Request $request) {
        $data = [];
        $index = 0;
        $usia = $this->usia;
        $warga_negara = $this->warga_negara;
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $siswa = SiswaUmur::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah])->get();
        $kelas = Kelas::where(['id_ta' => $id_ta, 'id_sekolah' => $id_sekolah])->orderBy('alias', 'asc')->get();

        if(count($siswa) == 0) {
            return redirect()->to('/siswa/umur')->with([
                    'errorSiswa' => 'Data Tahun Ajar dan Periode tidak ada',
                    'kelas' => $kelas,
                    'id_ta' => $id_ta,
                    'periode' => $periode
                ]
            );
        } else {
            foreach ($kelas as $key => $value) {
                # code...
                $data_kelas = [];
                $siswa = SiswaUmur::getAll(['id_ta' =>$id_ta, 'periode'=> $periode, 'id_kelas' => $value->id_kelas, 'id_sekolah' => $id_sekolah]);
                foreach ($siswa as $iSiswa => $vSiswa);

                $data[$value->id_kelas] = [
                    'u5' => $vSiswa->u5,
                    'u6' => $vSiswa->u6,
                    'u7' => $vSiswa->u7,
                    'u8' => $vSiswa->u8,
                    'u9' => $vSiswa->u9,
                    'u10' => $vSiswa->u10,
                    'u11' => $vSiswa->u11,
                    'u12' => $vSiswa->u12,
                    'u13' => $vSiswa->u13
                ];
            }

            return redirect()->to('/siswa/umur')->with([
                'kelas' => $kelas,
                'id_ta' => $id_ta,
                'periode' => $periode,
                'siswa' => $data
            ]);
        }
    }

    public function filter_agama(Request $request) {
        $data = [];
        $index = 0;
        $type = $this->type;
        $agama = $this->agama;
        $warga_negara = $this->warga_negara;
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $siswa = SiswaAgama::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah])->get();

        if(count($siswa) == 0) {
            return redirect()->to('/siswa/agama')->with([
                    'errorSiswa' => 'Data Tahun Ajar dan Periode tidak ada',
                    'id_ta' => $id_ta,
                    'periode' => $periode
                ]
            );
        } else {
            foreach ($type as $key => $value) {
                # code...
                foreach ($warga_negara as $i => $wA) {
                    # code...
                    $data_agama = [];
                    foreach ($agama as $iK => $agama_) {
                        # code...
                        $siswa = SiswaAgama::getAll(['id_ta' =>$id_ta, 'periode'=> $periode, 'type' => $type[$key], 'id_sekolah' => $id_sekolah, 'agama' => $agama_, 'warga_negara' => $warga_negara[$i]]);
                        foreach ($siswa as $iSiswa => $vSiswa);
                        // dd($vSiswa);
                        array_push($data_agama, ['l'=>$vSiswa->l, 'p' => $vSiswa->p]);
                    }
                    $data[$index] = $data_agama;
                    $index++;
                }
                continue;
            }

            return redirect()->to('/siswa/agama')->with([
                'id_ta' => $id_ta,
                'periode' => $periode,
                'siswa' => $data
            ]);
        }
    }

    public function add() {
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        return view('pages.siswa.tambah-siswa')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function add_umur() {
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        return view('pages.siswa.tambah-umur-siswa')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function add_agama() {
        $tahun_ajar = TahunAjar::orderBy('id_ta', 'desc')->get();
        return view('pages.siswa.tambah-agama-siswa')->with(['tahun_ajar' => $tahun_ajar]);
    }

    public function proses(Request $request) {
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $siswa = Siswa::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah])->get();
        $kelas = Kelas::where(['id_ta' => $id_ta, 'id_sekolah' => $id_sekolah])->orderBy('alias', 'asc')->get();
        if(count($siswa) > 0) {
            return redirect()->to('/siswa/tambah')->with([
                    'errorSiswa' => 'Data Tahun Ajar dan Periode sudah ada',
                    'id_ta' => $id_ta,
                    'periode' => $periode
                ]
            );
        } else {
            return redirect()->to('/siswa/tambah')->with([
                'kelas' => $kelas,
                'id_ta' => $id_ta,
                'periode' => $periode
            ]);
        }
    }

    public function proses_umur(Request $request) {
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $siswa = SiswaUmur::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah])->get();
        $kelas = Kelas::where(['id_ta' => $id_ta, 'id_sekolah' => $id_sekolah])->orderBy('alias', 'asc')->get();
        if(count($siswa) > 0) {
            return redirect()->to('/siswa/tambah-umur')->with([
                    'errorSiswa' => 'Data Tahun Ajar dan Periode sudah ada',
                    'id_ta' => $id_ta,
                    'periode' => $periode
                ]
            );
        } else {
            return redirect()->to('/siswa/tambah-umur')->with([
                'kelas' => $kelas,
                'id_ta' => $id_ta,
                'periode' => $periode
            ]);
        }
    }

    public function proses_agama(Request $request) {
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $id_sekolah = session()->get('id_sekolah');

        $siswa = SiswaAgama::where(['id_ta' => $id_ta, 'periode' => $periode, 'id_sekolah' => $id_sekolah])->get();
        $kelas = Kelas::where(['id_ta' => $id_ta, 'id_sekolah' => $id_sekolah])->orderBy('alias', 'asc')->get();
        if(count($siswa) > 0) {
            return redirect()->to('/siswa/tambah-agama')->with([
                    'errorSiswa' => 'Data Tahun Ajar dan Periode sudah ada',
                    'id_ta' => $id_ta,
                    'periode' => $periode
                ]
            );
        } else {
            return redirect()->to('/siswa/tambah-agama')->with([
                'kelas' => $kelas,
                'id_ta' => $id_ta,
                'periode' => $periode
            ]);
        }
    }

    public function update() {}

    public function save(Request $request) {

        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $data_total = [];
        $type = $request->type;
        $id_sekolah = session()->get('id_sekolah');
        $id_ta = $request->id_ta;
        $periode = $request->periode;

        foreach ($type as $key => $value) {
            # code...
            $data_total[$key] = [
                'id_ta' => $id_ta,
                'periode' => $periode,
                'id_kelas' => $request->id_kelas[$key],
                'id_sekolah' => $id_sekolah,
                'type' => $type[$key],
                'l' => $request->l[$key],
                'p' => $request->p[$key],
                'warga_negara' => $request->warga_negara[$key],
            ];
        }

        $siswa = Siswa::insert($data_total);

        if ($siswa) {
            # code...
            $response['message'] = 'Data berhasil disimpan.';
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Data gagal disimpan.';
            return response()->json($response, 200);
        }
    }

    public function save_umur(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $data_umur = [];
        $id_sekolah = session()->get('id_sekolah');
        $id_ta = $request->id_ta;
        $periode = $request->periode;

        $kelas = Kelas::where(['id_ta' => $id_ta])->orderBy('alias', 'asc')->get();

        foreach ($kelas as $key => $value) {
            # code...
            $data_umur[$key] = [
                'id_ta' => $id_ta,
                'periode' => $periode,
                'id_kelas' => $value->id_kelas,
                'id_sekolah' => $id_sekolah,
                'u5' => $request->u5[$key],
                'u6' => $request->u6[$key],
                'u7' => $request->u7[$key],
                'u8' => $request->u8[$key],
                'u9' => $request->u9[$key],
                'u10' => $request->u10[$key],
                'u11' => $request->u11[$key],
                'u12' => $request->u12[$key],
                'u13' => $request->u13[$key],
            ];
        }

        $siswa = SiswaUmur::insert($data_umur);

        if ($siswa) {
            # code...
            $response['message'] = 'Data berhasil disimpan.';
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Data gagal disimpan.';
            return response()->json($response, 200);
        }
    }

    public function save_agama(Request $request) {
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $data_agama = [];
        $id_sekolah = session()->get('id_sekolah');
        $id_ta = $request->id_ta;
        $periode = $request->periode;
        $type_a = $request->type;

        $kelas = Kelas::where(['id_ta' => $id_ta])->orderBy('alias', 'asc')->get();

        foreach ($type_a as $key => $value) {
            # code...
            $data_agama[$key] = [
                'id_ta' => $id_ta,
                'periode' => $periode,
                'id_sekolah' => $id_sekolah,
                'type' => $request->type[$key],
                'l' => $request->l[$key],
                'p' => $request->p[$key],
                'warga_negara' => $request->warga_negara[$key],
                'agama' => $request->agama[$key],
            ];
        }
        $siswa = SiswaAgama::insert($data_agama);

        if ($siswa) {
            # code...
            $response['message'] = 'Data berhasil disimpan.';
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Data gagal disimpan.';
            return response()->json($response, 200);
        }
    }

    public function edit(Request $request) {}
    public function delete(Request $request) {}
}
