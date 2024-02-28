@extends('layout')
@php
    $staff = Session::has('staff') ? session::get('staff') : '';
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
                <h4 class="text-themecolor">Absensi Bulanan</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:vo">Absensi Bulanan</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Absensi Bulanan</h4>
                        <h6 class="card-subtitle">Data master absensi Bulanan.</h6>

                        <div class="m-t-40">
                            <form id="form-proses-siswa" action="{{ URL::to('/rekap/absensi/filter') }}" method="GET"
                                novalidate>
                                <div class="row">
                                    @if (Session::has('absensiError'))
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
                                                    placeholder="Tanggal"
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

                            @if (Session::has('absensi'))
                                @php
                                    $tanggal = Session::get('tanggal');
                                    $bulan = explode('-', $tanggal)[0];
                                    $tahun = explode('-', $tanggal)[1];
                                    $absensi = Session::get('absensi');

                                    $dates = [];
                                    for ($d = 1; $d <= 31; $d++) {
                                        $time = mktime(12, 0, 0, $bulan, $d, $tahun);
                                        if (date('m', $time) == $bulan) {
                                            if (date('w', $time) != 0) {
                                                # code...
                                                $dates[] = date('d', $time);
                                            }
                                        }
                                    }
                                @endphp
                                <div class="table-responsive m-t-40">
                                    <div class="m-b-10">
                                        <a href="{{ URL::to('/rekap/absensi/bulanan/' . Session::get('id_ta') . '/' . Session::get('tanggal') . '/' . Session::get('id_sek')) }}"
                                            class="btn btn-sm btn-danger"><i class="ti-printer"></i> Cetak
                                            Absensi Bulanan</a>
                                        <a href="{{ URL::to('/rekap/absensi/bulanan/' . Session::get('id_ta') . '/' . Session::get('tanggal') . '/' . Session::get('id_sek')) }}"
                                            class="btn btn-sm btn-danger"><i class="ti-printer"></i> Cetak
                                            Rekap Absensi</a>
                                    </div>
                                    <table class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="20%">Nama/Nip</th>
                                                @foreach ($dates as $item)
                                                    <th class="text-center" width=5%>
                                                        {{ $item }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($absensi as $item)
                                                <tr>
                                                    <td width="20%">
                                                        <b>{{ $item->nama }}</b><br>
                                                        @if ($item->status == 'PNS' || $item->status == 'PKKK')
                                                            NIP. {{ $item->nip }}
                                                        @else
                                                            NUPTK: {{ $item->nip }}
                                                        @endif
                                                    </td>
                                                    @foreach ($dates as $h)
                                                        @php
                                                            $hari = $tahun . '-' . $bulan . '-' . $h;
                                                        @endphp
                                                        @if ($hari == $item->hari)
                                                            <td class="text-center">
                                                                @if ($item->ket == 0)
                                                                    <small class="text-danger">A</small>
                                                                @elseif ($item->ket == 1)
                                                                    <small class="text-success">H</small>
                                                                @elseif ($item->ket == 2)
                                                                    <small class="text-warning">I</small>
                                                                @elseif ($item->ket == 3)
                                                                    <small class="text-warning">S</small>
                                                                @elseif ($item->ket == 4)
                                                                    <small class="text-primary">L</small>
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
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
