@php
    $usia = ['5', '6', '7', '8', '9', '10', '11', '12', '13'];
    $agama = ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'LAIN-LAIN'];
    $alasan = ['', 'ALASAN', 'SAKIT', 'IZIN', 'ALFA', 'JUMLAH'];
@endphp
<table>
    <tr>
        <td colspan='{{ count($kelas) * 2 + count($usia) + count($agama) * 2 + 6 }}' align="center">
            PEMERINTAH DAERAH KABUPATEN BANYUASIN
        </td>
    </tr>
    <tr>
        <td colspan='{{ count($kelas) * 2 + count($usia) + count($agama) * 2 + 6 }}' align="center">
            {{ $sekolah->nama_sekolah }}
        </td>
    </tr>
    <tr>
        <td colspan='{{ count($kelas) * 2 + count($usia) + count($agama) * 2 + 6 }}' align="center">KEADAAN
            SISWA
        </td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td width="187px">NAMA SEKOLAH</td>
        <td colspan="{{ (count($kelas) - 1) * 2 }}">: {{ $sekolah->nama_sekolah }}</td>
        <td></td>
        <td colspan="7">KECAMATAN</td>
        <td colspan="11">: {{ $sekolah->kecamatan }}</td>
        <td colspan="4">BULAN</td>
        <td colspan="5">: {{ periode_bulan($bulan) }}</td>
    </tr>
    <tr>
        <td width="187px">TANGGAL BERDIRI</td>
        <td colspan="{{ (count($kelas) - 1) * 2 }}">: {{ $sekolah->tanggal_berdiri }}</td>
        <td></td>
        <td colspan="7">KABUPATEN</td>
        <td colspan="11">: {{ $sekolah->kabupaten }}</td>
        <td colspan="4">TAPEL</td>
        <td colspan="5">: {{ $sekolah->tahun_ajar }}</td>
    </tr>
    <tr>
        <td width="187px">NPSN/NSSS</td>
        <td colspan="{{ (count($kelas) - 1) * 2 }}">: {{ $sekolah->npsn_nsss }}</td>
        <td></td>
        <td colspan="7">PROVINSI</td>
        <td colspan="11">: {{ $sekolah->provinsi }}</td>
        <td colspan="4">ROMBEL</td>
        <td colspan="5">: {{ count($kelas) }}</td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td rowspan="3" align="center" width="187px" style="vertical-align: middle; border: 2px solid #000">KEADAAN
            SISWA
        </td>
        <td colspan="{{ count($kelas) * 2 + 2 }}" align="center"
            style="vertical-align: middle; border: 2px solid #000">
            KELAS</td>
        <td colspan="{{ count($usia) + 1 }}" align="center" style="vertical-align: middle; border: 2px solid #000">
            BERDASARKAN UMUR</td>
        <td colspan="{{ count($agama) * 2 }}" align="center" style="vertical-align: middle; border: 2px solid #000">
            BERDASARKAN AGAMA</td>
    </tr>
    <tr>
        @foreach ($kelas as $item)
            <td colspan="2" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->alias }}
            </td>
        @endforeach
        <td colspan="2" align="center" style="vertical-align: middle; border: 2px solid #000">JUMLAH</td>
        @foreach ($usia as $item)
            <td rowspan="2" align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                {{ $item }}
            </td>
        @endforeach
        <td rowspan="2" align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">LAIN-LAIN
        </td>
        @foreach ($agama as $item)
            <td colspan="2" align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item }}
            </td>
        @endforeach
    </tr>
    <tr>
        @foreach ($kelas as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">L</td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">P</td>
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">L</td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">P</td>
        @foreach ($agama as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">L</td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">P</td>
        @endforeach
    </tr>

    {{-- body --}}
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">Awal
            Bulan Lalu</td>
        @foreach ($kelas as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
            </td>
        @endforeach
        <td align="center" width="60px" style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
        </td>
        @foreach ($agama as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNI</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[0][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[0][$key]['l'] != 0 ? $siswa[0][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[0][$key]['p'] != 0 ? $siswa[0][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[0][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[0][$key]['l'] != 0 ? $agama_siswa[0][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[0][$key]['p'] != 0 ? $agama_siswa[0][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNA</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[1][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[1][$key]['l'] != 0 ? $siswa[1][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[1][$key]['p'] != 0 ? $siswa[1][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[1][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[1][$key]['l'] != 0 ? $agama_siswa[1][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[1][$key]['p'] != 0 ? $agama_siswa[1][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>

    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">Keluar
            Bulan Ini</td>
        @foreach ($kelas as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
        </td>
        @foreach ($agama as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNI</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[2][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[2][$key]['l'] != 0 ? $siswa[2][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[2][$key]['p'] != 0 ? $siswa[2][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[2][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[2][$key]['l'] != 0 ? $agama_siswa[2][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[2][$key]['p'] != 0 ? $agama_siswa[2][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNA</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[3][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[3][$key]['l'] != 0 ? $siswa[3][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[3][$key]['p'] != 0 ? $siswa[3][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[3][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[3][$key]['l'] != 0 ? $agama_siswa[3][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[3][$key]['p'] != 0 ? $agama_siswa[3][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>

    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">Masuk
            Bulan Ini</td>
        @foreach ($kelas as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
            </td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
        </td>
        @foreach ($agama as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNI</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[4][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[4][$key]['l'] != 0 ? $siswa[4][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[4][$key]['p'] != 0 ? $siswa[4][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[4][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[4][$key]['l'] != 0 ? $agama_siswa[4][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[4][$key]['p'] != 0 ? $agama_siswa[4][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNA</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[5][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[5][$key]['l'] != 0 ? $siswa[5][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[5][$key]['p'] != 0 ? $siswa[5][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[5][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[5][$key]['l'] != 0 ? $agama_siswa[5][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[5][$key]['p'] != 0 ? $agama_siswa[5][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>

    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">Murid
            Akhir Bulan Ini</td>
        @foreach ($kelas as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
        </td>
        @foreach ($agama as $item)
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNI</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[6][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[6][$key]['l'] != 0 ? $siswa[6][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[6][$key]['p'] != 0 ? $siswa[6][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[6][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[6][$key]['l'] != 0 ? $agama_siswa[6][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[6][$key]['p'] != 0 ? $agama_siswa[6][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>
    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">WNA</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[7][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[7][$key]['l'] != 0 ? $siswa[7][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[7][$key]['p'] != 0 ? $siswa[7][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word"></td>
        @foreach ($agama as $key => $item)
            @if (!empty($agama_siswa[7][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[7][$key]['l'] != 0 ? $agama_siswa[7][$key]['l'] : '' }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $agama_siswa[7][$key]['p'] != 0 ? $agama_siswa[7][$key]['p'] : '' }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
    </tr>

    <tr>
        <td align="left" width="187px" style="vertical-align: middle; border: 2px solid #000">TOTAL SELURUH</td>
        @foreach ($kelas as $key => $item)
            @if (!empty($siswa[6][$key]))
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[6][$key]['l'] }}</td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000">
                    {{ $siswa[6][$key]['p'] }}</td>
            @else
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
            @endif
        @endforeach
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        <td align="center" width="35px" style="vertical-align: middle; border: 2px solid #000"></td>
        @foreach ($usia as $item)
            <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
            </td>
        @endforeach
        <td align="center" width="60px"
            style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
        </td>
        @foreach ($agama as $item)
            <td colspan="2" align="center" style="vertical-align: middle; border: 2px solid #000"></td>
        @endforeach
    </tr>

    @php
        $total = 0;
        $u5 = 0;
        $u6 = 0;
        $u7 = 0;
        $u8 = 0;
        $u9 = 0;
        $u10 = 0;
        $u11 = 0;
        $u12 = 0;
        $u13 = 0;
    @endphp
    @if (count($kelas) == count($alasan))
        @foreach ($kelas as $key => $item)
            @if ($key == 0)
                <tr>
                    <td colspan="{{ count($kelas) * 2 + 1 }}" style="vertical-align: middle; border: 2px solid #000">
                    </td>
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                </tr>
            @elseif ($key == 1)
                <tr>
                    <td width="187px" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $alasan[$key] }}
                    </td>
                    @foreach ($kelas as $as)
                        <td colspan="2" align="center"
                            style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                            {{ $as->alias }}
                        </td>
                    @endforeach
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                </tr>
            @else
                <tr>
                    <td width="187px"
                        style="vertical-align: middle; border: 2px solid #000; {{ $key == 5 ? 'font-weight: bold' : '' }}">
                        {{ $alasan[$key] }}
                    </td>
                    @foreach ($kelas as $as)
                        <td colspan="2" align="center"
                            style="vertical-align: middle; border: 2px solid #000; {{ $key == 5 ? 'font-weight: bold' : '' }}">
                            0
                        </td>
                    @endforeach
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                </tr>
            @endif

            @php
                $u5 = $u5 + $usia_siswa[$item->id_kelas]['u5'];
                $u6 = $u6 + $usia_siswa[$item->id_kelas]['u6'];
                $u7 = $u7 + $usia_siswa[$item->id_kelas]['u7'];
                $u8 = $u8 + $usia_siswa[$item->id_kelas]['u8'];
                $u9 = $u9 + $usia_siswa[$item->id_kelas]['u9'];
                $u10 = $u10 + $usia_siswa[$item->id_kelas]['u10'];
                $u11 = $u11 + $usia_siswa[$item->id_kelas]['u11'];
                $u12 = $usia_siswa[$item->id_kelas]['u12'];
                $u13 = $u13 + $usia_siswa[$item->id_kelas]['u13'];
            @endphp
        @endforeach
        <tr>
            <td colspan="{{ count($kelas) * 2 + 1 }}">
            </td>
            <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">JUMLAH
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u5 != 0 ? $u5 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u6 != 0 ? $u6 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u7 != 0 ? $u7 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u8 != 0 ? $u8 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u9 != 0 ? $u9 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u10 != 0 ? $u10 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u11 != 0 ? $u11 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u12 != 0 ? $u12 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u13 != 0 ? $u13 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word000; font-weight: bold">
                {{ $total }}
            </td>
            @foreach ($agama as $a)
                <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
            @endforeach
        </tr>
    @else
        @foreach ($kelas as $key => $item)
            @if ($key == 0)
                <tr>
                    <td colspan="{{ count($kelas) * 2 + 1 }}" style="vertical-align: middle; border: 2px solid #000">
                    </td>
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                </tr>
            @elseif ($key == 1)
                <tr>
                    <td width="187px" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $alasan[$key] }}
                    </td>
                    @foreach ($kelas as $as)
                        <td colspan="2" align="center"
                            style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                            {{ $as->alias }}
                        </td>
                    @endforeach
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                </tr>
            @elseif ($key > 1 && $key <= 5)
                <tr>
                    <td width="187px"
                        style="vertical-align: middle; border: 2px solid #000; {{ $key == 5 ? 'font-weight: bold' : '' }}">
                        {{ $alasan[$key] }}
                    </td>
                    @foreach ($kelas as $as)
                        <td colspan="2" align="center"
                            style="vertical-align: middle; border: 2px solid #000; {{ $key == 5 ? 'font-weight: bold' : '' }}">
                            0
                        </td>
                    @endforeach
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                </tr>
            @else
                <tr>
                    <td colspan="{{ count($kelas) * 2 + 1 }}"></td>
                    <td colspan="2" style="vertical-align: middle; border: 2px solid #000000; font-weight: bold">
                        {{ $item->kelas }}
                    </td>
                    @foreach ($usia as $u_siswa)
                        <td align="center" width="32px" style="vertical-align: middle; border: 2px solid #000">
                            {{ $usia_siswa[$item->id_kelas]['u' . $u_siswa] != 0 ? $usia_siswa[$item->id_kelas]['u' . $u_siswa] : '' }}
                        </td>

                        @php
                            $total = $total + $usia_siswa[$item->id_kelas]['u' . $u_siswa];
                        @endphp
                    @endforeach
                    <td align="center" width="32px"
                        style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word">
                    </td>
                    @foreach ($agama as $a)
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                        <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    @endforeach
                    <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                    <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                </tr>
            @endif

            @php
                $u5 = $u5 + $usia_siswa[$item->id_kelas]['u5'];
                $u6 = $u6 + $usia_siswa[$item->id_kelas]['u6'];
                $u7 = $u7 + $usia_siswa[$item->id_kelas]['u7'];
                $u8 = $u8 + $usia_siswa[$item->id_kelas]['u8'];
                $u9 = $u9 + $usia_siswa[$item->id_kelas]['u9'];
                $u10 = $u10 + $usia_siswa[$item->id_kelas]['u10'];
                $u11 = $u11 + $usia_siswa[$item->id_kelas]['u11'];
                $u12 = $usia_siswa[$item->id_kelas]['u12'];
                $u13 = $u13 + $usia_siswa[$item->id_kelas]['u13'];
            @endphp
        @endforeach
        <tr>
            <td colspan="{{ count($kelas) * 2 + 1 }}">
            </td>
            <td colspan="2" style="vertical-align: middle; border: 2px solid #000; font-weight: bold">JUMLAH
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u5 != 0 ? $u5 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u6 != 0 ? $u6 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u7 != 0 ? $u7 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u8 != 0 ? $u8 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u9 != 0 ? $u9 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u10 != 0 ? $u10 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u11 != 0 ? $u11 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u12 != 0 ? $u12 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; font-weight: bold">{{ $u13 != 0 ? $u13 : '' }}
            </td>
            <td align="center" width="32px"
                style="vertical-align: middle; border: 2px solid #000; word-wrap: break-word000; font-weight: bold">
                {{ $total }}
            </td>
            @foreach ($agama as $a)
                <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
                <td align="center" style="vertical-align: middle; border: 2px solid #000"></td>
            @endforeach
        </tr>
    @endif
    <tr style="height: 17px"></tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8"><?php echo ucwords(strtolower($sekolah->kecamatan)); ?>, {{ '  ' . periode($sekolah->periode) }}</td>
    </tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8">Kepala {{ $sekolah->nama_sekolah }}</td>
    </tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8" height="17px"></td>
    </tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8" height="17px"></td>
    </tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8" height="17px"></td>
    </tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8">{{ $sekolah->nama_kepala_sekolah }}</td>
    </tr>
    <tr>
        <td colspan="{{ count($kelas) * 2 + count($usia) + (count($agama) - 2) * 2 }}"></td>
        <td colspan="8">NIP. {{ $sekolah->nip_kepala_sekolah }}</td>
    </tr>
</table>
