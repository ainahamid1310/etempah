@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="/global_assets/js/plugins/pickers/daterangepicker.js"></script>
    <script src="/global_assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script src="/global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script src="/global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script src="/global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script src="/global_assets/js/plugins/notifications/jgrowl.min.js"></script>
    <script src="/global_assets/js/demo_pages/picker_date.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_print.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Laporan Tempahan VC</span>

    </div>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header header-elements-inline bg-light">
                <h5 class="card-title">Laporan Tempahan VC

                </h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>
            <form action="/laporan/vc">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Status: </label>
                                <div class="col-md-8">
                                    <select data-placeholder="Pilih Status" class="form-control select-search select-clear"
                                        name="status" data-fouc id="status">
                                        <option></option>
                                        {{-- <option value="0" {{ old('status', $status) == '0' ? 'selected' : '' }}>Semua
                                        </option> --}}
                                        <option value="2" {{ old('status', $status) == '2' ? 'selected' : '' }}>
                                            Baru</option>
                                        <option value="3" {{ old('status', $status) == '3' ? 'selected' : '' }}>
                                            Lulus</option>
                                        <option value="4" {{ old('status', $status) == '4' ? 'selected' : '' }}>
                                            Tolak</option>
                                        <option value="5" {{ old('status', $status) == '5' ? 'selected' : '' }}>
                                            Batal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh Mula: </label>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="date_start">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh Tamat: </label>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="date_end">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="cari" class="btn bg-info" value="cari">Cari </button>
                        <input class="btn bg-danger" type="button" value="Set Semula"
                            onclick='window.location.reload(true);'>

                    </div>

                </div>
            </form>
            <div class="content">
                <div class="card">
                    {{-- <div class="card-header header-elements-inline">
                        <h5 class="card-title">Paparan Laporan Tempahan VC
                        </h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div> --}}

                    @if ($cari)
                        <table class="table datatable-button-print-basic">
                            <thead>
                                <tr>
                                    <th>Bil</th>
                                    <th>ID</th>
                                    <th>Program/Mesyuarat</th>
                                    <th>Nama Pemohon</th>
                                    <th>Bahagian</th>
                                    <th>Tarikh/Masa</th>
                                    <th>Bilik</th>
                                    <th>Pengerusi</th>
                                    <th>Platform</th>
                                    <th>Catatan Pemohon</th>
                                    <th>Catatan Penyelia</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $x = 1; ?>
                                @foreach ($laporan_vcs as $laporan_vc)
                                    <td>{{ $x++ }}</td>
                                    <td>{{ $laporan_vc->application_id }}</td>
                                    <td><a
                                            href="/admin/application_vc/show/{{ encrypt($laporan_vc->application_id) }}">{{ $laporan_vc->nama_mesyuarat }}</a>
                                    </td>
                                    <td>{{ $laporan_vc->application->user->name }} <br>
                                    </td>
                                    <td> {{ $laporan_vc->application->user->profile->department->nama }}</td>
                                    <td> {{ date('d-m-Y', strtotime($laporan_vc->application->tarikh_mula)) }} -
                                        {{ date('d-m-Y', strtotime($laporan_vc->application->tarikh_hingga)) }}
                                        <br>
                                        ({{ date('h:i A', strtotime($laporan_vc->application->tarikh_mula)) }} -
                                        {{ date('h:i A', strtotime($laporan_vc->application->tarikh_hingga)) }})
                                    </td>
                                    <td> {{ $laporan_vc->application->room->nama }}</td>
                                    <td>
                                        @if ($laporan_vc->application->nama_pengerusi != null)
                                            {{ $laporan_vc->application->nama_pengerusi }}
                                        @else
                                            {{ $laporan_vc->application->kategori_pengerusi }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($laporan_vc->webex == 1)
                                            WEBEX
                                            ({{ $laporan_vc->id_webex }})
                                        @else
                                            {{ $laporan_vc->nama_aplikasi }}
                                        @endif
                                    </td>
                                    <td> {{ $laporan_vc->catatan }}</td>
                                    <td> {{ $laporan_vc->catatan_penyelia }}</td>
                                    <td> {{ $laporan_vc->statusVc->status_pentadbiran }}</td>

                                    </tr>
                                @endforeach
                                @if ($laporan_vcs and count($laporan_vcs) == 0)
                                    <tr>
                                        <td colspan="9" style="text-align: center; font-weight:bold">Tiada Rekod
                                            Dijumpai</td>
                                    <tr>
                                @endif
                    @endif
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.daterange-single').val("");
        });
    </script>
@endsection
