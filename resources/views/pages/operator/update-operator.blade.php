@extends('layout')

@push('style')
    <link href="{{ asset('/assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('script')
    <script src="{{ asset('/assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/validation.js') }}"></script>
    <script>
        ! function(window, document, $) {
            "use strict";
            var preload = $(".preloader"),
                submit_button = $("#submit_button");
            $(".select2").select2();

            $("#form-update-operator input, #form-update-operator select").jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $("#form-update-operator").serialize();
                    var url = $("#form-update-operator").attr('action');

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
                                    window.location.href = "{{ URL::to('/operator') }}";
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
                <h4 class="text-themecolor">Update Operator</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Operator</li>
                        <li class="breadcrumb-item">Daftar Operator</li>
                        <li class="breadcrumb-item active">Update Operator</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Operator</h4>
                        <h6 class="card-subtitle">Update akun operator.</h6>
                        <form id="form-update-operator" class="m-t-40" action="{{ URL::to('/operator/edit') }}"
                            method="POST" novalidate>
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <h5>Nama <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Nama" name="name"
                                                value="{{ $operator->name }}" required
                                                data-validation-required-message="Masukan nama operator">
                                            <input type="hidden" name="id_operator" value="{{ $operator->id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Email <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="email" class="form-control" name="email" placeholder="Email"
                                                value="{{ $operator->email }}" required
                                                data-validation-required-message="Masukan email operator">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Sekolah <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="select2 m-b-10 form-control select-custom" style="width: 100%"
                                                data-placeholder="Pilih sekolah" name="id_sekolah" id="id_sekolah"
                                                aria-invalid="false" data-validation-required-message="Pilih asal sekolah"
                                                required>
                                                <option value="" hidden>Pilih sekolah</option>
                                                @foreach ($sekolah as $item)
                                                    @if ($item->id_sekolah == $operator->id_sekolah)
                                                        <option value="{{ $item->id_sekolah }}" selected>
                                                            {{ $item->nama_sekolah }}
                                                        </option>
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
                            </div>
                            <div class="text-xs-right">
                                <button type="submit" id="submit_button" class="btn btn-info">Simpan</button>
                                <a href="{{ route('/daftar-operator') }}" class="btn btn-danger">Batal</a>
                                <button type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
