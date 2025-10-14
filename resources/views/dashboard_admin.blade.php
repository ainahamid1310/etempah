@extends('layouts.backend_admin')

@section('css')

@endsection

@section('js_themes')
    <link href="/vendor/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="/global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
    {{-- <script src="/global_assets/js/demo_pages/fullcalendar_basic.js"></script> --}}
    <script src="assets/js/fullcalendar_basichome.js"></script>

    <script src="/global_assets/js/demo_charts/echarts/light/pies/pie_basic.js"></script>
    <script src="/global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>
    <script src="/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="/global_assets/js/plugins/visualization/c3/c3.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>

@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        {{-- <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama </a> --}}
        <span class="breadcrumb-item active"> Laman Utama </span>

    </div>
@endsection

@section('content')
<style>
.fc td, .fc th {
  cursor: pointer;
}
</style>

    @role('super-admin|approver-room|approver-vc')
        <div class="card">

            <div class="text-center">

                <div class="card-header bg-light header-elements-inline">

                    <h5 class="card-title">Tempahan @role('super-admin|approver-room|biz-point|pmsb')
                            Bilik
                        @else
                            VC
                        @endrole {{ now()->year }}</h5>

                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-3">

                        <div class="card border-y-2 border-top-green-300 border-bottom-green-600 rounded-0 alpha-success">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h2 class="font-weight-semibold mb-0">{{ $status['jumlah'] }}</h2>
                                    <div class="list-icons ml-auto">
                                        <i class="icon-sigma"></i>
                                    </div>
                                </div>

                                <div>
                                    @role('super-admin|approver-room')
                                        <a href="admin/application_room/3">Jumlah Permohonan</a>
                                        @elserole('approver-vc')
                                        <a href="admin/application_vc/3">Jumlah Permohonan</a>
                                    @endrole

                                </div>
                            </div>

                            <div class="chart" id="today-revenue"></div>
                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="card border-y-2 border-top-blue-300 border-bottom-blue-600 rounded-0 alpha-danger">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h2 class="font-weight-semibold mb-0">{{ $status['baru'] }}</h2>
                                    <div class="list-icons ml-auto">
                                        <i class="icon-new"></i>
                                    </div>
                                </div>

                                <div>
                                    @role('super-admin|approver-room')
                                        <a href="admin/application_room/1">Permohonan Baru</a>
                                        @elserole('approver-vc')
                                        <a href="admin/application_vc/4">Tindakan Oleh Pentadbir Bilik</a>
                                    @endrole
                                </div>
                            </div>

                            <div class="chart" id="today-revenue"></div>
                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="card border-y-2 border-top-pink-300 border-bottom-pink-600 rounded-0 alpha-primary">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h2 class="font-weight-semibold mb-0">{{ $status['dalam_proses'] }}</h2>
                                    <div class="list-icons ml-auto">
                                        <i class="icon-hour-glass2"></i>
                                    </div>
                                </div>

                                <div>
                                    @role('super-admin|approver-room')
                                        <a href="admin/application_room/5">Permohonan
                                            Pembatalan</a>
                                        @elserole('approver-vc')
                                        <a href="admin/application_vc/5">Permohonan Baru</a>
                                    @endrole
                                </div>
                            </div>

                            <div class="chart" id="today-revenue"></div>
                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="card border-y-3 border-top-orange-300 border-bottom-orange-600 rounded-0 alpha-orange">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h2 class="font-weight-semibold mb-0">{{ $status['selesai'] }}</h2>
                                    <div class="list-icons ml-auto">
                                        <i class="icon-archive"></i>
                                    </div>
                                </div>

                                <div>

                                    @role('super-admin|approver-room')
                                        <a href="admin/application_room/6">Selesai</a>
                                        @elserole('approver-vc')
                                        <a href="admin/application_vc/6">Selesai</a>
                                    @endrole
                                </div>
                            </div>

                            <div class="chart" id="today-revenue"></div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    @endrole
    <div class="row">
        <div class="col-md-12">
            <!-- Simple interaction -->
            <div class="card">
                <div class="card-header header-elements-inline alpha-success">
                    <h5 class="card-title">Kalendar @role('super-admin|approver-room|biz-point|pmsb')
                            Bilik
                        @else
                            VC
                        @endrole
                    </h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- <div class="fullcalendar-basic"></div> --}}
                    <div class="fullcalendar-basic fc" id="fullcalendar-basic"></div>
                    {{-- <div class="chart" id="c3-bar-chart"></div> --}}
                </div>
            </div>
            <!-- /simple interaction -->
        </div>

    </div>

    <div class="card">

        <div class="card">
            <div class="card-header header-elements-inline alpha-success">
                <h5 class="card-title">Tempahan Hari ini @role('super-admin|approver-room|biz-point|pmsb')
                        (Bilik)
                    @else
                        (VC)
                    @endrole
                </h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <table class="table datatable-basic table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bil.</th>
                        <th>Nama Mesyuarat</th>
                        <th>Nama Bilik/lokasi</th>
                        <th>Tarikh (Masa)</th>
                        <th>Pengerusi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $x = 1;
                    ?>
                    @foreach ($today_list as $today)
                        <tr>
                            <td>{{ $today->id }}</td>
                            <td><?php echo $x++; ?></td>
                            <td>
                                @role('super-admin|approver-room')
                                    <a
                                        href="admin/application_room/show/{{ encrypt($today->id) }}">{{ $today->nama_mesyuarat }}</a>
                                    @elserole('pmsb|biz-point')
                                    {{ $today->nama_mesyuarat }}
                                    @elserole('approver-vc')
                                    <a
                                        href="admin/application_vc/show/{{ encrypt($today->id) }}">{{ $today->nama_mesyuarat }}</a>
                                @endrole
                            </td>
                            <td>{{ $today->nama_bilik }}</td>
                            <td>{{ $today->tarikh_mula }} - {{ $today->tarikh_hingga }} <br>
                                ({{ date('h:i A', strtotime($today->masa_mula)) }} -
                                {{ date('h:i A', strtotime($today->masa_hingga)) }})
                            </td>
                            <td>{{ $today->nama_pengerusi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('script')
@endsection
