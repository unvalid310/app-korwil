<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $primaryKey = 'id_sekolah';
    protected $keyType = 'int';
    protected $fillable = [
        'nama_sekolah',
        'npsn_nsss',
        'tanggal_berdiri',
        'alamat',
        'kabupaten',
        'kecamatan',
        'provinsi',
        'status_tanah',
        'luas_tanah',
        'luas_bangunan',
        'luas_pekarangan',
        'luas_kebun',
        'nip_pengawas',
        'nama_pengawas'
    ];
    public $timestamps = false;

    public function getDetailSekolahByAbsensi($where =[]) {
        $sekolah = DB::table('jabatan_staff')
        ->select(
            DB::raw(
                    'sekolah.*, tahun_ajar.tahun_ajar, jabatan_staff.periode,
                    IF(jabatan_staff.jabatan = "KEPALA SEKOLAH",staff.nip,"") as nip_kepala_sekolah,
                    IF(jabatan_staff.jabatan = "KEPALA SEKOLAH",staff.nama,"") as nama_kepala_sekolah,
                    SUM(IF(jabatan_staff.jam_mengajar IS NOT NULL OR jabatan_staff.jam_mengajar <> "-", 1, 0)) as j_guru,
                    SUM(IF(jabatan_staff.jam_mengajar IS NULL AND jabatan_staff.jam_mengajar = "-", 1, 0)) as j_staff'
                )
        )
        ->leftJoin('tahun_ajar', 'jabatan_staff.id_ta', '=', 'tahun_ajar.id_ta')
        ->leftJoin('staff', 'jabatan_staff.id_staff', '=', 'staff.id_staff')
        ->leftJoin('sekolah', 'staff.id_sekolah', '=', 'sekolah.id_sekolah');

        if (!empty($where)) {
            # code...
            $sekolah->where($where);
        }

        $sekolah->groupBy('staff.id_sekolah');

        return $sekolah->get();
    }
}
