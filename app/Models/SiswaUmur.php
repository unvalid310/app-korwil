<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiswaUmur extends Model
{
    use HasFactory;

    protected $table = 'siswa_umur';
    protected $primaryKey = 'id_siswa';
    protected $keyType = 'int';
    protected $fillable = [
        'id_ta',
        'periode',
        'id_kelas',
        'id_sekolah',
        'u5',
        'u6',
        'u7',
        'u8',
        'u9',
        'u10',
        'u11',
        'u12',
        'u13',
    ];
    public $timestamps = false;

    public function getAll($where = []) {
        $siswa = DB::table('siswa_umur')
        ->select(
            DB::raw(
                    'id_siswa, id_kelas, ( SELECT kelas FROM kelas WHERE id_kelas = siswa_umur.id_kelas AND id_ta = siswa_umur.id_ta ) AS kelas,
                    ( SELECT alias FROM kelas WHERE id_kelas = siswa_umur.id_kelas AND id_ta = siswa_umur.id_ta ) AS alias, siswa_umur.id_ta,
                    ( SELECT tahun_ajar FROM tahun_ajar WHERE id_ta = siswa_umur.id_ta ) AS tahun_ajar, periode, u5, u6, u7, u8, u9, u10, u11, u12, u13'
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
