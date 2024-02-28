<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JabatanStaff extends Model
{
    use HasFactory;

    protected $table = 'jabatan_staff';
    protected $primaryKey = 'id_jabatan_staff';
    protected $keyType = 'int';
    protected $fillable = [
        'id_ta',
        'periode',
        'id_staff',
        'jabatan',
        'jam_mengajar',
    ];
    public $timestamps = false;

    public function getAll($where = []) {
        $jabatanStaff = DB::table('jabatan_staff')
        ->select(
            DB::raw(
                    'jabatan_staff.id_jabatan_staff, jabatan_staff.id_ta, tahun_ajar.tahun_ajar, jabatan_staff.periode, jabatan_staff.id_staff,
                    staff.id_sekolah,staff.nip, staff.nama, staff.jk, staff.agama, staff.golongan, staff.tmt, staff.tahun, staff.bulan, staff.pendidikan, staff.jurusan,
                    staff.status, jabatan_staff.jabatan, jabatan_staff.jam_mengajar,
                    ( SELECT kelas.alias FROM kelas WHERE kelas.id_ta = jabatan_staff.id_ta AND kelas.id_staff = staff.id_staff ) AS alias '
                )
        )
        ->leftJoin('tahun_ajar', 'jabatan_staff.id_ta', '=', 'tahun_ajar.id_ta')
        ->leftJoin('staff', 'jabatan_staff.id_staff', '=', 'staff.id_staff')
        ->leftJoin('kelas', 'staff.id_staff', '=', 'kelas.id_staff');

        if (!empty($where)) {
            # code...
            $jabatanStaff->where($where);
        }

        $jabatanStaff->whereRaw('staff.id_sekolah = '.session()->get("id_sekolah").'');
        // $jabatanStaff->groupBy('jabatan_staff.id_jabatan_staff');

        return $jabatanStaff->get();
    }

    public function rekapAbsensiJabatan($where = []) {
        $jabatanStaff = DB::table('jabatan_staff')
        ->select(
            DB::raw(
                "jabatan_staff.id_jabatan_staff, jabatan_staff.id_ta, tahun_ajar.tahun_ajar, jabatan_staff.periode,
                staff.id_staff, staff.nip, staff.nama, staff.jk, staff.agama,
                staff.golongan, SUBSTRING_INDEX( SUBSTRING_INDEX( staff.golongan, '/', - 1 ), '/', 1 ) AS gol, staff.tmt, staff.tahun, staff.bulan,
                staff.pendidikan, staff.jurusan, IF( jabatan_staff.jabatan = 'KEPALA SEKOLAH', '-', jabatan_staff.jabatan ) AS jabatan,
                jabatan_staff.jam_mengajar,
                SUM(
                IF
                    ((
                        SELECT
                        IF
                            ( ket = '1', 1, NULL )
                        FROM
                            absensi
                        WHERE
                            id_ta = jabatan_staff.id_ta
                            AND id_staff = jabatan_staff.id_staff
                            AND MONTH ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-', 1 ), '-',- 1 )
                            AND YEAR ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-',- 1 ), '-', 1 )
                            ) = 1,
                        1,
                        0
                    )
                ) AS h,
                SUM(
                IF
                    ((
                        SELECT
                        IF
                            ( ket = '0', 1, NULL )
                        FROM
                            absensi
                        WHERE
                            id_ta = jabatan_staff.id_ta
                            AND id_staff = jabatan_staff.id_staff
                            AND MONTH ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-', 1 ), '-',- 1 )
                            AND YEAR ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-',- 1 ), '-', 1 )
                            ) = 1,
                        1,
                        0
                    )
                ) AS a,
                SUM(
                IF
                    ((
                        SELECT
                        IF
                            ( ket = '2', 1, NULL )
                        FROM
                            absensi
                        WHERE
                            id_ta = jabatan_staff.id_ta
                            AND id_staff = jabatan_staff.id_staff
                            AND MONTH ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-', 1 ), '-',- 1 )
                            AND YEAR ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-',- 1 ), '-', 1 )
                            ) = 1,
                        1,
                        0
                    )
                ) AS i,
                SUM(
                IF
                    ((
                        SELECT
                        IF
                            ( ket = '3', 1, NULL )
                        FROM
                            absensi
                        WHERE
                            id_staff = jabatan_staff.id_staff
                            AND MONTH ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-', 1 ), '-',- 1 )
                            AND YEAR ( hari ) = SUBSTRING_INDEX( SUBSTRING_INDEX( jabatan_staff.periode, '-',- 1 ), '-', 1 )
                            ) = 1,
                        1,
                        0
                    )
                ) AS s,
                staff.status"
            )
        )
        ->leftJoin('tahun_ajar', 'jabatan_staff.id_ta','=','tahun_ajar.id_ta')
        ->leftJoin('staff', 'jabatan_staff.id_staff', '=', 'staff.id_staff');

        if (!empty($where)) {
            # code...
            $jabatanStaff->where($where);
        }

        $jabatanStaff->groupBy('jabatan_staff.id_staff');

        return $jabatanStaff->get();
    }

    public function countGolongan($where = []) {
        $jabatanStaff = DB::table('jabatan_staff')
        ->select(
            DB::raw(
                "jabatan_staff.id_jabatan_staff,
                SUBSTRING_INDEX( SUBSTRING_INDEX( staff.golongan, ' / ', - 1 ), ' / ', 1 ) AS gol,
                SUM(
                IF
                ( staff.golongan <> '-', 1, 0 )) AS j_gol,
                SUM(
                IF
                ( staff.jk = 'L', 1, 0 )) AS l,
                SUM(
                IF
                ( staff.jk = 'P', 1, 0 )) AS p"
            )
        )
        ->leftJoin('tahun_ajar', 'jabatan_staff.id_ta','=','tahun_ajar.id_ta')
        ->leftJoin('staff', 'jabatan_staff.id_staff', '=', 'staff.id_staff');

        if (!empty($where)) {
            # code...
            $jabatanStaff->where($where);
        }

        $jabatanStaff->groupBy('staff.golongan');

        return $jabatanStaff->get();
    }
}
