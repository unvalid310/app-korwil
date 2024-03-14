<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ToModel;

use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Models\TahunAjar;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaAgama;
use App\Models\SiswaUmur;
use App\Models\Sekolah;

class ReportSiswa extends DefaultValueBinder implements FromView, WithColumnFormatting, ShouldAutoSize, WithCustomValueBinder, WithStyles
{
    use Exportable;

    protected $id_ta;
    protected $periode;
    protected $id_sekolah;

    protected $type =['awal', 'keluar', 'masuk', 'akhir'];
    protected $warga_negara =['wni', 'wna'];
    protected $usia = ['5', '6', '7', '8', '9', '10', '11', '12', '13'];
    protected $agama = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'LAINNYA'];

    public function __construct(string $id_ta, string $periode, String $id_sekolah)
    {
        $this->id_ta = $id_ta;
        $this->periode = $periode;
        $this->id_sekolah = $id_sekolah;
    }

    public function view(): View
    {
        $tanggal = explode('-', $this->periode);
        $ta = TahunAjar::where(['id_ta' => $this->id_ta])->first();
        $header = Sekolah::getDetailSekolahByAbsensi([
            'staff.id_sekolah' => $this->id_sekolah,
            'jabatan_staff.id_ta' => $this->id_ta,
            'jabatan_staff.periode' => $this->periode
        ]);

        foreach ($header as $sekolah);

        $id_ta = $this->id_ta;
        $id_sekolah = $this->id_sekolah;
        $type = $this->type;
        $agama = $this->agama;
        $usia = $this->usia;
        $warga_negara = $this->warga_negara;

        $siswa = Siswa::where(['id_ta' => $id_ta, 'periode' => $this->periode, 'id_sekolah' => $id_sekolah])->get();
        $kelas = Kelas::where(['id_ta' => $id_ta, 'id_sekolah' => $id_sekolah])->orderBy('alias', 'asc')->get();

        $data_siswa = [];
        $index = 0;
        foreach ($type as $key => $value) {
            # code...
            foreach ($warga_negara as $i => $wA) {
                # code...
                $data_kelas = [];
                foreach ($kelas as $iK => $kelas_) {
                    # code...
                    $siswa = Siswa::getAll(['id_ta' =>$id_ta, 'periode'=> $this->periode, 'type' => $type[$key], 'id_kelas' => $kelas_->id_kelas, 'id_sekolah' => $id_sekolah, 'warga_negara' => $warga_negara[$i]]);
                    if(count($siswa) > 0) {
                        foreach ($siswa as $iSiswa => $vSiswa);
                        array_push($data_kelas, ['l'=>$vSiswa->l, 'p' => $vSiswa->p]);
                    }
                }
                $data_siswa[$index] = $data_kelas;
                $index++;
            }
            continue;
        }

        $data = [];
        $index = 0;
        foreach ($type as $key => $value) {
            # code...
            foreach ($warga_negara as $i => $wA) {
                # code...
                $data_agama = [];
                foreach ($agama as $iK => $agama_) {
                    # code...
                    $siswa = SiswaAgama::getAll(['id_ta' =>$id_ta, 'periode'=> $this->periode, 'type' => $type[$key], 'id_sekolah' => $id_sekolah, 'agama' => $agama_, 'warga_negara' => $warga_negara[$i]]);
                    foreach ($siswa as $iSiswa => $vSiswa);
                    array_push($data_agama, ['l'=>$vSiswa->l, 'p' => $vSiswa->p]);
                }
                $data[$index] = $data_agama;
                $index++;
            }
            continue;
        }

        $data_kelas = [];
        foreach ($kelas as $key => $value) {
            # code...
            $siswa = SiswaUmur::getAll(['id_ta' =>$id_ta, 'periode'=> $this->periode, 'id_kelas' => $value->id_kelas, 'id_sekolah' => $id_sekolah]);
            foreach ($siswa as $iSiswa => $vSiswa);

            $data_kelas[$value->id_kelas] = [
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

        return view('rekapsiswa')->with([
            'sekolah' => $sekolah,
            'ta' => $ta,
            'tahun' => (int)$tanggal[1],
            'bulan' => (int)$tanggal[0],
            'kelas' => $kelas,
            'siswa' => $data_siswa,
            'agama_siswa' => $data,
            'usia_siswa' => $data_kelas,
        ]);
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getParent()
            ->getActiveSheet()
            ->getProtection()
            ->setPassword('korwil')
            ->setSheet(true);

        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            2    => ['font' => ['bold' => true, 'size' => 14]],
            3    => ['font' => ['bold' => true, 'size' => 14]],
            9    => ['font' => ['bold' => true, 'size' => 12]],
            10    => ['font' => ['bold' => true, 'size' => 12]],
            11    => ['font' => ['bold' => true, 'size' => 12]],
            24    => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
