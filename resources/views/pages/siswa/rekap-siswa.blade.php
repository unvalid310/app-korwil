@extends('layout')
@php
    $staff = Session::has('staff') ? session::get('staff') : '';
    $kelas = Session::has('kelas') ? session::get('kelas') : '';
    $siswa = Session::has('siswa') ? session::get('siswa') : '';
    $agama_siswa = Session::has('agama') ? session::get('agama') : '';
    $usia_siswa = Session::has('usia') ? session::get('usia') : '';
    $usia = ['5', '6', '7', '8', '9', '10', '11', '12', '13'];
    $agama = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'LAINNYA'];
    $alasan = ['', 'ALASAN', 'SAKIT', 'IZIN', 'ALFA', 'JUMLAH'];
@endphp
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <style>
        table td {
            font-size: 12px
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('assets/js/pages/validation.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/validation.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            var preload = $(".preloader"),
                submit_button = $("#submit_button");

            $('.mydatepicker').datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });

            $("#form-proses-siswa input, #form-proses-siswa select").jqBootstrapValidation();
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Rekap Siswa</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:vo">Rekap Siswa</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Rekap siswa</h4>
                        <h6 class="card-subtitle">Data master siswa.</h6>

                        <div class="m-t-40">
                            <form id="form-proses-siswa" action="{{ URL::to('/rekap/siswa/filter') }}" method="GET"
                                novalidate>
                                <div class="row">
                                    @if (Session::has('siswaError'))
                                        <div class="col-lg-12 col-md-12">
                                            <div class="alert alert-danger">{{ Session::get('absensiError') }}. </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <select class="form-control select-custom" name="id_sekolah" required
                                                    data-validation-required-message="Pilih sekolah">
                                                    <option value="" hidden>-- Sekolah --</option>
                                                    @foreach ($sekolah as $item)
                                                        @if (Session::has('id_sek'))
                                                            @if ($item->id_sekolah == Session::get('id_sek'))
                                                                <option value="{{ $item->id_sekolah }}" selected>
                                                                    {{ $item->nama_sekolah }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $item->id_sekolah }}">
                                                                    {{ $item->nama_sekolah }}
                                                                </option>
                                                            @endif
                                                        @else
                                                            <option value="{{ $item->id_sekolah }}">
                                                                {{ $item->nama_sekolah }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <select class="form-control select-custom" name="id_ta" required
                                                    data-validation-required-message="Pilih tahun ajar">
                                                    <option value="" hidden>-- Tahun Ajar --</option>
                                                    @foreach ($tahun_ajar as $item)
                                                        @if (Session::has('id_ta'))
                                                            @if ($item->id_ta == Session::get('id_ta'))
                                                                <option value="{{ $item->id_ta }}" selected>
                                                                    {{ $item->tahun_ajar }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $item->id_ta }}">
                                                                    {{ $item->tahun_ajar }}
                                                                </option>
                                                            @endif
                                                        @else
                                                            <option value="{{ $item->id_ta }}">
                                                                {{ $item->tahun_ajar }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="text" class="form-control mydatepicker" name="tanggal"
                                                    placeholder="Periode"
                                                    value="{{ Session::get('tanggal') ? Session::get('tanggal') : '' }}"
                                                    required data-validation-required-message="Pilih tanggal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Proses</button>
                                        <a href="{{ route('/daftar-siswa') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>

                            @if (Session::has('kelas'))
                                <div class="table-responsive m-t-40">
                                    <div class="m-b-10">
                                        <a href="{{ URL::to('/rekap/siswa/' . Session::get('id_ta') . '/' . Session::get('tanggal') . '/' . Session::get('id_sek')) }}"
                                            class="btn btn-sm btn-danger"><i class="ti-printer"></i> Cetak
                                            Rekap Siswa</a>
                                    </div>
                                    <table class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <td rowspan="3" align="center" style="vertical-align: middle;">KEADAAN
                                                    SISWA
                                                </td>
                                                <td colspan="{{ count($kelas) * 2 + 2 }}" align="center"
                                                    style="vertical-align: middle;">
                                                    KELAS</td>
                                                <td colspan="{{ count($usia) + 1 }}" align="center"
                                                    style="vertical-align: middle;">
                                                    BERDASARKAN UMUR</td>
                                                <td colspan="{{ count($agama) * 2 + 2 }}" align="center"
                                                    style="vertical-align: middle;">
                                                    BERDASARKAN AGAMA</td>
                                            </tr>
                                            <tr>
                                                @foreach ($kelas as $item)
                                                    <td colspan="2" align="center" style="vertical-align: middle;">
                                                        {{ $item->alias }}
                                                    </td>
                                                @endforeach
                                                <td colspan="2" align="center" style="vertical-align: middle;">JUMLAH
                                                </td>
                                                @foreach ($usia as $item)
                                                    <td rowspan="2" align="center" width="32px"
                                                        style="vertical-align: middle;">
                                                        {{ $item }}
                                                    </td>
                                                @endforeach
                                                <td rowspan="2" align="center" width="32px"
                                                    style="vertical-align: middle;; word-wrap: break-word"">
                                                    LAIN-LAIN
                                                </td>
                                                @foreach ($agama as $item)
                                                    <td colspan="2" align="center" style="vertical-align: middle;">
                                                        {{ $item }}
                                                    </td>
                                                @endforeach
                                                <td colspan="2" align="center" style="vertical-align: middle;">LAIN-LAIN
                                                </td>
                                            </tr>
                                            <tr>
                                                @foreach ($kelas as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">L
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">P
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;">L</td>
                                                <td align="center" width="30px" style="vertical-align: middle;">P</td>
                                                @foreach ($agama as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">L
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">P
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;">L</td>
                                                <td align="center" width="30px" style="vertical-align: middle;">P</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">Awal
                                                    Bulan Lalu</td>
                                                @foreach ($kelas as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNI
                                                </td>
                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[0][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[0][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[0][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[0][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[0][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[0][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNA
                                                </td>
                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[1][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[1][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[1][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[1][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[1][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[1][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>

                                            <tr>
                                                <td align="left" style="vertical-align: middle;">Keluar
                                                    Bulan Ini</td>
                                                @foreach ($kelas as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNI
                                                </td>
                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[2][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[2][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[2][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[2][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[2][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[2][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNA
                                                </td>
                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[3][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[3][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[3][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[3][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[3][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[3][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>

                                            <tr>
                                                <td align="left" style="vertical-align: middle;">Masuk
                                                    Bulan Ini</td>
                                                @foreach ($kelas as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNI
                                                </td>

                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[4][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[4][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[4][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[4][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[4][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[4][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNA
                                                </td>

                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[5][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[5][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[5][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[5][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[5][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[5][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>

                                            <tr>
                                                <td align="left" style="vertical-align: middle;">Murid
                                                    Akhir Bulan Ini</td>
                                                @foreach ($kelas as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $item)
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                    <td align="center" width="30px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNI
                                                </td>

                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[6][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[6][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[6][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[6][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[6][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[6][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="vertical-align: middle;">WNA
                                                </td>
                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[7][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[7][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[7][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $key => $item)
                                                    @if (!empty($agama_siswa[7][$key]))
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[7][$key]['l'] }}
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $agama_siswa[7][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                        <td align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                            </tr>

                                            <tr>
                                                <td align="left" style="vertical-align: middle;">TOTAL
                                                    SELURUH
                                                </td>
                                                @foreach ($kelas as $key => $item)
                                                    @if (!empty($siswa[6][$key]))
                                                        <td colspan="2" align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                            {{ $siswa[6][$key]['l'] + $siswa[6][$key]['p'] }}
                                                        </td>
                                                    @else
                                                        <td colspan="2" align="center" width="30px"
                                                            style="vertical-align: middle;">
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                <td align="center" width="30px" style="vertical-align: middle;"></td>
                                                @foreach ($usia as $item)
                                                    <td align="center" width="32px" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td align="center" width="32px"
                                                    style="vertical-align: middle; word-wrap: break-word"">
                                                </td>
                                                @foreach ($agama as $item)
                                                    <td colspan="2" align="center" style="vertical-align: middle;">
                                                    </td>
                                                @endforeach
                                                <td colspan="2" align="center" style="vertical-align: middle;"></td>
                                            </tr>

                                            @php
                                                $total = 0;
                                                $u5 = 0;
                                                $u6 = 0;
                                                $u7 = 0;
                                                $u8 = 0;
                                                $u9 = 0;
                                                $u10 = 0;
                                                $u11 = 0;
                                                $u12 = 0;
                                                $u13 = 0;
                                            @endphp
                                            @if (count($kelas) == count($alasan))
                                                @foreach ($kelas as $key => $item)
                                                    @if ($key == 0)
                                                        <tr>
                                                            <td colspan="{{ count($kelas) * 2 + 1 }}"
                                                                style="vertical-align: middle">
                                                            </td>
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @elseif ($key == 1)
                                                        <tr>
                                                            <td width="187px" style="vertical-align: middle">
                                                                {{ $alasan[$key] }}
                                                            </td>
                                                            @foreach ($kelas as $as)
                                                                <td colspan="2" align="center"
                                                                    style="vertical-align: middle">
                                                                    {{ $as->alias }}
                                                                </td>
                                                            @endforeach
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td width="187px" style="vertical-align: middle">
                                                                {{ $alasan[$key] }}
                                                            </td>
                                                            @foreach ($kelas as $as)
                                                                <td colspan="2" align="center"
                                                                    style="vertical-align: middle">0
                                                                </td>
                                                            @endforeach
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @php
                                                        $u5 = $u5 + $usia_siswa[$item->id_kelas]['u5'];
                                                        $u6 = $u6 + $usia_siswa[$item->id_kelas]['u6'];
                                                        $u7 = $u7 + $usia_siswa[$item->id_kelas]['u7'];
                                                        $u8 = $u8 + $usia_siswa[$item->id_kelas]['u8'];
                                                        $u9 = $u9 + $usia_siswa[$item->id_kelas]['u9'];
                                                        $u10 = $u10 + $usia_siswa[$item->id_kelas]['u10'];
                                                        $u11 = $u11 + $usia_siswa[$item->id_kelas]['u11'];
                                                        $u12 = $usia_siswa[$item->id_kelas]['u12'];
                                                        $u13 = $u13 + $usia_siswa[$item->id_kelas]['u13'];
                                                    @endphp
                                                @endforeach

                                                <tr>
                                                    <td colspan="{{ count($kelas) * 2 + 1 }}">
                                                    </td>
                                                    <td colspan="2" style="vertical-align: middle">JUMLAH
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u5 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u6 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u7 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u8 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u9 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u10 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u11 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u12 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u13 }}
                                                    </td>
                                                    <td align="center" width="32px"
                                                        style="vertical-align: middle; word-wrap: break-word"">
                                                        {{ $total }}
                                                    </td>
                                                    @foreach ($agama as $a)
                                                        <td align="center" style="vertical-align: middle"></td>
                                                        <td align="center" style="vertical-align: middle"></td>
                                                    @endforeach
                                                    <td align="center" style="vertical-align: middle"></td>
                                                    <td align="center" style="vertical-align: middle"></td>
                                                </tr>
                                            @else
                                                @foreach ($kelas as $key => $item)
                                                    @if ($key == 0)
                                                        <tr>
                                                            <td colspan="{{ count($kelas) * 2 + 1 }}"
                                                                style="vertical-align: middle">
                                                            </td>
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @elseif ($key == 1)
                                                        <tr>
                                                            <td width="187px" style="vertical-align: middle">
                                                                {{ $alasan[$key] }}
                                                            </td>
                                                            @foreach ($kelas as $as)
                                                                <td colspan="2" align="center"
                                                                    style="vertical-align: middle">
                                                                    {{ $as->alias }}
                                                                </td>
                                                            @endforeach
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @elseif ($key > 1 && $key <= 5)
                                                        <tr>
                                                            <td width="187px" style="vertical-align: middle">
                                                                {{ $alasan[$key] }}
                                                            </td>
                                                            @foreach ($kelas as $as)
                                                                <td colspan="2" align="center"
                                                                    style="vertical-align: middle">0
                                                                </td>
                                                            @endforeach
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="{{ count($kelas) * 2 + 1 }}"></td>
                                                            <td colspan="2" style="vertical-align: middle">
                                                                {{ $item->kelas }}
                                                            </td>
                                                            @foreach ($usia as $u_siswa)
                                                                <td align="center" width="32px"
                                                                    style="vertical-align: middle">
                                                                    {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                                </td>

                                                                @php
                                                                    $total =
                                                                        $total +
                                                                        $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                                                                @endphp
                                                            @endforeach
                                                            <td align="center" width="32px"
                                                                style="vertical-align: middle; word-wrap: break-word"">
                                                            </td>
                                                            @foreach ($agama as $a)
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                                <td align="center" style="vertical-align: middle">
                                                                </td>
                                                            @endforeach
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                            <td align="center" style="vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @php
                                                        $u5 = $u5 + $usia_siswa[$item->id_kelas]['u5'];
                                                        $u6 = $u6 + $usia_siswa[$item->id_kelas]['u6'];
                                                        $u7 = $u7 + $usia_siswa[$item->id_kelas]['u7'];
                                                        $u8 = $u8 + $usia_siswa[$item->id_kelas]['u8'];
                                                        $u9 = $u9 + $usia_siswa[$item->id_kelas]['u9'];
                                                        $u10 = $u10 + $usia_siswa[$item->id_kelas]['u10'];
                                                        $u11 = $u11 + $usia_siswa[$item->id_kelas]['u11'];
                                                        $u12 = $usia_siswa[$item->id_kelas]['u12'];
                                                        $u13 = $u13 + $usia_siswa[$item->id_kelas]['u13'];
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <td colspan="{{ count($kelas) * 2 + 1 }}"></td>
                                                    <td colspan="2" style="vertical-align: middle">JUMLAH
                                                    </td>

                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u5 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u6 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u7 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u8 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u9 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u10 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u11 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u12 }}
                                                    </td>
                                                    <td align="center" width="32px" style="vertical-align: middle">
                                                        {{ $u13 }}
                                                    </td>
                                                    <td align="center" width="32px"
                                                        style="vertical-align: middle; word-wrap: break-word"">
                                                        {{ $total }}
                                                    </td>
                                                    @foreach ($agama as $a)
                                                        <td align="center" style="vertical-align: middle"></td>
                                                        <td align="center" style="vertical-align: middle"></td>
                                                    @endforeach
                                                    <td align="center" style="vertical-align: middle"></td>
                                                    <td align="center" style="vertical-align: middle"></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
