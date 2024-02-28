@php
    // dd(cek_sekolah());
@endphp
@extends('layout')
@push('style')
    <link href="{{ asset('assets/css/pages/dashboard1.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('assets/node_modules/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard1.js') }}"></script>
    <script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
@endpush
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Dashboard</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
        @if (!cek_sekolah())
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Lengkapi Data Sekolah!</h3>
                            <p class="lead">Mohon untuk melengkapi data-data kepemilikan maupun informasi profil sekolah
                                lainnya.
                            </p>
                            <hr class="my-4 bg-white">
                            <div class="text-right">
                                <a class="btn btn-primary btn-md" href="{{ route('/profil-sekolah') }}"
                                    role="button">Lengkapi data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
