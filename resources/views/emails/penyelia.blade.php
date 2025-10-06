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
    <br>Terdapat satu permohonan {{ $action_penyelia2 }} tempahan bilik {{ $action_penyelia }}.
    <br /><br />
    Butiran adalah seperti berikut:
</p>
<br>
<p>

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

    <tr>
        <td>Catatan Bilik</td>
        <td>:</td>
        <td>{{ $catatan_room }}</td>
    </tr>

    <tr>
        <td>Status</td>
        <td>:</td>
        <td>{{ $status_bilik }}</td>
    </tr>

    <tr>
        <td>URL
        <td>:</td>
        </td>
        <td>Untuk butiran seterusnya, sila klik <a href='{{ request()->getSchemeAndHttpHost() }}'>Sistem eTempah</a>
        </td>
    </tr>
</table>

</p>

<br>

<p>
    Sekian, terima kasih.
    <br>
    <br>
    Pentadbir eTempah MITI
    <br>
    <span style="font-size: x-small;">Kementerian Pelaburan Perdagangan &amp; Industri</span>
</p>
