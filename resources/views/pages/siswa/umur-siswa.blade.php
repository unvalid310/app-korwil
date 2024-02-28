@extends('layout')
@php
    if (Session::has('siswa')) {
        # code...
        $kelas = Session::get('kelas');
        $siswa = Session::get('siswa');
    }
    $agama = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'LAINNYA'];
    $usia = ['5', '6', '7', '8', '9', '10', '11', '12', '13'];
    $periode = [['id' => '1', 'label' => 'JANUARI'], ['id' => '2', 'label' => 'FEBRUARI'], ['id' => '3', 'label' => 'MARET'], ['id' => '4', 'label' => 'APRIL'], ['id' => '5', 'label' => 'MEI'], ['id' => '6', 'label' => 'JUNI'], ['id' => '7', 'label' => 'JULI'], ['id' => '8', 'label' => 'AGUSTUS'], ['id' => '9', 'label' => 'SEPTEMBER'], ['id' => '10', 'label' => 'OKTOBER'], ['id' => '11', 'label' => 'NOVEMBER'], ['id' => '12', 'label' => 'DESEMBER']];
@endphp
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <style>
        th {
            vertical-align: middle !important;
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
            var preload = $(".preloader");

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
                <h4 class="text-themecolor">Umur Siswa</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:vo">Umur Siswa</a></li>
                        <li class="breadcrumb-item
                                active">Umur Siswa</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Umur Siswa</h4>
                        <h6 class="card-subtitle">Data master jumlah siswa berdasarkan umur.</h6>
                        <div class="table-responsive m-t-40">
                            <form id="form-proses-siswa" action="{{ URL::to('/siswa/umur/filter') }}" method="GET"
                                novalidate>
                                <div class="row">
                                    @if (Session::has('errorSiswa'))
                                        <div class="col-lg-12 col-md-12">
                                            <div class="alert alert-danger">{{ Session::get('errorSiswa') }}. </div>
                                        </div>
                                    @endif
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
                                                <input type="text" class="form-control mydatepicker" name="periode"
                                                    placeholder="Periode"
                                                    value="{{ Session::get('periode') ? Session::get('periode') : '' }}"
                                                    required data-validation-required-message="Pilih periode">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Proses</button>
                                        <a href="{{ route('/daftar-siswa') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>

                            @if (Session::has('siswa'))
                                <div class="row m-t-40">
                                    <div class="col-lg-12 table-responsive">
                                        <table class="table table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center" width="15%">KELAS</th>
                                                    <th colspan="{{ count($usia) }}" class="text-center">UMUR</th>
                                                    <th rowspan="2" class="text-center" width="10%">JUMLAH</th>
                                                </tr>
                                                <tr>
                                                    @foreach ($usia as $item)
                                                        <th class="text-center">{{ $item }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                @foreach ($kelas as $item)
                                                    <tr>
                                                        <td class="text-right" width="15%">{{ $item->kelas }}
                                                        </td>
                                                        @foreach ($usia as $u_siswa)
                                                            <td class="text-center">
                                                                {{ $siswa[$item->id_kelas]['u' . $u_siswa] }}
                                                            </td>
                                                            @php
                                                                $total = $total + $siswa[$item->id_kelas]['u' . $u_siswa];
                                                            @endphp
                                                        @endforeach
                                                        <td class="text-center">-</td>
                                                    </tr>

                                                    @php
                                                        $u5 = $u5 + $siswa[$item->id_kelas]['u5'];
                                                        $u6 = $u6 + $siswa[$item->id_kelas]['u6'];
                                                        $u7 = $u7 + $siswa[$item->id_kelas]['u7'];
                                                        $u8 = $u8 + $siswa[$item->id_kelas]['u8'];
                                                        $u9 = $u9 + $siswa[$item->id_kelas]['u9'];
                                                        $u10 = $u10 + $siswa[$item->id_kelas]['u10'];
                                                        $u11 = $u11 + $siswa[$item->id_kelas]['u11'];
                                                        $u12 = $siswa[$item->id_kelas]['u12'];
                                                        $u13 = $u13 + $siswa[$item->id_kelas]['u13'];
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center" width="15%">KELAS</th>
                                                    <th class="text-center">{{ $u5 }}</th>
                                                    <th class="text-center">{{ $u6 }}</th>
                                                    <th class="text-center">{{ $u7 }}</th>
                                                    <th class="text-center">{{ $u8 }}</th>
                                                    <th class="text-center">{{ $u9 }}</th>
                                                    <th class="text-center">{{ $u10 }}</th>
                                                    <th class="text-center">{{ $u11 }}</th>
                                                    <th class="text-center">{{ $u12 }}</th>
                                                    <th class="text-center">{{ $u13 }}</th>
                                                    <th class="text-center" width="10%">{{ $total }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
