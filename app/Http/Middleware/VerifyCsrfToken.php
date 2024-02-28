<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        '/login',
        '/tahun-ajar/save',
        '/tahun-ajar/edit',
        '/tahun-ajar/delete',
        '/sekolah/save',
        '/sekolah/edit',
        '/sekolah/delete',
        '/staff/save',
        '/staff/edit',
        '/staff/delete',
        '/jabatan/save',
        '/jabatan/edit',
        '/jabatan/delete',
        '/kelas/save',
        '/kelas/edit',
        '/kelas/delete',
        '/sarpras/save',
        '/sarpras/delete',
        '/siswa/save',
        '/siswa/save-umur',
        '/siswa/save-agama',
        '/siswa/edit',
        '/siswa/delete',
        '/absensi/save',
        '/absensi/edit',
        '/absensi/delete',
        '/operator/save',
        '/operator/edit',
        '/operator/reset-password',
        '/operator/delete',
    ];
}
