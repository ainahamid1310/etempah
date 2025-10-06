@extends('layouts.backend_applicant')

@section('js_themes')
<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
<div class="breadcrumb">
    <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
    <span class="breadcrumb-item active"> Bilik Mesyuarat  >  Profail Bilik Mesyuarat</span>
</div>
@endsection

@section('content')


<div class="card">
    <div class="card-header header-elements-sm-inline">
        <h6 class="card-title">Profail Bilik Mesyuarat</h6>
    </div>

    <div class="card-body">

    {{-- <div class="table-responsive"> --}}

        <table class="table datatable-basic table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 19%">Nama Bilik</th>
                    <th style="width: 5%">Kapasiti</th>
                    <th style="width: 20%">Pelulus</th>
                    <th style="width: 19%">Petugas</th>
                    <th style="width: 5%">Status</th>
                    <th style="width: 32%" class="text-center">Fasaliti</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                <tr>
                    <td>{{ $room->nama }}</td>
                    <td><a href="#">{{ $room->kapasiti }}</a></td>
                    <td>Nama Pelulus</td>
                    <td>Nama Petugas</td>
                    <td>
                        @if ($room->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($room->status == 'tidak aktif')
                            <span class="badge badge-success">Tidak Aktif</span>
                        @endif
                    </td>

                    <td>
                        <a href="/application/edit/"><span style="width: 20%;"><span class="badge badge-flat border-info text-info-600">Whiteboard</span></a>
                        <a href="/application/edit/"><span style="width: 20%;"><span class="badge badge-flat border-info text-info-600">Mic.</span></a>
                        <a href="/application/edit/"><span style="width: 20%;"><span class="badge badge-flat border-info text-info-600">VC</span></a>
                        <a href="/application/edit/"><span style="width: 20%;"><span class="badge badge-flat border-info text-info-600">Projektor</span></a>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>



</div>
@endsection
