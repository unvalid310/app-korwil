@extends('layout')
@push('script')
    <script src="{{ asset('assets/js/pages/validation.js') }}"></script>
    <script>
        ! function(window, document, $) {
            "use strict";
            var preload = $(".preloader");
            var submit_button = $("#submit_button");

            $("#form-tambah-sekolah input").jqBootstrapValidation({
                preventSubmit: true,
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
                                    window.location.href = "{{ URL::to('/sekolah') }}";
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
                <h4 class="text-themecolor">Tambah Sekolah</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item">Sekolah</li>
                        <li class="breadcrumb-item active">Tambah Sekolah</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Sekolah</h4>
                        <h6 class="card-subtitle">Inputkan hanya nama sekolah, operator sekolah akan melengkapi data
                            lainnya.</h6>
                        <form id="form-tambah-sekolah" class="m-t-40" action="{{ URL::to('/sekolah/save') }}" method="POST"
                            novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <h5>Nama Sekolah <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="nama_sekolah"
                                                placeholder="Nama sekolah" required
                                                data-validation-required-message="Masukan nama sekolah">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>NPSN/NSSS</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="NPSN/NSSS" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <h5>Tanggal Berdiri</h5>
                                        <div class="controls">
                                            <input type="date" class="form-control" placeholder="Tanggal Berdiri"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Alamat</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Alamat" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Kabupaten</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Kabupaten" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Kecamatan</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Kecamatan" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Provinsi</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Provinsi" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs-right">
                                <button type="submit" id="submit_button" class="btn btn-info">Simpan</button>
                                <a href="{{ route('/daftar-sekolah') }}" class="btn btn-danger">Batal</a>
                                <button type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
