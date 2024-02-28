@extends('layout')
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <style>
        th {
            vertical-align: middle !important;
        }

        td {
            font-size: 12px;
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
                    "targets": 10
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
                            url: '{{ URL::to('/staff/delete/') }}',
                            method: "POST",
                            data: {
                                'id_staff': id
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
                                                    "{{ URL::to('staff') }}";
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

            $('#myTable tbody').on("click", "#reset", function() {
                var button = $(this),
                    id = button.data('id');

                $('#id_operator').val(id);
                $('#reset-password').modal('toggle');
            });

            $('#reset-password').on('show.bs.modal', function(e) {
                // do something...
                var button = $('#myTable tbody #reset').prop("disabled", true),
                    submit_button = $("#submit_button");

                $("#form-reset-password input").jqBootstrapValidation({
                    preventSubmit: true,
                    submitSuccess: function($form, event) {
                        event.preventDefault();

                        var form_data = $('#form-reset-password').serialize();
                        var url = $('#form-reset-password').attr('action');

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
                                        submit_button.prop("disabled",
                                            false);
                                        window.location.href =
                                            "{{ URL::to('/operator') }}";
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
            })

            $('#reset-password').on('hide.bs.modal', function(e) {
                // do something...
                $('#myTable tbody #reset').prop("disabled", false);
                $('#id_operator').val('');
            })
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Daftar Staff</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Staff</a></li>
                        <li class="breadcrumb-item active">Daftar Staff</li>
                    </ol>
                    <a href="{{ route('/tambah-staff') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fa fa-plus-circle"></i>
                        Tambah Staff</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Staff</h4>
                        <h6 class="card-subtitle">Data master staff.</h6>
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2" width="5%">#</th>
                                        <th rowspan="2" width="20%">Nama Lengkap</th>
                                        <th class="text-center" rowspan="2" width="5%">L/P</th>
                                        <th class="text-center" rowspan="2" width="5%">Agama</th>
                                        <th class="text-center" colspan="2" width="25%">Pangkat Terakhir</th>
                                        <th class="text-center" colspan="2" width="5%">Masa Kerja</th>
                                        <th class="text-center" rowspan="2" width="15%">Pendidikan /Jurusan</th>
                                        <th class="text-center" rowspan="2" width="10%">Status</th>
                                        <th class="text-center" rowspan="2" width="10%">Action</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" width="15%">Gol /Ruang</th>
                                        <th class="text-center" width="5%">TMT</th>
                                        <th class="text-center">Thn</th>
                                        <th class="text-center">Bln</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($staff as $item)
                                        <tr>
                                            <td class="text-center" width="5%">{{ $i }}</td>
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
                                                @if (empty($item->golongan))
                                                    -
                                                @else
                                                    {{ $item->golongan }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (empty($item->tmt))
                                                    -
                                                @else
                                                    {{ $item->tmt }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (empty($item->tahun))
                                                    -
                                                @else
                                                    {{ $item->tahun }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (empty($item->bulan))
                                                    -
                                                @else
                                                    {{ $item->bulan }}
                                                @endif
                                            </td>
                                            <td class="text-center" width="15%">
                                                @if (!empty($item->jurusan))
                                                    {{ $item->pendidikan }} / {{ $item->jurusan }}
                                                @else
                                                    {{ $item->pendidikan }}
                                                @endif
                                            </td>
                                            <td class="text-center" width="10%">
                                                @if (empty($item->status))
                                                    -
                                                @else
                                                    {{ $item->status }}
                                                @endif
                                            </td>
                                            <td class="text-center" width="10%">
                                                <a href="{{ route('/update-staff', ['id_staff' => $item->id_staff]) }}"
                                                    class="btn btn-xs btn-primary btn-outline mb-1" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Edit Sekolah"><i class="ti-pencil"></i></a>
                                                <button type="button" id="delete" data-id="{{ $item->id_staff }}"
                                                    class="btn btn-xs btn-danger btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Hapus Sekolah"><i class="ti-trash"></i></button>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
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
