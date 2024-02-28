<table>
    <tr>
        <td colspan=18 align="center">DAFTAR HADIR GURU DAN TENAGA PENDIDIK</td>
    </tr>
    <tr>
        <td colspan=18 align="center">BULAN {{ strtoupper(explode(' - ', periode($sekolah->periode))[0]) }}</td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td colspan=3>NAMA SEKOLAH</td>
        <td colspan=3>: {{ $sekolah->nama_sekolah }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan=2>PROVINSI</td>
        <td colspan=5>: {{ $sekolah->provinsi }}</td>
    </tr>
    <tr>
        <td colspan=3>TANGGAL BERDIRI</td>
        <td colspan=3>: {{ $sekolah->tanggal_berdiri }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan=2>TAPEL</td>
        <td colspan=5>: {{ $sekolah->tahun_ajar }}</td>
    </tr>
    <tr>
        <td colspan=3>KABUPATEN</td>
        <td colspan=3>: {{ $sekolah->kabupaten }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan=2>JUMLAH GURU</td>
        <td colspan=5>: {{ $sekolah->j_guru }}</td>
    </tr>
    <tr>
        <td colspan=3></td>
        <td colspan=3></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan=2>JUMLAH PEGAWAI</td>
        <td colspan=5>: {{ $sekolah->j_staff }}</td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td rowspan=2 height="36px" width="40px" align="center" style="vertical-align: middle; border: 2px solid #000">
            NO
        </td>
        <td rowspan=2 colspan=2 height="36px" width="200px" align="center"
            style="vertical-align: middle; border: 2px solid #000">
            NAMA LENGKAP NIP / NUPTK
        </td>
        <td rowspan=2 height="36px" width="38px" align="center"
            style="vertical-align: middle; border: 2px solid #000">L/P</td>
        <td rowspan=2≈ height="36px" width="84px" align="center"
            style="vertical-align: middle; border: 2px solid #000">
            AGAMA
        </td>
        <td colspan=2 height="36px" align="center" style="vertical-align: middle; border: 2px solid #000">
            JABATAN
        </td>
        <td colspan=2 height="36px" align="center" style="vertical-align: middle; border: 2px solid #000">
            MASA KERJA
        </td>
        <td rowspan=2 height="36px" width="100px" align="center"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">PENDIDIKAN TERAKHIR / JURUSAN
        </td>
        <td rowspan=2 height="36px" width="97px" align="center; word-wrap: break-word"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">GURU BIDANG STUDI / GURU KELAS
        </td>
        <td rowspan=2 height="36px" width="78px" align="center"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">PNS, PKKK, GTT, PTT, BOSDA
        </td>
        <td rowspan=2 height="36px" width="84px" align="center"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">JUMLAH JAM MENGAJAR </td>
        <td colspan=4 height="36px" align="center" style="vertical-align: middle; border: 2px solid #000">
            ABSENSI
        </td>
        <td rowspan=2 height="36px" width="77px" align="center"
            style="vertical-align: middle; border: 2px solid #000">KET</td>
    </tr>
    <tr>
        <td height="36px" width="97px" align="center" style="vertical-align: middle; border: 2px solid #000">
            RUANG/GOL
        </td>
        <td height="36px" width="97px" align="center" style="vertical-align: middle; border: 2px solid #000">
            TMT
        </td>
        <td height="36px" width="59px" align="center" style="vertical-align: middle; border: 2px solid #000">
            TAHUN
        </td>
        <td height="36px" width="59px" align="center" style="vertical-align: middle; border: 2px solid #000">
            BULAN
        </td>
        <td height="36px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
            S
        </td>
        <td height="36px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
            I
        </td>
        <td height="36px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
            A
        </td>
        <td height="36px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
            JMH
        </td>
    </tr>
    {{-- body --}}
    @php
        $index = 1;
    @endphp
    @foreach ($jabatan as $item)
        <tr>
            <td height="40px" width="40px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $index }}
            </td>
            <td colspan=2 height="40px" width="200px" style="vertical-align: middle; border: 2px solid #000">
                <b>{{ $item->nama }}</b><br>
                @if ($item->status == 'PNS' || $item->status == 'PKKK')
                    NIP. {{ $item->nip }}
                @else
                    NUPTK: {{ $item->nip }}
                @endif
            </td>
            <td height="40px" width="38px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->jk }}
            </td>
            <td height="40px" width="84px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->agama }}
            </td>
            <td height="40px" width="97px" align="center"
                style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                {{ $item->golongan }}
            </td>
            <td height="40px" width="97px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->tmt }}
            </td>
            <td height="40px" width="59px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->tahun }}
            </td>
            <td height="40px" width="59px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->bulan }}
            </td>
            <td height="40px" width="100px" align="center"
                style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                {{ $item->pendidikan }} / {{ $item->jurusan }}</td>
            <td height="40px" width="97px" align="center"
                style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                {{ $item->jabatan }}
            </td>
            <td height="40px" width="78px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->status }}
            </td>
            <td height="40px" width="84px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->jam_mengajar }}
            </td>
            <td height="40px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->s }}
            </td>
            <td height="40px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->i }}
            </td>
            <td height="40px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->a }}
            </td>
            <td height="40px" width="39px" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->h }}
            </td>
            <td height="40px" width="77px" style="vertical-align: middle; border: 2px solid #000"></td>
        </tr>
        @php
            $index++;
        @endphp
    @endforeach
    <tr style="height: 17px"></tr>
    <tr>
        <td></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"><?php echo ucwords(strtolower($sekolah->kecamatan)); ?>, {{ '  ' . periode($sekolah->periode) }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Kepala {{ $sekolah->nama_sekolah }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">{{ $sekolah->nama_kepala_sekolah }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">NIP. {{ $sekolah->nip_kepala_sekolah }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
    </tr>
</table>
