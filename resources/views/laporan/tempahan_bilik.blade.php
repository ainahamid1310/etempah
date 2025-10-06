@extends('layouts.backend_admin')

@section('css')
    <style>
        table.myText tr td {
            font-size: 11px;
            font-family: arial, verdana, sans-serif;
        }
    </style>
@endsection

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
        <span class="breadcrumb-item active"> Laporan Tempahan</span>

    </div>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header header-elements-inline bg-light">

                <h5 class="card-title">Laporan Tempahan Bilik Mesyuarat</h5>
            </div>
            <form action="/laporan/bilik">
                {{ csrf_field() }}
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Nama Bilik: </label>
                                <div class="col-md-8">
                                    <select class="form-control select-search select-clear" data-placeholder="Pilih Bilik"
                                        name="nama_bilik" data-fouc>
                                        <option></option>
                                        @foreach ($rooms as $room)
                                            @if ($nama_bilik == $room->id)
                                                <option value="{{ $room->id }}" selected>
                                                    {{ $room->nama }}
                                                </option>
                                            @else
                                                <option value="{{ $room->id }}"> {{ $room->nama }}</option>
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
                                    <select class="form-control select-search select-clear"
                                        data-placeholder="Pilih Bahagian" name="bahagian" data-fouc>
                                        <option></option>
                                        @foreach ($departments as $department)
                                            @if ($bahagian_selected == $department->id)
                                                <option value="{{ $department->id }}" selected>
                                                    {{ $department->nama }}</option>
                                            @else
                                                <option value="{{ $department->id }}">
                                                    {{ $department->nama }}
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
                                <label class="col-md-4 col-form-label text-lg-right">Status: </label>
                                <div class="col-md-8">
                                    <select data-placeholder="Pilih Status" class="form-control select-search select-clear"
                                        name="status" data-fouc id="status">

                                        @role('biz-point|pmsb')
                                            <option value="2" {{ old('status', $status) == '2' ? 'selected' : '' }}>
                                                Lulus</option>
                                        @else
                                            <option></option>
                                            <option value="1" {{ old('status', $status) == '1' ? 'selected' : '' }}>
                                                Baru</option>
                                            <option value="2" {{-- <option value="2,6,11,14" --}}
                                                {{ old('status', $status) == '2' ? 'selected' : '' }}>
                                                Lulus</option>
                                            <option value="4" {{ old('status', $status) == '4' ? 'selected' : '' }}>
                                                Tolak</option>
                                            {{-- <option value="5,7,12,13" --}}
                                            <option value="5" {{ old('status', $status) == '5' ? 'selected' : '' }}>Batal
                                            </option>
                                        @endrole

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Kategori Pengerusi: </label>
                                <div class="col-md-8">
                                    <select data-placeholder="Pilih Kategori Mesyuarat"
                                        class="form-control select-search select-clear" name="pengerusi" data-fouc>
                                        <option></option>
                                        <option value="YBM" {{ old('status', $pengerusi) == 'YBM' ? 'selected' : '' }}>
                                            YBM
                                        </option>
                                        <option value="Timbalan YBM"
                                            {{ old('status', $pengerusi) == 'Timbalan YBM' ? 'selected' : '' }}>Timbalan
                                            YBM</option>
                                        <option value="KSU" {{ old('status', $pengerusi) == 'KSU' ? 'selected' : '' }}>
                                            KSU</option>
                                        <option value="TKSU I"
                                            {{ old('status', $pengerusi) == 'TKSU I' ? 'selected' : '' }}>TKSU(I)
                                        </option>
                                        <option value="TKSU P"
                                            {{ old('status', $pengerusi) == 'TKSU P' ? 'selected' : '' }}>TKSU(P)
                                        </option>
                                        <option value="TKSU PP"
                                            {{ old('status', $pengerusi) == 'TKSU PP' ? 'selected' : '' }}>TKSU(PP)
                                        </option>
                                        <option value="0" {{ old('status', $pengerusi) == '0' ? 'selected' : '' }}>
                                            Lain-lain</option>
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
                        <a href="{{ url('/laporan/bilik') }}" role="button"><button type="button"
                                class="btn bg-danger">Semula</button></a>

                    </div>

                </div>
            </form>
            <div class="content">
                <div class="card">
                    @if ($cari)
                        <table class="table datatable-button-print-basic myText">
                            <thead>
                                <tr>
                                    <th>Bil</th>
                                    <th>ID Batch</th>
                                    <th>ID</th>
                                    <th>Program/Mesyuarat</th>
                                    <th>Nama Pemohon / Ext</th>
                                    <th>Bahagian</th>
                                    <th>Tarikh/Masa</th>
                                    <th>Bilik</th>
                                    <th>Pengerusi</th>
                                    <th>Bil.<br> Kehadiran</th>
                                    <th>Sajian</th>
                                    <th>Catatan Pemohon</th>
                                    <th>Catatan Penyelia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 1;
                                ?>
                                @foreach ($carian as $carian_application)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>#{{ $carian_application->batch_id }}</td>
                                        <td><b>{{ $carian_application->id }}</b></td>
                                        <td>
                                            @role('approver-room|super-admin')
                                                <a
                                                    href="/admin/application_room/show/{{ encrypt($carian_application->id) }}">{{ $carian_application->nama_mesyuarat }}</a>
                                            @else
                                                {{ $carian_application->nama_mesyuarat }}
                                            @endrole
                                            <br>
                                            <span
                                                class="text-muted">({{ $carian_application->statusRoom->status_pentadbiran }})</span>
                                        </td>

                                        <td>{{ $carian_application->application->user->name }} <br>
                                            ({{ $carian_application->application->user->profile->no_extension }})
                                        </td>
                                        <td> {{ $carian_application->department->nama }}</td>
                                        <td> {{ \Carbon\Carbon::parse($carian_application->tarikh_mula)->format('d-m-Y') }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($carian_application->tarikh_hingga)->format('d-m-Y') }}
                                            <br>
                                            ({{ \Carbon\Carbon::parse($carian_application->tarikh_mula)->format('g:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($carian_application->tarikh_hingga)->format('g:i A') }})
                                        </td>
                                        <td> {{ $carian_application->application->room->nama }}</td>

                                        <td>
                                            @if ($carian_application->nama_pengerusi != null)
                                                {{ $carian_application->nama_pengerusi }}
                                            @else
                                                {{ $carian_application->kategori_pengerusi }}
                                            @endif
                                        </td>
                                        <td> {{ $carian_application->bilangan_tempahan }}</td>


                                        @if ($carian_application->minum_pagi != null &&
                                            $carian_application->makan_tengahari != null &&
                                            $carian_application->minum_petang != null)
                                            <td>{{ $carian_application->sajian }} <br>
                                                -minum pagi <br>
                                                -makan tengahari <br>
                                                -minum petang
                                            </td>
                                        @elseif($carian_application->minum_pagi != null && $carian_application->makan_tengahari != null)
                                            <td>{{ $carian_application->sajian }} <br>
                                                -minum pagi <br>
                                                -makan tengahari

                                            </td>
                                        @elseif($carian_application->minum_pagi != null && $carian_application->minum_petang != null)
                                            <td>{{ $carian_application->sajian }} <br>
                                                -minum pagi <br>
                                                -minum petang

                                            </td>
                                        @elseif ($carian_application->makan_tengahari != null && $carian_application->minum_petang != null)
                                            <td>{{ $carian_application->sajian }}
                                                -makan tengahari <br>
                                                -minum petang
                                            </td>
                                        @elseif ($carian_application->minum_pagi != null)
                                            <td>{{ $carian_application->sajian }} <br>
                                                -minum pagi <br>

                                            </td>
                                        @elseif ($carian_application->makan_tengahari != null)
                                            <td>{{ $carian_application->sajian }} <br>
                                                -makan tengahari <br>
                                            </td>
                                        @elseif ($carian_application->minum_petang != null)
                                            <td>{{ $carian_application->sajian }} <br>
                                                -minum petang <br>

                                            </td>
                                        @else
                                            <td>Tidak Perlu</td>
                                        @endif

                                        <td> {{ $carian_application->catatan }}</td>
                                        <td> {{ $carian_application->catatan_penyelia }}</td>

                                    </tr>
                                @endforeach
                                @if ($carian and count($carian) == 0)
                                    <tr>
                                        <td colspan="10" style="text-align: center; font-weight:bold">Tiada Rekod
                                            Dijumpai</td>
                                    <tr>
                                @endif

                            </tbody>
                        </table>
                    @endif
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
