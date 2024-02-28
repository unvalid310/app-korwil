@extends('layout')
@php
    $kelas = Session::has('kelas') ? Session::get('kelas') : '';
    $usia = ['5', '6', '7', '8', '9', '10', '11', '12', '13'];
    $agama = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'LAINNYA'];
@endphp
@push('style')
    <link href="{{ asset('/assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <style>
        td input {
            width: 50%;
        }

        thead tr th {
            vertical-align: middle !important;
        }

        .table tr td {
            vertical-align: middle !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/validation.js') }}"></script>
    <script>
        ! function(window, document, $) {
            "use strict";
            var preload = $(".preloader"),
                submit_button = $("#submit_button");
            $(".select2").select2();

            $('.mydatepicker').datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });

            $("#form-proses-siswa input, #form-proses-siswa select").jqBootstrapValidation();

            $("#form-tambah-siswa input, #form-tambah-siswa select").jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $("#form-tambah-siswa").serialize();
                    var url = $("#form-tambah-siswa").attr('action');

                    submit_button.prop('disabled', true);
                    preload.fadeIn();
                    console.log('tambah siswa');

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: form_data,
                        success: function(data) {
                            console.log(data);

                            if (data.success) {
                                preload.fadeOut();
                                $.toast({
                                    heading: 'Berhasil',
                                    text: data.message,
                                    position: 'top-right',
                                    showHideTransition: 'slide',
                                    icon: 'info',
                                    hideAfter: 1000,
                                    stack: 4
                                });
                                setTimeout(function() {
                                    submit_button.prop("disabled", false);
                                    window.location.href = "{{ URL::to('/siswa/agama') }}";
                                }, 1000);
                            } else {
                                preload.fadeOut();
                                $.toast({
                                    heading: 'Terjadi kesalahan',
                                    text: data.message,
                                    position: 'top-right',
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    hideAfter: 3000,
                                    stack: 4
                                });
                                setTimeout(function() {
                                    submit_button.prop("disabled", false);
                                }, 1000);
                            }
                        }
                    });
                }
            });
        }(window, document, jQuery);
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Tambah Agama Siswa</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Siswa</li>
                        <li class="breadcrumb-item active">Tambah Agama Siswa</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Agama Siswa</h4>
                        <h6 class="card-subtitle">Inputkan data jumlah siswa berdasarkam agama.</h6>
                        @if (count($tahun_ajar) == 0)
                            <div class="alert alert-danger">Mohon konfirmasi operator korwil untuk mengisi tahun ajar.
                            </div>
                        @endif
                        <form id="form-proses-siswa" class="m-t-40" action="{{ URL::to('/siswa/proses-agama') }}"
                            method="GET" novalidate>
                            @if (Session::has('errorSiswa'))
                                <div class="alert alert-danger">{{ Session::get('errorSiswa') }}. </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Tahun Ajar <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="form-control select-custom" name="id_ta" required
                                                data-validation-required-message="Pilih tahun ajar"
                                                {{ Session::has('kelas') ? 'disabled' : '' }}>
                                                @foreach ($tahun_ajar as $item)
                                                    @if (Session::has('id_ta'))
                                                        @if (Session::get('id_ta') == $item->id_ta)
                                                            <option value="{{ $item->id_ta }}" selected>
                                                                {{ $item->tahun_ajar }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $item->id_ta }}">{{ $item->tahun_ajar }}
                                                            </option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $item->id_ta }}">{{ $item->tahun_ajar }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Periode <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" class="form-control mydatepicker" name="periode"
                                                placeholder="Periode"
                                                value="{{ Session::get('periode') ? Session::get('periode') : '' }}"
                                                required data-validation-required-message="Pilih periode"
                                                {{ Session::has('kelas') ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 text-xs-left"
                                    style="margin-top: auto; margin-bottom: auto">
                                    <button type="submit" id="submit_button" class="btn btn-info"
                                        {{ Session::has('kelas') ? 'disabled' : '' }}>Proses</button>
                                    <a href="{{ route('/tambah-siswa') }}" class="btn btn-danger">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (Session::has('kelas'))
            @if (count(Session::get('kelas')) > 0)
                <form id="form-tambah-siswa" action="{{ URL::to('/siswa/save-agama') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Agama Siswa</h4>
                                    <div class="row">
                                        <div class="col-lg-12 table-responsive">
                                            <input type="hidden" name="id_ta" value="{{ Session::get('id_ta') }}">
                                            <input type="hidden" name="periode" value="{{ Session::get('periode') }}">
                                            <table class="table table-bordered" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="text-center" width="15%">#</th>
                                                        @foreach ($agama as $item)
                                                            <th colspan="2" class="text-center" width="10%">
                                                                {{ $item }}</th>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        @foreach ($agama as $item)
                                                            <th class="text-center">L</th>
                                                            <th class="text-center">P</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-right" width="15%">Awal bulan yang lalu</td>
                                                        <td colspan="{{ count($agama) * 2 }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNI</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1" name="l[]"
                                                                        value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="awal">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wni">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNA</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="awal">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wna">
                                                            </td>
                                                        @endforeach
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right" width="15%">Keluar bulan ini</td>
                                                        <td colspan="{{ count($agama) * 2 }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNI</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="keluar">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wni">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNA</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="keluar">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wna">
                                                            </td>
                                                        @endforeach
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right" width="15%">Masuk bulan ini</td>
                                                        <td colspan="{{ count($agama) * 2 }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNI</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="masuk">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wni">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNA</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="masuk">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wna">
                                                            </td>
                                                        @endforeach
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right" width="15%">Murid akhir bulan ini</td>
                                                        <td colspan="{{ count($agama) * 2 }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNI</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="akhir">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wni">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" width="15%">WNA</td>
                                                        @foreach ($agama as $item)
                                                            <td class="text-left" colspan="2">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <input type="text"
                                                                        class="form-control text-center mr-1"
                                                                        name="l[]" value="0">
                                                                    <input type="text" class="form-control text-center"
                                                                        name="p[]" value="0">
                                                                </div>
                                                                <input type="hidden" name="agama[]"
                                                                    value="{{ $item }}">
                                                                <input type="hidden" name="type[]" value="akhir">
                                                                <input type="hidden" name="warga_negara[]"
                                                                    value="wna">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" id="submit_button"
                                                class="btn btn-info">Proses</button>
                                            <a href="{{ route('/daftar-siswa') }}" class="btn btn-danger">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        @endif
    </div>
@endsection
