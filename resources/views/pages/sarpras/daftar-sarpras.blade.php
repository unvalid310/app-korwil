@extends('layout')
@php
    $kondisi = ['B', 'RR', 'RB'];
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
            var preload = $(".preloader"),
                submit_button = $("#submit_button");

            $('.mydatepicker').datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });

            var table = $('#myTable').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": 6
                }],
            });

            $('#myTable tbody').on("click", "#edit", function() {
                var td = $(this).closest("tr"),
                    button = $(this),
                    id = button.data('id'),
                    data = table.row(td).data(),
                    kondisi = 'B',
                    id_ta = $('select[name="id_ta"]').val(),
                    periode = $('input[name="periode"]').val();

                if (data[2] != null) {
                    kondisi = 'B';
                } else if (data[3] != null) {
                    kondisi = 'RR'
                } else {
                    kondisi = 'RB';
                }

                console.log(data[1])

                $('#create-sarpras select[name="id_ta"]').val(id_ta);
                $('#create-sarpras select[name="kondisi"]').val(kondisi);
                $('#create-sarpras input[name="periode"]').val(periode);
                $('#create-sarpras input[name="id_sarpras"]').val(id);
                $('#create-sarpras input[name="ruang"]').val(data[1]);
                $('#create-sarpras input[name="jumlah"]').val(data[5]);
                $('#create-sarpras').modal('toggle');
            });

            $('#myTable tbody').on("click", "#delete", function() {
                var td = $(this).closest("tr"),
                    button = $(this),
                    id = button.data('id'),
                    id_ta = $('select[name="id_ta"]').val(),
                    periode = $('input[name="periode"]').val();

                button.prop("disabled", true);

                swal({
                    title: "Apakah ingin menghapus data?",
                    text: "Data yang berkaitan akan terhapus",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '{{ URL::to('/sarpras/delete/') }}',
                            method: "POST",
                            data: {
                                'id_sarpras': id
                            },
                            success: function(data) {
                                if (data.success) {
                                    setTimeout(function() {
                                        swal({
                                                title: "Berhasil!",
                                                text: data.message,
                                                type: "success"
                                            },
                                            function() {
                                                window.location.href =
                                                    "{{ URL::to('/sarpras') }}?id_ta=" +
                                                    id_ta + "&periode=" +
                                                    periode;
                                            }), 1000
                                    });
                                } else {
                                    swal("Terjadi kesalahan", data.message, "error");
                                }
                            },
                        });
                    } else {
                        button.prop("disabled", false);
                        swal("Cancelled", "Data batal dihapus", "error");
                    }
                });
            });

            $("#form-proses-siswa input, #form-proses-siswa select").jqBootstrapValidation();

            $('#create-sarpras').on('show.bs.modal', function(e) {
                // do something...
                var submit_button = $("#submit_button");

                $('.periode').datepicker({
                    format: "mm-yyyy",
                    viewMode: "months",
                    minViewMode: "months"
                }).on('hide', function(e) {
                    e.stopPropagation();
                });
            })

            $("#form-create-sarpras input, #form-create-sarpras select").jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event) {
                    event.preventDefault();

                    var form_data = $('#form-create-sarpras').serialize();
                    var url = $('#form-create-sarpras').attr('action');

                    var id_ta = $('#form-create-sarpras select[name="id_ta"]').val();
                    var periode = $('#form-create-sarpras input[name="periode"]').val();

                    submit_button.prop('disabled', true);
                    preload.fadeIn();

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: form_data,
                        success: function(data) {
                            console.log(id_ta + ' - ' + periode);

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
                                    submit_button.prop("disabled",
                                        false);
                                    window.location.href =
                                        "{{ URL::to('/sarpras') }}?id_ta=" +
                                        id_ta + "&periode=" + periode;
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
                                    submit_button.prop("disabled",
                                        false);
                                }, 1000);
                            }
                        }
                    });
                }
            });

            $('#create-sarpras').on('hide.bs.modal', function(e) {
                // do something...
                $(this).find('select[name="id_ta"]').val('');
                $(this).find('select[name="kondisi"]').val('');
                $(this).find('input[name="periode"]').val('');
                $(this).find('input[name="id_sarpras"]').val('');
                $(this).find('input[name="ruang"]').val('');
                $(this).find('input[name="jumlah"]').val('0');
            })
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Daftar Sarana dan Prasarana</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:vo">Daftar Sarana dan Prasarana</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Sarana dan Prasarana</h4>
                        <h6 class="card-subtitle">Data master data sarana dan prasarana.</h6>

                        <div class="m-t-40">
                            <form id="form-proses-siswa" action="{{ URL::to('/sarpras') }}" method="GET" novalidate>
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
                                                        @if ($id_ta)
                                                            @if ($item->id_ta == $id_ta)
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
                                                    placeholder="Periode" value="{{ $periode ? $periode : '' }}" required
                                                    data-validation-required-message="Pilih periode">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 text-xs-right">
                                        <button type="submit" class="btn btn-info">Proses</button>
                                        <a href="{{ route('/daftar-sarpras') }}" class="btn btn-danger">Reset</a>
                                    </div>

                                    <div class="col-lg-6 col-md-6 text-right">
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#create-sarpras">Tambah
                                            Sarpras</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2" width="5%">#</th>
                                        <th rowspan="2" class="text-center" width="45%">Ruangan</th>
                                        <th colspan="3" class="text-center" width="20%">Kondisi</th>
                                        <th rowspan="2" class="text-center" width="15%">Jumlah</th>
                                        <th rowspan="2" class="text-center" width="15%">Action</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">B</th>
                                        <th class="text-center">RR</th>
                                        <th class="text-center">RB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($sarpras) > 0)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($sarpras as $item)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-left">{{ $item->ruang }}</td>
                                                <td class="text-center">
                                                    @if ($item->kondisi == 'B')
                                                        <small class="text-info"><i class="ti-check"></i></small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->kondisi == 'RR')
                                                        <small class="text-info"><i class="ti-check"></i></small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->kondisi == 'RB')
                                                        <small class="text-info"><i class="ti-check"></i></small>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $item->jumlah }}</td>
                                                <td class="text-center">
                                                    <button type="button" id="edit" data-id="{{ $item->id_sarpras }}"
                                                        class="btn btn-sm btn-primary btn-outline" data-toggle="tooltip"
                                                        data-placement="top" title=""
                                                        data-original-title="Reset Password"><i
                                                            class="ti-pencil"></i></button>
                                                    <button type="button" id="delete"
                                                        data-id="{{ $item->id_sarpras }}"
                                                        class="btn btn-sm btn-danger btn-outline" data-toggle="tooltip"
                                                        data-placement="top" title=""
                                                        data-original-title="Hapus Operator"><i
                                                            class="ti-trash"></i></button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('modal')
    <div id="create-sarpras" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Sarpras</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-create-sarpras" action="{{ URL::to('/sarpras/save') }}" method="POST" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <h6>Tahun Ajar</h6>
                            <div class="controls">
                                <select class="form-control select-custom" name="id_ta" required
                                    data-validation-required-message="Pilih tahun ajar">
                                    <option value="" hidden>-- Tahun Ajar --</option>
                                    @foreach ($tahun_ajar as $item)
                                        <option value="{{ $item->id_ta }}">
                                            {{ $item->tahun_ajar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Periode</h6>
                            <div class="controls">
                                <input type="text" class="form-control periode" name="periode" placeholder="Periode"
                                    autocomplete="off" required data-validation-required-message="Pilih tanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Ruangan</h6>
                            <div class="controls">
                                <input type="text" class="form-control" id="password" name="ruang"
                                    placeholder="Masukan Ruangan" required
                                    data-validation-required-message="Masukan nama ruangan">
                                <input type="hidden" name="id_sarpras">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Jumlah</h6>
                            <div class="controls">
                                <input type="number" class="form-control" name="jumlah" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Kondisi</h6>
                            <div class="controls">
                                <select name="kondisi" class="select-custom form-control" required
                                    data-validation-required-message="Pilih kondisi">
                                    <option value="" hidden>-- Pilih kondisi --</option>
                                    @foreach ($kondisi as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_button" class="btn btn-danger waves-effect waves-light">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
