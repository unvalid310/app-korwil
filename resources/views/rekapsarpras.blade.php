<table>
    <tr>
        <td colspan=7 align="center">REKAP DATA SARANA DAN PRASARANA</td>
    </tr>
    <tr>
        <td colspan=7 align="center">TAHUN PELAJARAN {{ $sekolah->tahun_ajar }}</td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td colspan=2>NAMA SEKOLAH</td>
        <td>: {{ $sekolah->nama_sekolah }}</td>
        <td></td>
        <td colspan="2">KECAMATAN</td>
        <td>: {{ $sekolah->kecamatan }}</td>
    </tr>
    <tr>
        <td colspan=2>TANGGAL BERDIRI</td>
        <td>: {{ $sekolah->tanggal_berdiri }}</td>
        <td></td>
        <td colspan="2">KABUPATEN</td>
        <td>: {{ $sekolah->kabupaten }}</td>
    </tr>
    <tr>
        <td colspan=2>NPSN/NSSS</td>
        <td>: {{ $sekolah->npsn_nsss }}</td>
        <td></td>
        <td colspan="2">PROVINSI</td>
        <td>: {{ $sekolah->provinsi }}</td>
    </tr>
    <tr>
        <td colspan=2>BULAN</td>
        <td>: </td>
        <td></td>
        <td colspan="2"></td>
        <td>: </td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td rowspan=2 align="center" width="43px">NO</td>
        <td rowspan=2 colspan="2" align="center" width="150px">RUANGAN</td>
        <td colspan="3" align="center">KONDISI</td>
        <td align="center">JUMLAH</td>
    </tr>
    <tr>
        <td align="center" width="54px">B</td>
        <td align="center" width="54px">RR</td>
        <td align="center" width="54px">RB</td>
    </tr>
    {{-- body --}}
    @php
        $index = 1;
    @endphp
    @foreach ($sarpras as $item)
        <tr>
            <td align="center" style="width: 43px">{{ $index }}</td>
            <td colspan="2" style="width: 150px">{{ $item->ruang }}</td>
            <td align="center">
                @if ($item->kondisi == 'B')
                    &#10003;
                @endif
            </td>
            <td align="center">
                @if ($item->kondisi == 'RR')
                    &#10003;
                @endif
            </td>
            <td align="center">
                @if ($item->kondisi == 'RB')
                    &#10003;
                @endif
            </td>
            <td align="center">{{ $item->jumlah }}</td>
        </tr>
        @php
            $index++;
        @endphp
    @endforeach

    <tr style="height: 17px"></tr>
    <tr>
        <td colspan="2" style="width: 150px">Jumlah sarana dan Prasarana Berdasarkan</td>
        <td colspan="2">: Hak Milik</td>
        <td></td>
        <td colspan="2" style="width: 150px"><?php echo ucwords(strtolower($sekolah->kecamatan)); ?>, {{ '  ' . periode($sekolah->periode) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="width: 150px">Tanah</td>
        <td colspan="2">: Ha</td>
        <td></td>
        <td colspan="2" style="width: 150px">Kepala {{ $sekolah->nama_sekolah }}</td>
    </tr>
    <tr>
        <td colspan="2" style="width: 150px">a. Status Tanah</td>
        <td colspan="2">: Hak Milik</td>
        <td></td>
        <td colspan="2" style="width: 150px"></td>
    </tr>
    <tr>
        <td colspan="2" style="width: 150px">b. Luas Tanah</td>
        <td colspan="2">: {{ $sekolah->luas_tanah }} m2</td>
        <td></td>
        <td colspan="2" style="width: 150px"></td>
    </tr>
    <tr>
        <td colspan="2" style="width: 150px">c. Luas bangunan</td>
        <td colspan="2">: {{ $sekolah->luas_bangunan }} m2</td>
        <td></td>
        <td colspan="2" style="width: 150px"></td>
    </tr>
    <tr>
        <td colspan="2" style="width: 150px">d. Luas Pekarangan</td>
        <td colspan="2">: {{ $sekolah->luas_pekarangan }} m2</td>
        <td></td>
        <td colspan="2" style="width: 150px">{{ $sekolah->nama_kepala_sekolah }}</td>
    </tr>
    <tr>
        <td colspan="2" style="width: 150px">e. Luas Kebun Sekolah</td>
        <td colspan="2">: {{ $sekolah->luas_kebun }} m2</td>
        <td></td>
        <td colspan="2" style="width: 150px">NIP. {{ $sekolah->nip_kepala_sekolah }}</td>
    </tr>
</table>
