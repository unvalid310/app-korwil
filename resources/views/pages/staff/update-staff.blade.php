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
                format: 'dd/mm/yyyy',
            });

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
                                    window.location.href = "{{ URL::to('/staff') }}";
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
    $status = ['PNS', 'PKKK', 'GTT', 'PTT', 'BOSDA', ''];
    $pendidikan = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-I', 'S-II'];
    $agama = ['ISLAM', 'KRISTEN', 'KHATOLIK', 'HINDU', 'BUDHA'];
    $golongan = ['PENGATUR MUDA / II.A', 'PENGATUR MUDA TK. I / II.B', 'PENGATUR / II.C', 'PENGATUR TK. I / II.D', 'PENATA MUDA / III.A', 'PENATA MUDA TK. I / III.B', 'PENATA / III.C', 'PENATA TK. I / III.D', 'PEMBINA / IV.A', 'PEMBINA TK. I / IV.B', 'PEMBINA UTAMA MUDA / IV.C', 'PEMBINA UTAMA MADYA / IV.D', 'PEMBINA UTAMA / IV.E', 'IX', '-'];
    $jk = [['id' => 'L', 'label' => 'Laki-Laki'], ['id' => 'P', 'label' => 'Perempuan']];
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Update Staff</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Staff</li>
                        <li class="breadcrumb-item active">Update Staff</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Staff</h4>
                        <h6 class="card-subtitle">Update data staff.</h6>
                        <form id="form-tambah-staff" class="m-t-40" action="{{ URL::to('/staff/edit') }}" method="POST"
                            novalidate>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h5>Nama Lengkap<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Nama lengkap"
                                                value="{{ $staff->nama }}" name="nama" required
                                                data-validation-required-message="Masukan nama lengkap">
                                            <input type="hidden" name="id_staff" value="{{ $staff->id_staff }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Status Kepegawaian</h5>
                                        <div class="controls">
                                            <select class="form-control select-custom"name="status">
                                                <option value="" hidden>-- Status kepegawaian --</option>
                                                @foreach ($status as $item)
                                                    @if ($staff->status == $item)
                                                        @if (empty($staff->status))
                                                            <option value="{{ $item }}" selected>Tidak ada</option>
                                                        @else
                                                            <option value="{{ $item }}" selected>
                                                                {{ $item }}
                                                            </option>
                                                        @endif
                                                    @else
                                                        @if (empty($item))
                                                            <option value="{{ $item }}">Tidak ada</option>
                                                        @else
                                                            <option value="{{ $item }}">{{ $item }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <h5>NIP / NUPTK <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="nip"
                                                value="{{ $staff->nip }}" placeholder="NIP / NUPTK" required
                                                data-validation-required-message="Masukan NIP / NUPTK">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Jenis Kelamin <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="form-control select-custom"name="jk" required
                                                data-validation-required-message="Pilih jenis kelamin">
                                                <option value="" hidden>-- Jenis Kelamin --</option>
                                                @foreach ($jk as $item)
                                                    @if ($staff->jk == $item['id'])
                                                        <option value="{{ $item['id'] }}" selected>{{ $item['label'] }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item['id'] }}">{{ $item['label'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Agama<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="form-control select-custom"name="agama" required
                                                data-validation-required-message="Pilih agama">
                                                <option value="" hidden>-- Agama --</option>
                                                @foreach ($agama as $item)
                                                    @if ($staff->agama == $item)
                                                        <option value="{{ $item }}" selected>{{ $item }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <h5>Golongan</h5>
                                        <div class="controls">
                                            <select class="select2 m-b-10 form-control" style="width: 100%"
                                                data-placeholder="Pilih golongan" name="golongan" required
                                                data-validation-required-message="Pilih golongan">
                                                <option value="" hidden>Pilih golongan</option>
                                                @foreach ($golongan as $item)
                                                    @if ($staff->golongan == $item)
                                                        @if ($staff->golongan == '-')
                                                            <option value="{{ $item }}" selected>Tidak ada</option>
                                                        @else
                                                            <option value="{{ $item }}" selected>
                                                                {{ $item }}
                                                            </option>
                                                        @endif
                                                    @else
                                                        @if ($item == '-')
                                                            <option value="{{ $item }}">Tidak ada</option>
                                                        @else
                                                            <option value="{{ $item }}">{{ $item }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <h5>TMT </h5>
                                        <div class="controls">
                                            <input type="text" class="form-control mydatepicker" name="tmt"
                                                value="{{ $staff->tmt }}" placeholder="TMT">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <h5>Masa Kerja </h5>
                                        <div class="controls">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="tahun"
                                                    value="{{ $staff->tahun }}" placeholder="tahun">
                                                <input type="number" class="form-control" name="bulan"
                                                    value="{{ $staff->bulan }}" placeholder="Bulan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <h5>Pendidikan Terakhir <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select class="form-control select-custom"name="pendidikan" required
                                                data-validation-required-message="Pilih pendidikan">
                                                <option value="" hidden>-- Pendidikan terakhir --</option>
                                                @foreach ($pendidikan as $item)
                                                    @if ($staff->pendidikan == $item)
                                                        <option value="{{ $item }}" selected>{{ $item }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <h5>Jurusan</h5>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="jurusan"
                                                value="{{ $staff->jurusan }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs-right">
                                <button type="submit" id="submit_button" class="btn btn-info">Simpan</button>
                                <a href="{{ route('/daftar-staff') }}" class="btn btn-danger">Batal</a>
                                <button type="reset" class="btn btn-inverse">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
