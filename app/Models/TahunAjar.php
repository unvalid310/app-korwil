<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TahunAjar extends Model
{
    use HasFactory;

     protected $table = 'tahun_ajar';
    protected $primaryKey = 'id_ta';
    protected $keyType = 'int';
    protected $fillable = ['tahun_ajar','periode'];
    public $timestamps = false;
}
