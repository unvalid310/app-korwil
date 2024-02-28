@extends('layout')
@push('style')
    <link href="{{ asset('assets/css/pages/tab-page.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('assets/js/pages/validation.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        ! function(window, document, $) {
            "use strict";
            var preload = $(".preloader"),
                submit_button = $("#submit_button");

            $('.mydatepicker').datepicker({
                format: 'dd/mm/yyyy',
            });

            $("#form-tambah-sekolah input").not('[name="tanggal_berdiri"]').jqBootstrapValidation({
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $("#form-tambah-sekolah").serialize();
                    var url = $("#form-tambah-sekolah").attr('action');

                    submit_button.prop('disabled', true);
                    preload.fadeIn();

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: form_data,
                        success: function(data) {
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
                                    location.reload();
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

            $("#form-bangunan-sekolah input").jqBootstrapValidation({
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $("#form-bangunan-sekolah").serialize();
                    var url = $("#form-bangunan-sekolah").attr('action');

                    submit_button.prop('disabled', true);
                    preload.fadeIn();

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: form_data,
                        success: function(data) {
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
                                    location.reload();
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
    $status_kepemilikan = ['TANAH NEGARA', 'TANAH PENGELOLAAN', 'TANAH HAK MILIK'];
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Profil Sekolah</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Sekolah</li>
                        <li class="breadcrumb-item active">Profil Sekolah</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profil Sekolah</h4>
                        <h6 class="card-subtitle">Mohon untuk mengkapi data profil sekolah dan status bangunan.
                        </h6>
                        <!-- Nav tabs -->
                        <div class="vtabs customvtab">
                            <ul class="nav nav-tabs tabs-vertical" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profil"
                                        role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                            class="hidden-xs-down">Data Sekolah</span> </a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sarpras"
                                        role="tab"><span class="hidden-sm-up"><i class="icon-shield"></i></span> <span
                                            class="hidden-xs-down">Bangunan & Kepemilikan</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="profil" role="tabpanel">
                                    <div class="p-20">
                                        <form id="form-tambah-sekolah" action="{{ URL::to('/sekolah/edit') }}"
                                            method="POST" novalidate>
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Nama Sekolah <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="nama_sekolah"
                                                                placeholder="Nama sekolah" required
                                                                data-validation-required-message="Masukan nama sekolah"
                                                                value="{{ $sekolah->nama_sekolah }}">
                                                            <input type="hidden" value="{{ $sekolah->id_sekolah }}"
                                                                name="id_sekolah">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>NPSN/NSSS <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="npsn_nsss"
                                                                placeholder="NPSN/NSSS" required
                                                                data-validation-required-message="Masukan npsn/nsss"
                                                                value="{{ $sekolah->npsn_nsss }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Tanggal Berdiri </h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control mydatepicker"
                                                                name="tanggal_berdiri" placeholder="Tanggal Berdiri"
                                                                value="{{ $sekolah->tanggal_berdiri }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Alamat <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="alamat"
                                                                placeholder="Alamat" required
                                                                data-validation-required-message="Masukan alamat sekolah"
                                                                value="{{ $sekolah->alamat }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Kabupaten <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="kabupaten"
                                                                required
                                                                data-validation-required-message="Masukan kabupaten sekolah"
                                                                placeholder="Kabupaten"
                                                                value="{{ $sekolah->kabupaten }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Kecamatan <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control"
                                                                placeholder="Kecamatan" name="kecamatan" required
                                                                data-validation-required-message="Masukan kecamatan sekolah"
                                                                value="{{ $sekolah->kecamatan }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <h5>Provinsi <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" name="provinsi"
                                                                required
                                                                data-validation-required-message="Masukan provinsi sekolah"
                                                                placeholder="Provinsi" value="{{ $sekolah->provinsi }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-xs-right">
                                                <button type="submit" id="submit_button"
                                                    class="btn btn-info">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane  p-20" id="sarpras" role="tabpanel">
                                    <form id="form-bangunan-sekolah" action="{{ URL::to('/bangunan/edit') }}"
                                        method="POST" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <h5>Status Tanah <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select class="form-control custom-select" name="status_tanah"
                                                            placeholder="Status tanah" required
                                                            data-validation-required-message="Masukan status tanah">
                                                            @foreach ($status_kepemilikan as $item)
                                                                @if ($sekolah->status_tanah == $item)
                                                                    <option value="{{ $item }}" selected>
                                                                        {{ $item }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" value="{{ $sekolah->id_sekolah }}"
                                                            name="id_sekolah">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-6">
                                                <div class="form-group">
                                                    <h5>Luas Tanah <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="luas_tanah"
                                                                placeholder="0" required
                                                                data-validation-required-message="Masukan luas tanah"
                                                                value="{{ $sekolah->luas_tanah }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">M <sup>2</sup></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 col-md-5 col-sm-6">
                                                <div class="form-group">
                                                    <h5>Luas Bangunan <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                name="luas_bangunan" placeholder="0" required
                                                                data-validation-required-message="Masukan luas bangunan"
                                                                value="{{ $sekolah->luas_bangunan }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">M <sup>2</sup></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-6">
                                                <div class="form-group">
                                                    <h5>Luas Pekarangan <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                name="luas_pekarangan" placeholder="0" required
                                                                data-validation-required-message="Masukan luas pekarangan"
                                                                value="{{ $sekolah->luas_pekarangan }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">M <sup>2</sup></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-5 col-md-5 col-sm-6">
                                                <div class="form-group">
                                                    <h5>Luas Kebun <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="luas_kebun"
                                                                placeholder="0" required
                                                                data-validation-required-message="Masukan luas kebun"
                                                                value="{{ $sekolah->luas_kebun }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">M <sup>2</sup></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-xs-right">
                                            <button type="submit" id="submit_button"
                                                class="btn btn-info">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
