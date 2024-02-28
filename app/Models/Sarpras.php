<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sarpras extends Model
{
    use HasFactory;

    protected $table = 'sarpras';
    protected $primaryKey = 'id_sarpras';
    protected $keyType = 'int';
    protected $fillable = [
        'id_sekolah',
        'id_ta',
        'periode',
        'ruang',
        'kondisi',
        'jumlah',
    ];
    public $timestamps = false;

    public function getAll($where = []) {
        $sarpras = DB::table('sarpras')
        ->select(
            DB::raw(
                    'sarpras.id_sarpras, sarpras.id_ta, (SELECT nama_sekolah FROM sekolah WHERE id_sekolah = sarpras.id_sekolah ) as nama_sekolah, sarpras.id_ta,
                    (SELECT tahun_ajar FROM tahun_ajar WHERE id_ta = sarpras.id_ta) as tahun_ajar, sarpras.periode, sarpras.ruang, sarpras.kondisi, sarpras.jumlah'
                )
            );

        if (!empty($where)) {
            # code...
            $sarpras->where($where);
        }

        $sarpras->orderby('sarpras.id_sarpras', 'desc');

        return $sarpras->get();
    }
}
