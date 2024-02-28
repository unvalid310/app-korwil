<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    protected $keyType = 'int';
    protected $fillable = [
        'id_ta',
        'id_staff',
        'id_sekolah',
        'hari',
        'ket',
    ];
    public $timestamps = false;

    public function getAbsensiHarian($where =[]) {
        $absensi = DB::table('absensi')
        ->select(
            DB::raw(
                    'absensi.id_absensi, absensi.id_ta, absensi.id_staff, (SELECT tahun_ajar.tahun_ajar FROM tahun_ajar WHERE id_ta = absensi.id_ta) AS tahun_ajar,
                    staff.nama, staff.nip, staff.jk, staff.agama, staff.golongan, staff.tmt, staff.tahun, staff.bulan, staff.pendidikan, staff.jurusan, staff.status,
                    absensi.hari, absensi.ket'
                )
        )
        ->leftJoin('staff', 'absensi.id_staff', '=', 'staff.id_staff');

        if (!empty($where)) {
            # code...
            $absensi->where($where);
        }

        $absensi->orderBy('absensi.id_absensi', 'asc');

        return $absensi->get();
    }

    public function getAbsensibulanan($year, $month, $id_sekolah, $id_ta) {
        $absensi = DB::table('absensi')
        ->select(
            DB::raw(
                    'absensi.id_absensi, absensi.id_ta, absensi.id_staff, (SELECT tahun_ajar.tahun_ajar FROM tahun_ajar WHERE id_ta = absensi.id_ta) AS tahun_ajar,
                    staff.nama, staff.nip, staff.jk, staff.agama, staff.golongan, jabatan_staff.jabatan, staff.tmt, staff.tahun, staff.bulan, staff.pendidikan, staff.jurusan, staff.status,
                    absensi.hari, absensi.ket'
                )
        )
        ->leftJoin('staff', 'absensi.id_staff', '=', 'staff.id_staff')
        ->leftJoin('jabatan_staff', 'staff.id_staff', '=', 'jabatan_staff.id_staff');

        $absensi->whereYear('absensi.hari', '=', $year)
        ->whereMonth('absensi.hari', '=', $month)
        ->where(['absensi.id_sekolah' => $id_sekolah, 'absensi.id_ta' => $id_ta]);

        $absensi->orderBy('absensi.id_absensi', 'asc');

        return $absensi->get();
    }
}
