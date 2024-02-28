<?php

if (!function_exists('rupiah')) {
    # code...
    function rupiah($value) {
        return "Rp. ".number_format($value, 0, ',', '.');
    }
}

if (!function_exists('tanggal')) {
    # code...
    function tanggal($tanggal) {
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $date = explode(' ', $tanggal);
        $pecahkan = explode('-', $date[0]);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}

if (!function_exists('tanggal_non_waktu')) {
    # code...
    function tanggal_non_waktu($tanggal) {
        $date = explode(' ', $tanggal);
        $pecahkan = explode('-', $date[0]);
        return $pecahkan[0] . '-' . $pecahkan[1] . '-' . $pecahkan[2];
    }
}

if (!function_exists('cek_sekolah')) {
    # code...
    function cek_sekolah() {
        $id_sekolah = session()->get('id_sekolah');
        $sekolah = App\Models\Sekolah::where(['id_sekolah' => $id_sekolah])->first();

        if(empty($sekolah->npsn_nsss) || empty($sekolah->alamat) || empty($sekolah->kabupaten) || empty($sekolah->kecamatan) || empty($sekolah->provinsi) || empty($sekolah->status_tanah)
        || empty($sekolah->luas_tanah) || empty($sekolah->luas_bangunan) || empty($sekolah->luas_bangunan) || empty($sekolah->luas_pekarangan) || empty($sekolah->luas_kebun)
        ) {
            return false;
        } else {
            return true;
        }

    }
}

if (!function_exists('periode')) {
    # code...
    function periode($periode) {
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $periode);
        return $bulan[(int)$pecahkan[0]] . ' - ' . $pecahkan[1];
    }
}

if (!function_exists('periode_bulan')) {
    # code...
    function periode_bulan($periode) {
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $periode);
        return $bulan[(int)$pecahkan[0]];
    }
}
