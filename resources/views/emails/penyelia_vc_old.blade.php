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
    Terdapat satu permohonan tempahan VC {{ $action_penyelia_vc }}.
</p>

<p>Butiran adalah seperti berikut:</p>

<p><u><b>Maklumat Pemohon</b></u></p>
<table style="border: 0ch">
    <tr>
        <td>ID Permohonan</td>
        <td>:</td>
        <td>{{ $id }}</td>
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
        <td>Tarikh/Masa Mula</td>
        <td>:</td>
        <td>{{ $tarikh_mula }}</td>
    </tr>
    <tr>
        <td>Tarikh/Masa Tamat</td>
        <td>:</td>
        <td>{{ $tarikh_hingga }}</td>
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

        <tr>
            <td>Status Bilik</td>
            <td>:</td>
            <td>{{ $status_bilik }}</td>
        </tr>

        @if ($status_bilik_id == '4' || $status_bilik_id == '12' || $status_bilik_id == '13')
            <tr>
                <td>Alasan Ditolak / Dibatalkan</td>
                <td>:</td>
                <td>{{ $komen_ditolak }}</td>
            </tr>
        @endif
    @endif

</table>

<p><u><b>Maklumat VC</b></u></p>

@if (!empty($webex))
    <table>
        <tr>
            <td>Akaun WEBEX</td>
            <td>:</td>
            <td>{{ $webex }}</td>
        </tr>


        @if ($webex == 'TIDAK')
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
            <td>{{ $status_vc }}</td>
        </tr>

    </table>
@else
    <i>-Tiada Permohonan VC-</i>
@endif
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
