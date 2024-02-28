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
    </div>
@endsection
