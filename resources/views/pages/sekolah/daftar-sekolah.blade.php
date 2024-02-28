@extends('layout')
@push('style')
    <link href="{{ asset('/assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('script')
    <script src="{{ asset('/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": 5
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
                            url: '{{ URL::to('/sekolah/delete/') }}',
                            method: "POST",
                            data: {
                                'id_sekolah': id
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
                                                    "{{ URL::to('sekolah') }}";
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
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Daftar Sekolah</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Sekolah</li>
                    </ol>
                    <a href="{{ route('/tambah-sekolah') }}" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fa fa-plus-circle"></i>
                        Tambah Sekolah</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Sekolah</h4>
                        <h6 class="card-subtitle">Data master sekolah.</h6>
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th width="25%">Sekolah</th>
                                        <th width="15%">NPSN/NSSS</th>
                                        <th width="15%">Tanggal Berdiri</th>
                                        <th width="25%">Alamat</th>
                                        <th class="text-center" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($sekolah as $item)
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td>{{ $item->nama_sekolah }}</td>
                                            <td>{{ $item->npsn_nsss ? $item->npsn_nsss : '-' }}</td>
                                            <td>{{ $item->tanggal_berdiri ? tanggal($item->tanggal_berdiri) : '-' }}</td>
                                            <td>
                                                <p><b>Alamat : </b>{{ $item->alamat ? $item->alamat : '-' }}</p>
                                                <p>
                                                    <b>Kec. </b>{{ $item->kecamatan ? $item->kecamatan . '' : '-' }}
                                                    <b>Kab.
                                                    </b>{{ $item->kabupaten ? $item->kabupaten . '' : '-' }},
                                                    <b>Prov. </b>{{ $item->provinsi ? $item->provinsi . '' : '-' }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('/update-sekolah', ['id_sekolah' => $item->id_sekolah]) }}"
                                                    class="btn btn-sm btn-primary btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Edit Sekolah"><i class="ti-pencil"></i></a>
                                                <button type="button" id="delete" data-id="{{ $item->id_sekolah }}"
                                                    class="btn btn-sm btn-danger btn-outline" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Hapus Sekolah"><i class="ti-trash"></i></button>
                                                {{-- <button type="button" class="btn btn-sm btn-success btn-outline"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Detail Sekolah"><i
                                                        class="ti-info-alt"></i></button> --}}
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
