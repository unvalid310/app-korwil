<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $keyType = 'int';
    protected $fillable = [
        'id_staff',
        'id_sekolah',
        'id_ta',
        'kelas',
        'alias',
    ];
    public $timestamps = false;

    public function getAll($where = []) {
        $kelas = DB::table('kelas')
        ->select(
            DB::raw(
                    'kelas.id_kelas, kelas.id_staff, staff.nip, staff.nama, staff.jk, staff.agama, staff.golongan, staff.tmt, staff.tahun, staff.bulan,
                    staff.pendidikan, staff.jurusan, staff.status, kelas.id_sekolah, sekolah.nama_sekolah, kelas.id_ta, tahun_ajar.tahun_ajar, kelas.kelas,
                    kelas.alias'
                )
        )
        ->leftJoin('sekolah', 'kelas.id_sekolah', '=', 'sekolah.id_sekolah')
        ->leftJoin('tahun_ajar', 'kelas.id_ta', '=', 'tahun_ajar.id_ta')
        ->leftJoin('staff', 'kelas.id_staff', '=', 'staff.id_staff');

        if (!empty($where)) {
            # code...
            $kelas->where($where);
        }

        // $kelas->orderby('kelas.id_kelas', 'desc');

        return $kelas->get();
    }
}
