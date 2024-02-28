@php
    $index = 1;
    $dates = [];
    for ($d = 1; $d <= 31; $d++) {
        $time = mktime(12, 0, 0, $bulan, $d, $tahun);
        if (date('m', $time) == $bulan) {
            if (date('w', $time) != 0) {
                # code...
                $dates[] = date('d', $time);
            }
        }
    }
@endphp
<table>
    <tr>
        <td colspan={{ count($dates) + 9 }} align="center">DAFTAR HADIR GURU DAN TENAGA PENDIDIK</td>
    </tr>
    <tr>
        <td colspan={{ count($dates) + 9 }} align="center">{{ $sekolah->nama_sekolah }}</td>
    </tr>
    <tr>
        <td colspan={{ count($dates) + 9 }} align="center">KECAMATAN {{ $sekolah->kecamatan }}</td>
    </tr>
    <tr>
        <td colspan={{ count($dates) + 9 }} align="center">TAHUN PELAJARAN {{ $sekolah->tahun_ajar }}</td>
    </tr>
    <tr>
        <td colspan={{ count($dates) + 9 }} align="center">BULAN
            {{ strtoupper(explode(' - ', periode($sekolah->periode))[0]) }}
        </td>
    </tr>
    <tr style="height: 17px"></tr>
    <tr>
        <td rowspan=2 height="36px" width="35px" align="center" style="vertical-align: middle; border: 2px solid #000">
            NO
        </td>
        <td rowspan=2 height="36px" width="200px" align="center"
            style="vertical-align: middle; border: 2px solid #000">
            NAMA / NIP
        </td>
        <td rowspan=2 height="36px" width="46px" align="center"
            style="vertical-align: middle; border: 2px solid #000">GOL</td>
        <td rowspan=2 height="36px" width="94px" align="center"
            style="vertical-align: middle; border: 2px solid #000">
            JABATAN
        </td>
        <td colspan={{ count($dates) }} height="18px" align="center"
            style="vertical-align: middle; border: 2px solid #000">
            ABSENSI
        </td>
        <td colspan=5 height="18px" align="center" style="vertical-align: middle; border: 2px solid #000">
            JUMLAH
        </td>
    </tr>
    <tr>
        @foreach ($dates as $item)
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item }}
            </td>
        @endforeach

        <td align="center" style="vertical-align: middle; border: 2px solid #000">
            H
        </td>
        <td align="center" style="vertical-align: middle; border: 2px solid #000">
            S
        </td>
        <td align="center" style="vertical-align: middle; border: 2px solid #000">
            I
        </td>
        <td align="center" style="vertical-align: middle; border: 2px solid #000">
            A
        </td>
        <td align="center" style="vertical-align: middle; border: 2px solid #000">
            J
        </td>
    </tr>

    {{-- body --}}
    @foreach ($absensi as $item)
        <tr>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $index }}
            </td>
            <td style="vertical-align: middle; border: 2px solid #000">
                <b>{{ $item->nama }}</b><br>
                @if ($item->status == 'PNS' || $item->status == 'PKKK')
                    NIP. {{ $item->nip }}
                @else
                    NUPTK: {{ $item->nip }}
                @endif
            </td>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                @php
                    $golongan = explode('/', $item->golongan);
                @endphp
                {{ count($golongan) > 1 ? $golongan[1] : $golongan[0] }}
            </td>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                {{ $item->jabatan }}
            </td>
            @foreach ($dates as $h)
                @php
                    $hari = $tahun . '-' . $bulan . '-' . $h;
                @endphp
                @if ($hari == $item->hari)
                    <td align="center" style="vertical-align: middle; border: 2px solid #000">
                        @if ($item->ket == 0)
                            A
                        @elseif ($item->ket == 1)
                            H
                        @elseif ($item->ket == 2)
                            I
                        @elseif ($item->ket == 3)
                            S
                        @elseif ($item->ket == 4)
                            L
                        @endif
                    </td>
                @else
                    <td align="center" style="vertical-align: middle; border: 2px solid #000">-</td>
                @endif
            @endforeach
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                @php
                    $jml = 0;
                @endphp

                @foreach ($dates as $h)
                    @php
                        $hari = $tahun . '-' . $bulan . '-' . $h;
                    @endphp
                    @if ($hari == $item->hari)
                        @if ($item->ket == 1)
                            @php
                                $jml = $jml + 1;
                            @endphp
                        @endif
                    @endif
                @endforeach
                {{ $jml }}
            </td>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                @php
                    $jml = 0;
                @endphp

                @foreach ($dates as $h)
                    @php
                        $hari = $tahun . '-' . $bulan . '-' . $h;
                    @endphp
                    @if ($hari == $item->hari)
                        @if ($item->ket == 3)
                            @php
                                $jml = $jml + 1;
                            @endphp
                        @endif
                    @endif
                @endforeach
                {{ $jml }}
            </td>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                @php
                    $jml = 0;
                @endphp

                @foreach ($dates as $h)
                    @php
                        $hari = $tahun . '-' . $bulan . '-' . $h;
                    @endphp
                    @if ($hari == $item->hari)
                        @if ($item->ket == 2)
                            @php
                                $jml = $jml + 1;
                            @endphp
                        @endif
                    @endif
                @endforeach
                {{ $jml }}
            </td>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                @php
                    $jml = 0;
                @endphp

                @foreach ($dates as $h)
                    @php
                        $hari = $tahun . '-' . $bulan . '-' . $h;
                    @endphp
                    @if ($hari == $item->hari)
                        @if ($item->ket == 0)
                            @php
                                $jml = $jml + 1;
                            @endphp
                        @endif
                    @endif
                @endforeach
                {{ $jml }}
            </td>
            <td align="center" style="vertical-align: middle; border: 2px solid #000">
                @php
                    $jml = 0;
                @endphp

                @foreach ($dates as $h)
                    @php
                        $hari = $tahun . '-' . $bulan . '-' . $h;
                    @endphp
                    @if ($hari == $item->hari)
                        @if ($item->ket == 1)
                            @php
                                $jml = $jml + 1;
                            @endphp
                        @endif
                    @endif
                @endforeach
                {{ $jml }}
            </td>
        </tr>
        @php
            $index++;
        @endphp
    @endforeach

    <tr style="height: 17px"></tr>
    <tr>
        <td></td>
        <td colspan=2>Mengetahui,</td>
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
        <td colspan=6><?php echo ucwords(strtolower($sekolah->kecamatan)); ?>, {{ '  ' . periode($sekolah->periode) }}</td>
    </tr>
    <tr>
        <td></td>
        <td colspan=2>Pengawas Pembina TK / SD</td>
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
        <td colspan=6>Kepala {{ $sekolah->nama_sekolah }}</td>
    </tr>
    <tr>
        <td></td>
        <td class=xl6td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td class=xl6td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td class=xl6td>
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
    </tr>
    <tr>
        <td></td>
        <td colspan=3>{{ $sekolah->nama_pengawas }}</td>
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
        <td colspan=6 class=xl76>{{ $sekolah->nama_kepala_sekolah }}</td>
    </tr>
    <tr>
        <td></td>
        <td colspan=3>NIP. {{ $sekolah->nip_pengawas }}</td>
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
        <td colspan=6 class=xl75>NIP. {{ $sekolah->nip_kepala_sekolah }}</td>
    </tr>
</table>
