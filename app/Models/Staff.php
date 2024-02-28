<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';
    protected $primaryKey = 'id_staff';
    protected $keyType = 'int';
    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'agama',
        'golongan',
        'tmt',
        'tahun',
        'bulan',
        'pendidikan',
        'jurusan',
        'status',
    ];
    public $timestamps = false;
}
