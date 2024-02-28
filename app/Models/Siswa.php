<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $keyType = 'int';
    protected $fillable = [
        'id_siswa',
        'id_ta',
        'periode',
        'id_kelas',
        'id_sekolah',
        'type',
        'l',
        'p',
        'warga_negara',
    ];
    public $timestamps = false;

    public function getAll($where = []) {
        $siswa = DB::table('siswa')
        ->select(
            DB::raw(
                    'id_siswa, id_kelas, (SELECT kelas FROM kelas WHERE id_kelas = siswa.id_kelas AND id_ta = siswa.id_ta) AS kelas,
                    (SELECT alias FROM kelas WHERE id_kelas = siswa.id_kelas AND id_ta = siswa.id_ta) AS alias, siswa.id_ta,
                    (SELECT tahun_ajar FROM tahun_ajar WHERE id_ta = siswa.id_ta) AS tahun_ajar, periode, l, p, type, warga_negara'
                )
            );

        if (!empty($where)) {
            # code...
            $siswa->where($where);
        }

        $siswa->orderby('id_siswa', 'asc');

        return $siswa->get();
    }
}
