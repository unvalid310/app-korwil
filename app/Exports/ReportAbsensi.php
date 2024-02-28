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

use App\Models\JabatanStaff;
use App\Models\Sekolah;

class ReportAbsensi extends DefaultValueBinder implements FromView, WithColumnFormatting, ShouldAutoSize, WithCustomValueBinder, WithStyles
{
    use Exportable;

    protected $id_ta;
    protected $periode;
    protected $id_sekolah;

    public function __construct(string $id_ta, string $periode, String $id_sekolah)
    {
        $this->id_ta = $id_ta;
        $this->periode = $periode;
        $this->id_sekolah = $id_sekolah;
    }

    public function view(): View
    {
        $tanggal = explode('-', $this->periode);
        $golongan = JabatanStaff::countGolongan([
            'staff.id_sekolah' => $this->id_sekolah,
            'jabatan_staff.id_ta' => $this->id_ta,
            'jabatan_staff.periode' => $this->periode
        ]);
        $jabatan = JabatanStaff::rekapAbsensiJabatan([
            'staff.id_sekolah' => $this->id_sekolah,
            'jabatan_staff.id_ta' => $this->id_ta,
            'jabatan_staff.periode' => $this->periode
        ]);
        $header = Sekolah::getDetailSekolahByAbsensi([
            'staff.id_sekolah' => $this->id_sekolah,
            'jabatan_staff.id_ta' => $this->id_ta,
            'jabatan_staff.periode' => $this->periode
        ]);

        foreach ($header as $sekolah);

        return view('rekapabsensi', [
            'tahun' => (int)$tanggal[1],
            'bulan' => (int)$tanggal[0],
            'jabatan' => $jabatan,
            'sekolah' => $sekolah,
            'golongan' => $golongan,
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
            9    => ['font' => ['bold' => true, 'size' => 12]],
            10    => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
