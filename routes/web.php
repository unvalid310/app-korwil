<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahunAjarController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\JabatanStaffController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\OperatorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function() {
//     return view('pages.dashboard.dashboard');
// });

Route::get('/login', [AuthController::class, 'auth'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(
    ['middleware' => ['auth']],
    function() {
        Route::get('/', [DashboardController::class, 'index'])->name('/');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('/dashboard');
        Route::get('/tahun-ajar', [TahunAjarController::class, 'index'])->name('/tahun-ajar');

        Route::get('/sekolah', [SekolahController::class, 'index'])->name('/daftar-sekolah');
        Route::get('/profil', [SekolahController::class, 'profil'])->name('/profil-sekolah');
        Route::get('/sekolah/tambah', [SekolahController::class, 'add'])->name('/tambah-sekolah');
        Route::get('/sekolah/update/{id_sekolah}', [SekolahController::class, 'update'])->name('/update-sekolah');

        Route::get('/staff', [StaffController::class, 'index'])->name('/daftar-staff');
        Route::get('/staff/tambah', [StaffController::class, 'add'])->name('/tambah-staff');
        Route::get('/staff/update/{id_staff}', [StaffController::class, 'update'])->name('/update-staff');

        Route::get('/jabatan', [JabatanStaffController::class, 'index'])->name('/daftar-jabatan');
        Route::get('/jabatan/tambah', [JabatanStaffController::class, 'add'])->name('/tambah-jabatan');
        Route::get('/jabatan/update/{id_jabatan_staff}', [JabatanStaffController::class, 'update'])->name('/update-jabatan');

        Route::get('/kelas', [KelasController::class, 'index'])->name('/daftar-kelas');
        Route::get('/kelas/tambah', [KelasController::class, 'add'])->name('/tambah-kelas');
        Route::get('/kelas/update/{id_kelas}', [KelasController::class, 'update'])->name('/update-kelas');

        Route::get('/siswa', [SiswaController::class, 'index'])->name('/daftar-siswa');
        Route::get('/siswa/filter', [SiswaController::class, 'filter']);
        Route::get('/siswa/tambah', [SiswaController::class, 'add'])->name('/tambah-siswa');
        Route::get('/siswa/proses', [SiswaController::class, 'proses']);
        Route::get('/siswa/umur', [SiswaController::class, 'umur'])->name('/umur-siswa');
        Route::get('/siswa/umur/filter', [SiswaController::class, 'filter_umur']);
        Route::get('/siswa/tambah-umur', [SiswaController::class, 'add_umur'])->name('/tambah-umur-siswa');
        Route::get('/siswa/proses-umur', [SiswaController::class, 'proses_umur']);
        Route::get('/siswa/agama', [SiswaController::class, 'agama'])->name('/agama-siswa');
        Route::get('/siswa/agama/filter', [SiswaController::class, 'filter_agama']);
        Route::get('/siswa/tambah-agama', [SiswaController::class, 'add_agama'])->name('/tambah-agama-siswa');
        Route::get('/siswa/proses-agama', [SiswaController::class, 'proses_agama']);
        Route::get('/siswa/update/{id_siswa}', [SiswaController::class, 'update'])->name('/update-siswa');
        Route::get('/rekap/siswa/', [SiswaController::class, 'report'])->name('rekap-siswa');
        Route::get('/rekap/siswa/filter', [SiswaController::class, 'report_filter']);
        Route::get('/rekap/siswa/{id_ta}/{periode}/{id_sekolah}', [SiswaController::class, 'cetak']);

        Route::get('/absensi', [AbsensiController::class, 'index'])->name('/absensi-harian');
        Route::get('/absensi/proses', [AbsensiController::class, 'proses']);
        Route::get('/absensi/bulanan', [AbsensiController::class, 'index_bulanan'])->name('/absensi-bulanan');
        Route::get('/absensi/proses/bulanan', [AbsensiController::class, 'proses_bulanan']);
        Route::get('/rekap/absensi/', [AbsensiController::class, 'report'])->name('rekap-absensi');
        Route::get('/rekap/absensi/filter', [AbsensiController::class, 'report_filter']);
        Route::get('/rekap/absensi/{type}/{id_ta}/{periode}/{id_sekolah}', [AbsensiController::class, 'cetak']);

        Route::get('/sarpras', [SarprasController::class, 'index'])->name('/daftar-sarpras');
        Route::get('/sarpras/rekap', [SarprasController::class, 'report'])->name('/rekap-sarpras');
        Route::get('/sarpras/rekap/cetak/{id_ta}/{periode}/{id_sekolah}', [SarprasController::class, 'cetak']);

        Route::get('/operator', [OperatorController::class, 'index'])->name('/daftar-operator');
        Route::get('/operator/tambah', [OperatorController::class, 'add'])->name('/tambah-operator');
        Route::get('/operator/update/{id_operator}', [OperatorController::class, 'update'])->name('/update-operator');

        Route::post('/tahun-ajar/save', [TahunAjarController::class, 'save']);
        Route::post('/tahun-ajar/edit', [TahunAjarController::class, 'edit']);
        Route::post('/tahun-ajar/delete', [TahunAjarController::class, 'delete']);

        Route::post('/staff/save', [StaffController::class, 'save']);
        Route::post('/staff/edit', [StaffController::class, 'edit']);
        Route::post('/staff/delete', [StaffController::class, 'delete']);

        Route::post('/jabatan/save', [JabatanStaffController::class, 'save']);
        Route::post('/jabatan/edit', [JabatanStaffController::class, 'edit']);
        Route::post('/jabatan/delete', [JabatanStaffController::class, 'delete']);

        Route::post('/kelas/save', [KelasController::class, 'save']);
        Route::post('/kelas/edit', [KelasController::class, 'edit']);
        Route::post('/kelas/delete', [KelasController::class, 'delete']);

        Route::post('/sarpras/save', [SarprasController::class, 'save']);
        Route::post('/sarpras/delete', [SarprasController::class, 'delete']);

        Route::post('/absensi/save', [AbsensiController::class, 'save']);
        Route::post('/absensi/edit', [AbsensiController::class, 'edit']);
        Route::post('/absensi/delete', [AbsensiController::class, 'delete']);

        Route::post('/siswa/save', [SiswaController::class, 'save']);
        Route::post('/siswa/save-umur', [SiswaController::class, 'save_umur']);
        Route::post('/siswa/save-agama', [SiswaController::class, 'save_agama']);
        Route::post('/siswa/edit', [SiswaController::class, 'edit']);
        Route::post('/siswa/delete', [SiswaController::class, 'delete']);

        Route::post('/sekolah/save', [SekolahController::class, 'save']);
        Route::post('/sekolah/edit', [SekolahController::class, 'edit']);
        Route::post('/bangunan/edit', [SekolahController::class, 'bangunan_edit']);
        Route::post('/sekolah/delete', [SekolahController::class, 'delete']);

        Route::post('/operator/save', [OperatorController::class, 'save']);
        Route::post('/operator/edit', [OperatorController::class, 'edit']);
        Route::post('/operator/reset-password', [OperatorController::class, 'reset_password']);
        Route::post('/operator/delete', [OperatorController::class, 'delete']);
    }
);

