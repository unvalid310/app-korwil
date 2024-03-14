<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
        <div class="user-profile">
            <div class="user-pro-body">
                <div><img src="{{ asset('assets/images/users/2.jpg') }}" alt="user-img" class="img-circle">
                </div>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown"
                        role="button" aria-haspopup="true" aria-expanded="false">{{ Session::get('name') }} <span
                            class="caret"></span></a>
                    <div class="dropdown-menu animated flipInY">
                        <a href="{{ route('logout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{ route('/') }}" aria-expanded="false"><i
                            class="icon-speedometer"></i><span class="hide-menu">Dashboard</a>
                </li>

                @can('profil sekolah', SekolahController::class)
                    <li> <a class="waves-effect waves-dark" href="{{ route('/profil-sekolah') }}" aria-expanded="false"><i
                                class="icon-home"></i><span class="hide-menu">Profil Sekolah</a>
                    </li>
                @endcan

                @can('view tahun ajar', TahunAjarController::class)
                    <li> <a class="waves-effect waves-dark" href="{{ route('/tahun-ajar') }}" aria-expanded="false"><i
                                class="ti-calendar"></i><span class="hide-menu">Tahun Ajar</a>
                    </li>
                @endcan

                @canany(['view sekolah', 'create sekolah', 'update sekolah', 'delete sekolah'],
                    SekolahController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                                class="ti-layout-grid2"></i><span class="hide-menu">Sekolah</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @can('view sekolah', SekolahController::class)
                                <li><a href="{{ route('/daftar-sekolah') }}">Daftar Sekolah</a></li>
                            @endcan
                            @can('view sekolah', SekolahController::class)
                                <li><a href="{{ route('/tambah-sekolah') }}">Tambah Sekolah</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['view staff', 'create staff', 'update staff', 'delete staff'], StaffController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="icon-people"></i><span class="hide-menu">Staff</a>
                        <ul aria-expanded="false" class="collapse">
                            @can('view staff', StaffController::class)
                                <li><a href="{{ route('/daftar-staff') }}">Daftar Staff</a></li>
                            @endcan
                            @can('create staff', StaffController::class)
                                <li><a href="{{ route('/tambah-staff') }}">Tambah Staff</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['view jabatan', 'create jabatan', 'update jabatan', 'delete jabatan'],
                    JabatanStaffController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="icon-shield"></i><span class="hide-menu">Jabatan</a>
                        <ul aria-expanded="false" class="collapse">
                            @can('view jabatan', JabatanStaffController::class)
                                <li><a href="{{ route('/daftar-jabatan') }}">Daftar Jabatan</a></li>
                            @endcan
                            @can('create jabatan', JabatanStaffController::class)
                                <li><a href="{{ route('/tambah-jabatan') }}">Tambah Jabatan</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['view kelas', 'create kelas', 'update kelas', 'delete kelas'], KelasController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="icon-layers"></i><span class="hide-menu">Kelas</a>
                        <ul aria-expanded="false" class="collapse">
                            @can('view kelas', KelasController::class)
                                <li><a href="{{ route('/daftar-kelas') }}">Daftar Kelas</a></li>
                            @endcan
                            @can('create kelas', KelasController::class)
                                <li><a href="{{ route('/tambah-kelas') }}">Tambah Kelas</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['view siswa', 'rekap siswa'], SiswaController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="ti-id-badge"></i><span class="hide-menu">Siswa</a>
                        <ul aria-expanded="false" class="collapse">
                            @can('view siswa', SiswaController::class)
                                <li><a href="{{ route('/tambah-siswa') }}">Tambah Siswa</a></li>
                                <li><a href="{{ route('/daftar-siswa') }}">Jumlah Siswa</a></li>
                                <li><a href="{{ route('/tambah-umur-siswa') }}">Tambah Umur Siswa</a></li>
                                <li><a href="{{ route('/umur-siswa') }}">Umur Siswa</a></li>
                                <li><a href="{{ route('/tambah-agama-siswa') }}">Tambah Agama Siswa</a></li>
                                <li><a href="{{ route('/agama-siswa') }}">Agama Siswa</a></li>
                            @endcan
                            @can('rekap siswa', SiswaController::class)
                                <li><a href="{{ URL::to('rekap/siswa') }}">Rekap Siswa</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['view absensi', 'view absensi bulanan', 'rekap absen'], AbsensiController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="ti-bookmark-alt"></i><span class="hide-menu">Absensi</a>
                        <ul aria-expanded="false" class="collapse">
                            @can('view absensi', AbsensiController::class)
                                <li><a href="{{ route('/absensi-harian') }}">Absensi Harian</a></li>
                            @endcan
                            @can('view absensi bulanan', AbsensiControllerodel::class)
                                <li><a href="{{ route('/absensi-bulanan') }}">Absensi Bulanan</a></li>
                            @endcan
                            @can('rekap absen', AbsensiControllerodel::class)
                                <li><a href="{{ URL::to('/rekap/absensi') }}">Rekap Absensi</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('view sarpras', SarprasController::class)
                    <li> <a class="waves-effect waves-dark" href="{{ route('/daftar-sarpras') }}" aria-expanded="false"><i
                                class="icon-grid"></i><span class="hide-menu">Sarana & Prasarana</a>
                    </li>
                @endcan

                @can('rekap sarpras', SarprasController::class)
                    <li> <a class="waves-effect waves-dark" href="{{ URL::to('/sarpras/rekap') }}"
                            aria-expanded="false"><i class="icon-grid"></i><span class="hide-menu">Rekap Sarpras</a>
                    </li>
                @endcan

                @canany(['view operator', 'create operator', 'update operator', 'delete operator'],
                    OperatorController::class)
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                                class="ti-user"></i><span class="hide-menu">Operator</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('/daftar-operator') }}">Daftar Operator</a></li>
                            <li><a href="{{ route('/tambah-operator') }}">Tambah Operator</a></li>
                        </ul>
                    </li>
                @endcan

                <li> <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false"><i
                            class="fa fa-circle-o text-success"></i><span class="hide-menu">Log Out</span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
