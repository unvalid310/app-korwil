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
                order: [3, 'desc'],
                "columnDefs": [{
                    "sortable": false,
                    "targets": 8
                }, {
                    "sortable": true,
                    "visible": false,
                    "targets": 3
                }, {
                    "sortable": true,
                    "visible": false,
                    "targets": 4
                }, ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(3, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="7"><b>T.A ' +
                                group +
                                '</b></td></tr>');
                            last = group;
                        }
                    });
                    api.column(4, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="7"><b>Periode: </b>' +
                                group +
                                '</td></tr>');
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
                            url: '{{ URL::to('/jabatan/delete/') }}',
                            method: "POST",
                            data: {
                                'id_jabatan_staff': id
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
                                                    "{{ URL::to('jabatan') }}";
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

            $('select[name="periode"]').on('change', function() {
                var selected = $(this).val();
                if (selected != '') {
                    table
                        .column(4)
                        .search(selected)
                        .draw();
                }
            });

            $('select[name="id_ta"]').on('change', function() {
                var selected = $(this).val();
                if (selected != '') {
                    table
                        .column(3)
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
                <h4 class="text-themecolor">Daftar Jabatan</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Staff</a></li>
                        <li class="breadcrumb-item active">Daftar Jabatan</li>
                    </ol>
                    <a href="{{ route('/tambah-jabatan') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fa fa-plus-circle"></i>
                        Tambah Jabatan</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Jabatan</h4>
                        <h6 class="card-subtitle">Data master jabatan.</h6>
                        <div class="table-responsive m-t-40">
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <div class="form-group">
                                        <div class="controls">
                                            <select class="form-control select-custom"name="periode">
                                                @if (empty($_periode))
                                                    <option value="" hidden>-- Periode --</option>
                                                @endif
                                                @foreach ($periode as $item)
                                                    <option value="{{ $item['label'] }}">{{ $item['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                        <th width="20%">Nama Lengkap</th>
                                        <th class="text-center" width="5%">L/P</th>
                                        <th class="text-center" width="5%">Agama</th>
                                        <th class="text-center" width="10%">T.A</th>
                                        <th class="text-center" width="10%">Periode</th>
                                        <th class="text-center" width="10%">Status</th>
                                        <th class="text-center" width="10%">Jabatan</th>
                                        <th class="text-center" width="15%">Jam Mengajar</th>
                                        <th class="text-center" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jabatan as $item)
                                        <tr>
                                            <td width="25%">
                                                <b>{{ $item->nama }}</b><br>
                                                @if ($item->status == 'PNS' || $item->status == 'PKKK')
                                                    NIP. {{ $item->nip }}
                                                @else
                                                    NUPTK: {{ $item->nip }}
                                                @endif
                                            </td>
                                            <td class="text-center" width="5%">{{ $item->jk }}</td>
                                            <td class="text-center" width="5%">{{ $item->agama }}</td>
                                            <td class="text-center">
                                                {{ $item->tahun_ajar }}
                                            </td>
                                            <td class="text-center">
                                                {{ periode($item->periode) }}
                                            </td>
                                            <td class="text-center" width="10%">
                                                @if (empty($item->status))
                                                    -
                                                @else
                                                    {{ $item->status }}
                                                @endif
                                            </td>
                                            <td class="text-center" width="15%">
                                                @if (empty($item->jabatan) || $item->jabatan == 'KEPALA SEKOLAH')
                                                    -
                                                @else
                                                    {{ $item->jabatan }} {{ $item->alias }}
                                                @endif
                                            </td>
                                            <td class="text-center" width="15%">
                                                @if (empty($item->jam_mengajar))
                                                    -
                                                @else
                                                    {{ $item->jam_mengajar }} jam
                                                @endif
                                            </td>
                                            <td class="text-center" width="10%">
                                                <a href="{{ route('/update-jabatan', ['id_jabatan_staff' => $item->id_jabatan_staff]) }}"
                                                    class="btn btn-xs btn-primary btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Edit Sekolah"><i class="ti-pencil"></i></a>
                                                <button type="button" id="delete"
                                                    data-id="{{ $item->id_jabatan_staff }}"
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
