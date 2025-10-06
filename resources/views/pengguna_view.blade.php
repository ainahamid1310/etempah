@extends('layouts.backend_applicant')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Pengurusan Pengguna</span>
    </div>
@endsection

@section('content')
    <div class="card">
        {{-- <div class="card-header header-elements-inline">
        <h5 class="card-title">Senarai Pengguna</h5>
        <div class="header-elements">
            <div class="list-icons ml-3">
                <a href="/user/create" class="list-icons-item" placeholder="test"><button type="button" class="btn bg-blue btn-sm"><i class="icon-add mr-2"></i> Tambah Pengguna</button></p></a>
            </div>
        </div>
    </div> --}}
        <div class="card-header header-elements-sm-inline">
            <h5 class="card-title"><b>Senarai Program / Mesyuarat pada
                    {{ Carbon\Carbon::parse($tempah)->format('d-m-Y') }}</b></h5>

        </div>

        <table class="table datatable-basic table-hover" style="font-size:13px; font-family:arial">
            <thead>
                <tr>
                    <th style="width: 5%">Bil.</th>
                    <th style="width: 23%">Program / Mesyuarat</th>
                    <th style="width: 15%">Pengerusi</th>
                    <th style="width: 20%">Nama Bilik</th>
                    <th style="width: 20%">
                        <center>Tarikh</center>
                    </th>
                    <th style="width: 13%">
                        <center>Masa</center>
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $booking->nama_mesyuarat }}</td>
                        <td>
                            @if ($booking->nama_pengerusi != null)
                                {{ $booking->nama_pengerusi }}
                            @else
                                {{ $booking->kategori_pengerusi }}
                            @endif
                        </td>
                        <td>{{ $booking->nama_bilik }}</td>
                        <td>
                            @if ($booking->tarikh_mula == $booking->tarikh_hingga)
                                {{ Carbon\Carbon::parse($booking->tarikh_mula)->format('d-M-Y') }}
                            @else
                                {{ Carbon\Carbon::parse($booking->tarikh_mula)->format('d-M-Y') }} -
                                {{ Carbon\Carbon::parse($booking->tarikh_hingga)->format('d-M-Y') }}
                            @endif
                        </td>
                        <td>{{ Carbon\Carbon::parse($booking->masa_mula)->format('h:m A') }} -
                            {{ Carbon\Carbon::parse($booking->masa_hingga)->format('h:m A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>



    </div>
    <div>
        <button class="btn bg-success" onclick="history.back()" type="button">
            Kembali</button>
    </div>
@endsection
