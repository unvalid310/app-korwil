@extends('layout')

@push('style')
    <link href="{{ asset('/assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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

            $('select[name="jabatan"]').on('change', function() {
                var _value = $(this).val().toLowerCase();
                console.log(_value);
                if (_value == 'kepala sekolah' || _value == 'lainnya') {
                    $('input[name="jam_mengajar"]').prop('readonly', true);
                    $('input[name="jabatan_lainnya"]').prop('readonly', true);
                    if (_value == 'lainnya') {
                        $('input[name="jam_mengajar"]').prop('readonly', true);
                        $('input[name="jabatan_lainnya"]').prop('readonly', false);
                        $('input[name="jabatan_lainnya"]').prop('required', true);
                        $('input[name="jabatan_lainnya"]').attr('data-validation-required-message	',
                            'Masukan nama jabatan');
                        $('input[name="jabatan_lainnya"]').prop('readonly', false);
                        $("#form-tambah-staff input, #form-tambah-staff select").jqBootstrapValidation();
                    }
                } else {
                    $('input[name="jabatan_lainnya"]').prop('readonly', true);
                    $('input[name="jam_mengajar"]').prop('readonly', false);
                }
            })

            $("#form-tambah-staff input, #form-tambah-staff select").jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $("#form-tambah-staff").serialize();
                    var url = $("#form-tambah-staff").attr('action');

                    submit_button.prop('disabled', true);
                    preload.fadeIn();

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: form_data,
                        success: function(data) {
                            console.log(data.data);
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
                                    window.location.href = "{{ URL::to('/jabatan') }}";
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
@php
    $jabatan = ['KEPALA SEKOLAH', 'GURU BIDANG STUDI', 'GURU KELAS', 'LAINNYA'];
    $periode = [['id' => '1', 'label' => 'JANUARI'], ['id' => '2', 'label' => 'FEBRUARI'], ['id' => '3', 'label' => 'MARET'], ['id' => '4', 'label' => 'APRIL'], ['id' => '5', 'label' => 'MEI'], ['id' => '6', 'label' => 'JUNI'], ['id' => '7', 'label' => 'JULI'], ['id' => '8', 'label' => 'AGUSTUS'], ['id' => '9', 'label' => 'SEPTEMBER'], ['id' => '10', 'label' => 'OKTOBER'], ['id' => '11', 'label' => 'NOVEMBER'], ['id' => '12', 'label' => 'DESEMBER']];
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Tambah Jabatan</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Jabatan</li>
                        <li class="breadcrumb-item active">Tambah Jabatan</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Jabatan Staff</h4>
                        <h6 class="card-subtitle">Inputkan data jabatan staff.</h6>
                        @if (count($tahun_ajar) == 0)
                            <div class="alert alert-danger">Mohon konfirmasi operator korwil untuk mengisi tahun ajar.
                            </div>
                        @endif
                        @if (count($staff) == 0)
                            <div class="alert alert-danger">Mohon isikan data staff. </div>
                        @endif
                        <form id="form-tambah-staff" class="m-t-40" action="{{ URL::to('/jabatan/save') }}" method="POST"
                            novalidate>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Tahun Ajar <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="form-control select-custom" name="id_ta" required
                                                data-validation-required-message="Pilih tahun ajar">
                                                @foreach ($tahun_ajar as $item)
                                                    <option value="{{ $item->id_ta }}">{{ $item->tahun_ajar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Periode <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" class="form-control mydatepicker" name="periode" required
                                                data-validation-required-message="Pilih periode">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Staff <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="select2 m-b-10 form-control" style="width: 100%"
                                                data-placeholder="Pilih staff" name="id_staff" required
                                                data-validation-required-message="Pilih staff">
                                                <option value="" hidden>Pilih staff</option>
                                                @foreach ($staff as $item)
                                                    <option value="{{ $item->id_staff }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Jabatan <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="form-control select-custom" name="jabatan" required
                                                data-validation-required-message="Pilih jabatan">
                                                <option value="" hidden>-- Jabatan --</option>
                                                @foreach ($jabatan as $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Jabatan Lainnya</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="jabatan_lainnya"
                                                placeholder="Jabatan Lainnya" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group">
                                        <h5>Jam Mengajar</h5>
                                        <div class="controls">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="jam_mengajar"
                                                    value="0" readonly>
                                                <span class="input-group-text">Jam</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs-right">
                                <button type="submit" id="submit_button" class="btn btn-info">Simpan</button>
                                <a href="{{ route('/daftar-jabatan') }}" class="btn btn-danger">Batal</a>
                                <button type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
