@extends('layout')
@php
    $staff = Session::has('staff') ? session::get('staff') : '';
    $presensi = [['id' => 0, 'label' => 'Tidak Hadir'], ['id' => 1, 'label' => 'Hadir'], ['id' => 2, 'label' => 'Izin'], ['id' => 3, 'label' => 'Sakit'], ['id' => 4, 'label' => 'Libur']];
@endphp
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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
                format: "yyyy-mm-dd",
            });

            $("#form-proses-siswa input, #form-proses-siswa select").jqBootstrapValidation();
            $("#form-save-absensi input, #form-save-absensi select").jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $("#form-save-absensi").serialize();
                    var url = $("#form-save-absensi").attr('action');

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
                                    window.location.href =
                                        "{{ URL::to('/absensi') }}";
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
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Absensi Harian</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:vo">Absensi Harian</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Absensi Harian</h4>
                        <h6 class="card-subtitle">Data master absensi harian.</h6>

                        <div class="table-responsive m-t-40">
                            <form id="form-proses-siswa" action="{{ URL::to('/absensi/proses') }}" method="GET"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Session::has('staff'))
            <form id="form-save-absensi" action="{{ URL::to('/absensi/save') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive m-t-40">
                                        <input type="hidden" name="id_ta" value="{{ Session::get('id_ta') }}">
                                        <input type="hidden" name="tanggal" value="{{ Session::get('tanggal') }}">
                                        <table class="table table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="15%">STAFF</th>
                                                    <th class="text-center" width="15%">PRESENSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($staff as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="id_staff[]"
                                                                value="{{ $item->id_staff }}">
                                                            <b>{{ $item->nama }}</b><br>
                                                            @if ($item->status == 'PNS' || $item->status == 'PKKK')
                                                                NIP. {{ $item->nip }}
                                                            @else
                                                                NUPTK: {{ $item->nip }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select name="ket[]" class="form-control custom-select"
                                                                required data-validation-required-message="Pilih kehadiran">
                                                                <option value="0" hidden>--Pilih Kehadiran --
                                                                </option>
                                                                @foreach ($presensi as $key => $kehadiran)
                                                                    <option value="{{ $presensi[$key]['id'] }}">
                                                                        {{ $presensi[$key]['label'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" id="submit_button" class="btn btn-info">Proses</button>
                                        <a href="{{ route('/daftar-siswa') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        @if (Session::has('absensi'))
            @php
                $absensi = Session::get('absensi');
            @endphp
            <form id="form-save-absensi" action="{{ URL::to('/absensi/save') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive m-t-40">
                                        <input type="hidden" name="id_ta" value="{{ Session::get('id_ta') }}">
                                        <input type="hidden" name="tanggal" value="{{ Session::get('tanggal') }}">
                                        <table class="table table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="15%">STAFF</th>
                                                    <th class="text-center" width="15%">PRESENSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($absensi as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="id_staff[]"
                                                                value="{{ $item->id_staff }}">
                                                            <input type="hidden" name="id_absensi[]"
                                                                value="{{ $item->id_absensi }}">
                                                            <b>{{ $item->nama }}</b><br>
                                                            @if ($item->status == 'PNS' || $item->status == 'PKKK')
                                                                NIP. {{ $item->nip }}
                                                            @else
                                                                NUPTK: {{ $item->nip }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select name="ket[]" class="form-control custom-select"
                                                                required
                                                                data-validation-required-message="Pilih kehadiran">
                                                                <option value="0" hidden>--Pilih Kehadiran --
                                                                </option>
                                                                @foreach ($presensi as $key => $kehadiran)
                                                                    @if ($presensi[$key]['id'] == $item->ket)
                                                                        <option value="{{ $presensi[$key]['id'] }}"
                                                                            selected>
                                                                            {{ $presensi[$key]['label'] }}</option>
                                                                    @else
                                                                        <option value="{{ $presensi[$key]['id'] }}">
                                                                            {{ $presensi[$key]['label'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" id="submit_button" class="btn btn-info">Proses</button>
                                        <a href="{{ route('/daftar-siswa') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
