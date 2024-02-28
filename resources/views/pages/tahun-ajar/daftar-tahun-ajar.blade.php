@extends('layout')
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('/assets/js/pages/validation.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            var preload = $(".preloader");

            $('.input-daterange-datepicker').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse',
                locale: {
                    format: 'DD/MM/YYYY',
                }
            });
            $('.input-daterange-datepicker').val('');
            $('.input-daterange-datepicker').attr("placeholder", "Periode");

            var table = $('#myTable').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": 3
                }],
            });

            $('#myTable tbody').on("click", "#delete", function() {
                var td = $(this).closest("tr"),
                    button = $(this),
                    id = button.data('id');

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
                            url: '{{ URL::to('/tahun-ajar/delete/') }}',
                            method: "POST",
                            data: {
                                'id_ta': id
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
                                                window.location =
                                                    "{{ URL::to('tahun-ajar') }}";
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

            $('#myTable tbody').on("click", "#edit", function() {
                var row = $(this).closest("tr"),
                    button = $(this),
                    data = table.row(row).data(),
                    id = $(this).data('id');

                console.log(data[1]);
                button.prop("disabled", true);

                $('#update-tahun-ajar').modal('toggle');

                $('#update-tahun-ajar').on('hidden.bs.modal', function(e) {
                    button.prop("disabled", false);

                    $(this)
                        .find("input")
                        .val('')
                        .end()
                        .find(".form-group")
                        .removeClass('validate')
                        .end()
                        .find("form,.form-group")
                        .removeClass('error')
                        .end()
                        .find(".form-group")
                        .removeClass('issue')
                        .end()
                        .find('.help-block')
                        .html('')
                        .end();
                });

                $('#update-tahun-ajar').on('shown.bs.modal', function(e) {
                    var date = data[2].split(' - '),
                        startDate = date[0],
                        endDate = date[1];

                    $(this)
                        .find('input[name="id_ta"]').val(id).end()
                        .find('input[name="tahun_ajar"]').val(data[1]).end()
                        .find('input[name="periode"]').daterangepicker({
                                startDate: startDate,
                                endDate: endDate,
                                buttonClasses: [
                                    'btn',
                                    'btn-sm'
                                ],
                                applyClass: 'btn-danger',
                                cancelClass: 'btn-inverse',
                                locale: {
                                    format: 'DD/MM/YYYY',
                                }
                            },
                            function(start, end, label) {}).val(data[2]).end();
                });
            });

            $("#tambah-tahun-ajar input").jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event) {
                    preload.fadeIn();
                }
            });

            $('#tambah-tahun-ajar').on('hidden.bs.modal', function(e) {
                $(this)
                    .find("input")
                    .val('')
                    .end()
                    .find(".form-group")
                    .removeClass('validate')
                    .end()
                    .find("form,.form-group")
                    .removeClass('error')
                    .end()
                    .find(".form-group")
                    .removeClass('issue')
                    .end()
                    .find('.help-block')
                    .html('')
                    .end();
            });
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Tahun Ajar</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal"
                        data-target="#tambah-tahun-ajar"><i class="fa fa-plus-circle"></i>
                        Tambah Tahun Ajar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tahun Ajar</h4>
                        <h6 class="card-subtitle">Data master tahun ajar.</h6>
                        <div class="table-responsive m-t-40">
                            @if (Session::has('addTAFailed'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                                            aria-hidden="true">×</span> </button>
                                    <b>Gagal! </b>{{ Session::get('addTAFailed') }}
                                </div>
                            @endif
                            @if (Session::has('addTASuccess'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                                            aria-hidden="true">×</span> </button>
                                    <b>Berhasil! </b>{{ Session::get('addTASuccess') }}
                                </div>
                            @endif
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Tahun Ajar</th>
                                        <th>periode</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($tahun_ajar as $item)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>{{ $item->tahun_ajar }}</td>
                                            <td>{{ $item->periode }}</td>
                                            <td class="text-center">
                                                <button type="button" id="edit" data-id="{{ $item->id_ta }}"
                                                    class="btn btn-sm btn-primary btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Edit Tahun Ajar"><i class="ti-pencil"></i></button>
                                                <button type="button" id="delete" data-id="{{ $item->id_ta }}"
                                                    class="btn btn-sm btn-danger btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Hapus Tahun Ajar"><i class="ti-trash"></i></button>
                                            </td>
                                            @php
                                                $i++;
                                            @endphp
                                        </tr>
                                    @endforeach
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
    <div id="tambah-tahun-ajar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Tahun Ajar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-tambah-tahun-ajar" action="{{ URL::to('/tahun-ajar/save') }}" method="POST" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <h6>Tahun Ajar:</h6>
                            <div class="controls">
                                <input type="text" class="form-control" id="tahun_ajar" name="tahun_ajar"
                                    placeholder="Tahun Ajar" required data-validation-regex-regex="\d*([\/]?\d+)"
                                    data-validation-regex-message="Harus angka dan garis miring (tanpa spasi). contoh : 2023/2024 "
                                    data-validation-required-message="Masukan tahun ajar">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Periode:</h6>
                            <div class="controls">
                                <input class="form-control input-daterange-datepicker" type="text" name="periode"
                                    placeholder="Periode" required
                                    data-validation-required-message="Masukan periode tahun ajar" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_button" class="btn btn-danger waves-effect waves-light">Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="update-tahun-ajar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Tahun Ajar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-tambah-tahun-ajar" action="{{ URL::to('/tahun-ajar/edit') }}" method="POST" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <h6>Tahun Ajar:</h6>
                            <div class="controls">
                                <input type="text" class="form-control" id="tahun_ajar" name="tahun_ajar"
                                    placeholder="Tahun Ajar" required data-validation-regex-regex="\d*([\/]?\d+)"
                                    data-validation-regex-message="Harus angka dan garis miring (tanpa spasi). contoh : 2023/2024 "
                                    data-validation-required-message="Masukan tahun ajar">
                                <input type="hidden" name="id_ta">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Periode:</h6>
                            <div class="controls">
                                <input class="form-control input-daterange-datepicker" type="text" name="periode"
                                    placeholder="Periode" required
                                    data-validation-required-message="Masukan periode tahun ajar" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_button" class="btn btn-danger waves-effect waves-light">Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
