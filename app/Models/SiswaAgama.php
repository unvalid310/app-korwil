<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiswaAgama extends Model
{
    use HasFactory;

    protected $table = 'siswa_agama';
    protected $primaryKey = 'id_siswa';
    protected $keyType = 'int';
    protected $fillable = [
        'id_ta',
        'periode',
        'id_sekolah',
        'type',
        'l',
        'p',
        'warga_negara',
        'agama',
    ];
    public $timestamps = false;

    public function getAll($where = []) {
        $siswa = DB::table('siswa_agama')
        ->select(
            DB::raw(
                    'id_siswa, id_ta, ( SELECT tahun_ajar FROM tahun_ajar WHERE id_ta = siswa_agama.id_ta ) AS tahun_ajar, periode, l, p, type,
                    agama, warga_negara'
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
