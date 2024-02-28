<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>Sistem Informasi Korwil</title>
    @include('components.header')
</head>

<body class="skin-default fixed-layout">
    @include('components.preloader')
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        @include('components.navbar')
        @include('components.sidebar')

        <div class="page-wrapper">
            @yield('content')
        </div>

        @yield('modal')

        <footer class="footer">
            © 2018 Eliteadmin by themedesigner.in
        </footer>
    </div>
    @include('components.footer')
</body>

</html>
