@extends('layout')
@php
    $periode = [['id' => '1', 'label' => 'JANUARI'], ['id' => '2', 'label' => 'FEBRUARI'], ['id' => '3', 'label' => 'MARET'], ['id' => '4', 'label' => 'APRIL'], ['id' => '5', 'label' => 'MEI'], ['id' => '6', 'label' => 'JUNI'], ['id' => '7', 'label' => 'JULI'], ['id' => '8', 'label' => 'AGUSTUS'], ['id' => '9', 'label' => 'SEPTEMBER'], ['id' => '10', 'label' => 'OKTOBER'], ['id' => '11', 'label' => 'NOVEMBER'], ['id' => '12', 'label' => 'DESEMBER']];
@endphp
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
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
    <script>
        $(document).ready(function() {
            "use strict";
            var preload = $(".preloader");

            var table = $('#myTable').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": 4
                }, {
                    "sortable": true,
                    "visible": false,
                    "targets": 2
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="4"><b>T.A ' +
                                group +
                                '</b></td></tr>');
                            last = group;
                        }
                    });
                }
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
                            url: '{{ URL::to('/kelas/delete/') }}',
                            method: "POST",
                            data: {
                                'id_kelas': id
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
                                                    "{{ URL::to('kelas') }}";
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

            $('select[name="id_ta"]').on('change', function() {
                var selected = $(this).val();
                if (selected != '') {
                    table
                        .column(2)
                        .search(selected)
                        .draw();
                }
            });
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Daftar Kelas</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Kelas</a></li>
                        <li class="breadcrumb-item active">Daftar Kelas</li>
                    </ol>
                    <a href="{{ route('/tambah-kelas') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fa fa-plus-circle"></i>
                        Tambah Kelas</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Kelas</h4>
                        <h6 class="card-subtitle">Data master kelas.</h6>
                        <div class="table-responsive m-t-40">
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <div class="form-group">
                                        <div class="controls">
                                            <select class="form-control select-custom" name="id_ta">
                                                <option value="" hidden>-- Tahun Ajar --</option>
                                                @foreach ($tahun_ajar as $item)
                                                    <option value="{{ $item->tahun_ajar }}">{{ $item->tahun_ajar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <a href="{{ route('/daftar-jabatan') }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="20%">Kelas</th>
                                        <th class="text-center" width="10%">Alias</th>
                                        <th class="text-center" width="10%">T.A</th>
                                        <th width="20%">Wali Kelas</th>
                                        <th class="text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $item)
                                        <tr>
                                            <td class="text-center">
                                                <b>{{ $item->kelas }}</b>
                                            </td>
                                            <td class="text-center">{{ $item->alias }}</td>
                                            <td class="text-center">{{ $item->tahun_ajar }}</td>
                                            <td>
                                                {{ $item->nama }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('/update-kelas', ['id_kelas' => $item->id_kelas]) }}"
                                                    class="btn btn-xs btn-primary btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Edit Sekolah"><i class="ti-pencil"></i></a>
                                                <button type="button" id="delete" data-id="{{ $item->id_kelas }}"
                                                    class="btn btn-xs btn-danger btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Hapus Sekolah"><i class="ti-trash"></i></button>
                                            </td>
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
