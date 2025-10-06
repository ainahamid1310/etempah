<style>
    p,
    table {
        font: 14px Arial, sans-serif;
    }

    h2 {
        font: 14px Arial, sans-serif;
        font-weight: bold;
    }
</style>

<p>Salam Sejahtera.</p>
<br>

<p>Tuan/Puan,</p>

<p>    
    Adalah dimaklumkan bahawa permohonan {{ $action_penyelia2 }} tempahan {{ $tempahan }} telah
    <b>{{ $action_pemohon }}</b>.
</p>

<p>Butiran adalah seperti berikut:</p>

<p><u><b>Maklumat Pemohon</b></u></p>
<table style="border: 0ch">


    <tr>
        <td>ID Batch</td>
        <td>:</td>
        <td>{{ $batch_id }}</td>
    </tr>
    <tr>
        <td>Nama Pemohon</td>
        <td>:</td>
        <td>{{ $nama_pemohon }}</td>
    </tr>
    <tr>
        <td>Bahagian</td>
        <td>:</td>
        <td>{{ $bahagian_pemohon }}</td>
    </tr>
    <tr>
        <td>Lokasi/Bilik</td>
        <td>:</td>
        <td>{{ $bilik }}</td>
    </tr>
      
    <tr>
        <td style="vertical-align: top;">Tarikh/Masa</td>
        <td style="vertical-align: top;">:</td>
        <td>
            <table cellpadding="0" cellspacing="0">
                @foreach ($senarai_tarikh as $index => $tarikh)
                    <tr>
                        <td style="vertical-align: top;">{{ $index + 1 }})</td>
                        <td>
                            {{ $tarikh['tarikh_mula'] }} hingga {{ $tarikh['tarikh_hingga'] }}
                            ({{ $tarikh['masa_mula'] }} - {{ $tarikh['masa_hingga'] }})
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>

    <tr>
        <td>Nama Mesyuarat</td>
        <td>:</td>
        <td>{{ $nama_mesyuarat }}</td>
    </tr>
    <tr>
        <td>Nama Pengerusi</td>
        <td>:</td>
        <td>{{ $nama_pengerusi }}</td>
    </tr>
    <tr>
        <td>Bilangan Tempahan</td>
        <td>:</td>
        <td>{{ $bilangan_tempahan }}</td>
    </tr>

    @if ($status_bilik != '')
        <tr>
            <td>Catatan Bilik</td>
            <td>:</td>
            <td>{{ $catatan_room }}</td>
        </tr>

        @if ($status_bilik_id == 2 ||
            $status_bilik_id == 3 ||
            $status_bilik_id == 4 ||
            $status_bilik_id == 5 ||
            $status_bilik_id == 6 ||
            $status_bilik_id == 7 ||
            $status_bilik_id == 12 ||
            $status_bilik_id == 13 ||
            $status_bilik_id == 14)
            <tr>
                <td>Catatan Pentadbir Bilik</td>
                <td>:</td>
                <td>{{ $catatan_room_penyelia }}</td>
            </tr>
        @endif
        <tr>
            <td>Status Bilik</td>
            <td>:</td>
            <td>{{ $status_bilik }}</td>
        </tr>

        @if ($status_bilik_id == '4' || $status_bilik_id == '12' || $status_bilik_id == '13')
            <tr>
                <td>Alasan Ditolak / Batal</td>
                <td>:</td>
                <td>{{ $komen_ditolak }}</td>
            </tr>

        @endif

    @endif
</table>

<p><u><b>Maklumat VC</b></u></p>
<table>
    @if ($apply_vc == 1)
        @if ($webex == 'YA')
            <tr>
                <td>Akaun WEBEX</td>
                <td>:</td>
                <td>{{ $webex }}</td>
            </tr>

            @if ($status_vc_id == 3 || $status_vc_id == 12)
                <tr>
                    <td>Log Masuk WEBEX</td>
                    <td>:</td>
                    <td>{{ $link_webex }}</td>
                </tr>

                <tr>
                    <td>ID WEBEX</td>
                    <td>:</td>
                    <td>{{ $id_webex }}</td>
                </tr>

                <tr>
                    <td>Kata Laluan WEBEX</td>
                    <td>:</td>
                    <td>{{ $password_webex }}</td>
                </tr>

                <tr>
                    <td>Tarikh Luput Kata Laluan WEBEX</td>
                    <td>:</td>
                    <td>{{ $password_expired }}</td>
                </tr>
            @endif
        @elseif($webex == 'TIDAK')
            <tr>
                <td>Nama Aplikasi</td>
                <td>:</td>
                <td>{{ $nama_aplikasi }}</td>
            </tr>
        @endif

        <tr>
            <td>Peralatan VC</td>
            <td>:</td>
            <td>{{ $peralatan }}</td>
        </tr>

        <tr>
            <td>Catatan Pemohon VC</td>
            <td>:</td>
            <td>{{ $catatan_vc }}</td>
        </tr>

        @if ($status_vc_id == 3 ||
            $status_vc_id == 4 ||
            $status_vc_id == 5 ||
            $status_vc_id == 10 ||
            $status_vc_id == 11 ||
            $status_vc_id == 12)
            <tr>
                <td>Catatan Pentadbir VC</td>
                <td>:</td>
                <td>{{ $catatan_penyelia_vc }}</td>
            </tr>
        @endif

        <tr>
            <td>Status VC</td>
            <td>:</td>
            <td>
                {{ $status_vc }}  @if(is_null($vc_komen_ditolak)) {{ $note ?? '' }} @endif                
            </td>
            
        </tr>        

        @if(!empty($vc_komen_ditolak))
            <tr>
                <td>Alasan Ditolak</td>
                <td>:</td>
                <td>{{ $vc_komen_ditolak}}</td>
            </tr>
        @endif
    @else
        <i>-Tiada Permohonan VC-</i>
    @endif
</table>
<br><br>
<p>Untuk butiran seterusnya, sila klik <a href='{{ request()->getSchemeAndHttpHost() }}'>Sistem eTempah</a></p>
<br>
<p>
    Sekian, terima kasih.
    <br>
    <br>
    <br>
    Pentadbir eTempah MITI
    <br><br>
    <span style="font-size: x-small;">Kementerian Pelaburan Perdagangan &amp; Industri</span>
</p>
