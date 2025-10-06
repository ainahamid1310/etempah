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
        <span class="breadcrumb-item active"> Laporan Aduan</span>

    </div>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header header-elements-inline bg-light">
                <h5 class="card-title">Laporan Aduan</h5>
            </div>
            <form action="/laporan/aduan">
                {{ csrf_field() }}
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Nama Bilik: </label>
                                <div class="col-md-8">
                                    <select class="form-control select-search" data-placeholder="Pilih Bilik"
                                        name="nama_bilik" data-fouc>
                                        <option></option>
                                        @foreach ($biliks as $bilik)
                                            @if ($nama_bilik == $bilik->id)
                                                <option value="{{ $bilik->id }}" selected>
                                                    {{ $bilik->nama }}

                                                </option>
                                            @else
                                                <option value="{{ $bilik->id }}"> {{ $bilik->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Nama Bahagian: </label>
                                <div class="col-md-8">
                                    <select class="form-control select-search" data-placeholder="Pilih Bahagian"
                                        name="bahagian" data-fouc>
                                        <option></option>
                                        @foreach ($bahagians as $bahagian)
                                            @if ($bahagianx == $bahagian->id)
                                                <option value="{{ $bahagian->id }}" selected>
                                                    {{ $bahagian->nama }}</option>
                                            @else
                                                <option value="{{ $bahagian->id }}">
                                                    {{ $bahagian->nama }}
                                                </option>
                                            @endif
                                        @endforeach
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
                                    {{-- <input class="form-control daterange-single" name="datetime"> --}}
                                    <input type="date" class="form-control" value="" name="datedari"
                                        placeholder="Pilih Tarikh Mula">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh Tamat: </label>
                                <div class="col-md-3">
                                    {{-- <input class="form-control daterange-single" name="datetime"> --}}
                                    <input type="date" class="form-control" value="" name="datehingga"
                                        placeholder="Pilih Tarikh Tamat">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="cari" class="btn bg-info" value="cari">Cari </button>
                        <a href="{{ url('/laporan/aduan') }}" role="button"><button type="button"
                                class="btn bg-danger">Semula</button></a>

                    </div>

                </div>
            </form>
            <div class="content">
                <div class="card">
                    @if ($cari)
                        <table class="table datatable-button-print-basic">
                            <thead>
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Pemohon Pengadu</th>
                                    <th>Bahagian</th>
                                    <th>Tarikh/Masa</th>
                                    <th>Bilik</th>
                                    <th>Program/Mesyuarat</th>
                                    <th>Aduan</th>
                                    <th>Cadangan Penambahbaikan</th>


                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($carian as $index => $b)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $b->nama_pemohon }} <br> ({{ $b->smbg }})</td>

                                        <td> {{ $b->bahagian }}</td>

                                        <td> {{ \Carbon\Carbon::parse($b->tarikh_reports)->format('d/m/Y')}} <br> {{ $b->masa_reports }} <br>

                                        </td>

                                        <td> {{ $b->nama_bilik }}</td>

                                        <td> {{ $b->nama_mesyuarat }}</td>

                                        <td> {{ $b->aduan }}</td>

                                        <td> {{ $b->cadangan }}</td>

                                    </tr>
                                @endforeach
                                @if ($carian and count($carian) == 0)
                                    <tr>
                                        <td colspan="8" style="text-align: center; font-weight:bold">Tiada Rekod
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
