@extends('layout')
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
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
                            url: '{{ URL::to('/operator/delete/') }}',
                            method: "POST",
                            data: {
                                'id_operator': id
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
                                                    "{{ URL::to('operator') }}";
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
                <h4 class="text-themecolor">Daftar Operator</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Operator</li>
                    </ol>
                    <a href="{{ route('/tambah-operator') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fa fa-plus-circle"></i>
                        Tambah Operator</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Operator</h4>
                        <h6 class="card-subtitle">Data master operator.</h6>
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Sekolah</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($operator as $item)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->nama_sekolah }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('/update-operator', ['id_operator' => $item->id]) }}"
                                                    class="btn btn-sm btn-primary btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Edit Operator"><i class="ti-pencil"></i></a>
                                                <button type="button" id="delete" data-id="{{ $item->id }}"
                                                    class="btn btn-sm btn-danger btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Hapus Operator"><i class="ti-trash"></i></button>
                                                <button type="button" id="reset" data-id="{{ $item->id }}"
                                                    class="btn btn-sm btn-success btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Reset Password"><i class="ti-unlock"></i></button>
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
    <div id="reset-password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-reset-password" action="{{ URL::to('/operator/reset-password') }}" method="POST"
                    novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <h6>New Password:</h6>
                            <div class="controls">
                                <input type="password" class="form-control" id="password" name="password" required
                                    data-validation-required-message="Masukan password baru">
                                <input type="hidden" name="id_operator" id="id_operator">
                            </div>
                        </div>
                        <div class="form-group">
                            <h6>Confirm Password:</h6>
                            <div class="controls">
                                <input type="password" class="form-control" name="passwordAgain"
                                    data-validation-matches-match="password"
                                    data-validation-matches-message="Password tidak sama">
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
