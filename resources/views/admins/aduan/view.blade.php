@extends('layouts.backend_admin')

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/admin/report" class="breadcrumb-item"> Aduan Pemohon</a>
        <span class="breadcrumb-item active"> Paparan Tempahan</span>


    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Paparan Tempahan</h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round"
                        data-toggle="tab">Maklumat Permohonan</a></li>
                <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Maklumat
                        Pemohon/Urusetia</a></li>
                <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan VC</a></li>
                <li class="nav-item"><a href="#maklumat_aduan" class="nav-link rounded-round active"
                        data-toggle="tab">Aduan</a></li>

            </ul>


            <div class="tab-content">
                <div class="tab-pane fade" id="maklumat_permohonan">

                    <!-- Collapsible with left control button -->
                    <div class="card-group-control card-group-control-left">

                        <div class="card-header">
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-default" href="#maklumat_mesyuarat">Maklumat
                                    Permohonan</a>
                            </h6>
                        </div>

                        <div id="maklumat_mesyuarat" class="collapse show">
                            <div class="card-body">

                                <div class="card bg-light">

                                    <div id="form_permohonan" class="collapse show">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label for="id_permohonan"
                                                    class="col-md-3 col-form-label text-md-right"><b>{{ __('ID Permohonan') }}</b></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="id_permohonan"
                                                        style="font-weight: bold" value="{{ $application->id }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tarikh_mula"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Mula') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="tarikh_mula"
                                                        value="{{ date('d-m-Y H:i A', strtotime($application->tarikh_mula)) }}"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tarikh_hingga"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Tamat') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="tarikh_hingga"
                                                        value="{{ date('d-m-Y H:i A', strtotime($application->tarikh_hingga)) }}"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nama_mesyuarat"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tajuk Mesyuarat/Program') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nama_mesyuarat"
                                                        value="{{ $application->nama_mesyuarat }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="bilik"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Bilik/Lokasi') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="bilik"
                                                        value="{{ $application->room->nama }}" readonly>
                                                </div>
                                            </div>

                                            <?php
                                            if ($application->kategori_pengerusi == '0') {
                                                $kategori_pengerusi = 'Lain-lain';
                                            } else {
                                                $kategori_pengerusi = $application->kategori_pengerusi;
                                            }

                                            ?>

                                            <div class="form-group row">
                                                <label for="kategori_pengerusi"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Kategori Pengerusi') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="kategori_pengerusi"
                                                        value="{{ $kategori_pengerusi }}" readonly>
                                                </div>
                                            </div>

                                            @if ($application->kategori_pengerusi == '0')
                                                <div class="form-group row">
                                                    <label for="nama_pengerusi"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Nama Pengerusi') }}</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" type="text" name="nama_pengerusi"
                                                            id="pengerusi"
                                                            value="{{ old('nama_pengerusi', $application->nama_pengerusi) }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="alert alert-warning" role="alert" id="alert_bil_tempahan"
                                                style="display:none">
                                                <b>Mesej</b>
                                                <li>Had maksimum <b>50 pax</b> (TKSU/KSU/YBTM/YBM)</li>
                                                <li>Had maksimum <b>35 pax</b> (Lain-lain)</li>
                                                <li>Sekiranya melebihi had maksimum, bahagian perlu membuat
                                                    tempahan katerer
                                                    luar</li>
                                                <li>Had maksimum dikecualikan bagi Mesyuarat Pengurusan dan
                                                    Mesyuarat
                                                    <i>Post-Cabinet.</i>
                                                </li>
                                            </div>

                                            <div class="form-group row">
                                                <label for="bil_tempah"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Bil.Tempahan/Kehadiran') }}</label>
                                                <div class="col-md-9">
                                                    <input id="bil_tempah" type="text" class="form-control"
                                                        name="bilangan_tempahan"
                                                        value="{{ $application->bilangan_tempahan }}" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="card-header">
                            <h6 class="card-title">
                                <a class="text-default" data-toggle="collapse" href="#maklumat_terperinci">Maklumat
                                    Terperinci
                                    Mesyuarat/Program
                                </a>
                            </h6>
                        </div>

                        <div id="maklumat_terperinci" class="collapse show">
                            <div class="card-body">

                                <div class="card card bg-light">

                                    <?php
                                    if ($application->applicationRoom->kategori_mesyuarat == '1') {
                                        $kategori_mesyuarat = 'Mesyuarat Pengurusan Tertinggi';
                                    } elseif ($application->applicationRoom->kategori_mesyuarat == '2') {
                                        $kategori_mesyuarat = 'Mesyuarat Lain-lain';
                                    }
                                    ?>

                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="kategori_mesyuarat"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="kategori_mesyuarat"
                                                    @if ($application->applicationRoom->kategori_mesyuarat == '1') value="Mesyuarat Pengurusan Tertinggi"
                                                @elseif($application->applicationRoom->kategori_mesyuarat == '2')
                                                    value="Mesyuarat Lain-lain" @endif
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="penganjur"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="penganjur"
                                                    value="{{ $application->applicationRoom->penganjur }}" readonly>

                                            </div>
                                        </div>

                                        <div id="div_nama_penganjur" style="display: none">
                                            <div class="form-group row">
                                                <label for="nama_penganjur"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nama_penganjur"
                                                        value="{{ $application->applicationRoom->nama_penganjur }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                        @if (!empty($application->room->is_upload == 'Y'))
                                            <div class="form-group row">
                                                <label for="surat_emel"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                                                <div class="col-md-9">
                                                    <a href="{{ asset($application->applicationRoom->surat) }}"
                                                        target="_blank"><i class="icon-attachment mr-3"></i></a>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label for="sajian"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Sajian') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="sajian"
                                                    value="{{ $application->applicationRoom->sajian }}" readonly>

                                            </div>
                                        </div>

                                        @if ($application->applicationRoom->sajian == 'Katerer Luar')
                                            <div class="form-group row">
                                                <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                                                <div class="col-md-2">
                                                    <div
                                                        class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                            @if ($application->applicationRoom->minum_pagi == '1') checked @endif>
                                                        <label class="custom-control-label position-static"
                                                            for="minum_pagi">Minum
                                                            Pagi</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div
                                                        class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                            @if ($application->applicationRoom->makan_tengahari == '1') checked @endif>
                                                        <label class="custom-control-label position-static"
                                                            for="makan_tengahari">Makan
                                                            Tengahari</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div
                                                        class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                            @if ($application->applicationRoom->minum_petang == '1') checked @endif>
                                                        <label class="custom-control-label position-static"
                                                            for="minum_petang">Minum
                                                            Petang</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($application->applicationRoom->sajian == 'Pantri Dalaman')
                                            <div class="form-group row">
                                                <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                                                <div class="col-md-2">
                                                    <div
                                                        class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="minum_pagi"
                                                            @if ($application->applicationRoom->minum_pagi == '1') checked @endif disabled>
                                                        <label class="custom-control-label position-static"
                                                            for="minum_pagi">Minum
                                                            Pagi</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div
                                                        class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                            name="minum_petang"
                                                            @if ($application->applicationRoom->minum_petang == '1') checked @endif disabled>
                                                        <label class="custom-control-label position-static"
                                                            for="minum_petang">Minum
                                                            Petang</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label for="catatan"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Catatan Pemohon') }}</label>
                                            <div class="col-md-9">
                                                <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room" readonly>{{ $application->applicationRoom->catatan }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status_room"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                                            <div class="col-md-9">
                                                @if ($application->applicationRoom->status_room_id == '1')
                                                    <span
                                                        class="badge badge-primary">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                @elseif($application->applicationRoom->status_room_id == '2')
                                                    <span
                                                        class="badge badge-success">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                @elseif($application->applicationRoom->status_room_id == '4')
                                                    <span
                                                        class="badge badge-danger">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-secondary">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                @endif

                                            </div>
                                        </div>

                                        <hr>
                                        @if ($application->applicationRoom->status_room_id == '4' ||
                                            $application->applicationRoom->status_room_id == '13')
                                            <div class="form-group row">
                                                <label for="komen_ditolak"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Sebab Ditolak / Dibatalkan') }}</label>
                                                <div class="col-md-9">
                                                    <textarea rows="2" cols="2" class="form-control" placeholder="Sebab Ditolak" name="komen_ditolak">{{ $application->applicationRoom->komen_ditolak }}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label for="created_at"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Permohonan') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="created_at"
                                                    value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->created_at)) }}"
                                                    readonly>
                                            </div>
                                        </div>

                                        @if ($application->applicationRoom->status_room_id == '2' || $application->applicationRoom->status_room_id == '4')
                                            <div class="form-group row">
                                                <label for="tarikh_keputusan"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Keputusan') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="tarikh_keputusan"
                                                        value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->tarikh_keputusan)) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($application->applicationRoom->status_room_id == '13')
                                            <div class="form-group row">
                                                <label for="tarikh_batal"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Batal') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="tarikh_batal"
                                                        value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->tarikh_batal)) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label for="catatan"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Catatan Penyelia') }}</label>
                                            <div class="col-md-9">
                                                @if ($application->applicationRoom->status_room_id == '1')
                                                    <textarea rows="3" cols="3" class="form-control" placeholder="Catatan Penyelia Bilik"
                                                        name="catatan_room_penyelia"></textarea>
                                                @else
                                                    <textarea rows="3" cols="3" class="form-control" placeholder="Catatan Penyelia Bilik"
                                                        name="catatan_room_penyelia" readonly>{{ $application->applicationRoom->catatan_penyelia }}</textarea>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- </div> --}}

                    </div>
                    <!-- /collapsible with left control button -->

                </div>

                <div class="tab-pane fade" id="maklumat_bilik">
                    @if (isset($application->applicationRoom))
                        @include('applications.room.view')
                    @else
                        <div class="text-center text-danger">-Tiada Permohonan-</div>
                    @endif

                </div>

                <div class="tab-pane fade" id="maklumat_bilik">
                    @if (isset($application->applicationRoom))
                        @include('applications.room.view')
                    @else
                        <div class="text-center alert alert-warning border-0 alert-dismissible">
                            <span class="font-weight-semibold">Tiada rekod</span> dijumpai.
                        </div>
                    @endif

                    <?php
                    if ($application->kategori_mesyuarat == '1') {
                        $kategori_mesyuarat = 'Mesyuarat Pengurusan Tertinggi';
                    } elseif ($application->kategori_mesyuarat == '2') {
                        $kategori_mesyuarat = 'Mesyuarat Lain-lain';
                    }
                    ?>

                </div>

                <div class="tab-pane fade" id="maklumat_vc">
                    @if (isset($application->applicationVc->id))
                        @include('applications.vc.view')
                    @else
                        <div class="text-center alert alert-warning border-0 alert-dismissible">
                            <span class="font-weight-semibold">Tiada rekod</span> dijumpai.
                        </div>
                    @endif
                </div>

                <div class="tab-pane fade show active" id="maklumat_aduan">
                    @if (isset($application->report))
                        <fieldset>

                            <div class="card-group-control card-group-control-left">

                                {{-- <div class="card card bg-light"> --}}

                                <div id="collapsible-control-group1" class="collapse show">

                                    <div class="card-body">

                                        <div class="form-group">
                                            <div class="form-check form-check-inline form-check-right">
                                                <label class="form-check-label">
                                                    <b><span class="text-default">Maklumat Aduan</span></b>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="nama"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Aduan') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="aduan" type="text" class="form-control "
                                                            name="aduan" value="{{ $application->report->aduan }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="email"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Cadangan Penambahbaikan') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="cadangan" type="text" class="form-control"
                                                            name="cadangan" value="{{ $application->report->cadangan }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                {{-- </div> --}}
                            </div>

                        </fieldset>
                    @else
                        <div class="text-center alert alert-warning border-0 alert-dismissible">
                            <span class="font-weight-semibold">Tiada rekod</span> dijumpai.
                        </div>

                        <div class="text-center">
                            <p class="text-center"><button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#modal_aduan"><i class="icon-comment-discussion"></i>Aduan</button></p>
                        </div>
                    @endif
                </div>
                <div class="text-center"><button class="btn btn-sm bg-secondary" onclick="history.back()"
                        type="button">
                        Kembali</button></div>

            </div>

        </div>

    </div>


    @if ($errors->any())
        <script>
            $(function() {
                $('#modal_aduan').modal({
                    show: true
                });
            });
        </script>
    @endif

    <div id="modal_aduan" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aduan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="/report/create" class="form-horizontal" onsubmit="return validateForm()" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-styled-right alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                            class="sr-only">Tutup</span></button>
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">Aduan</label>
                            <div class="col-sm-9">
                                <textarea rows="2" cols="3" class="form-control" placeholder="Aduan" name="aduan">{{ old('aduan') }}</textarea>
                                <input type="hidden" name="applicationId"
                                    value="{{ old('applicationId', $application->id) }}">
                                <input type="hidden" name="appear" value="show">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">Cadangan Penambahbaikan</label>
                            <div class="col-sm-9">
                                <textarea rows="2" cols="3" class="form-control" placeholder="Cadangan Penambahbaikan" name="cadangan">{{ old('cadangan') }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn bg-primary">Hantar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Maklumat Pemohon Modal -->
    <div id="modal_default" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>

                <div class="modal-body">
                    <div class="bg-teal">
                        <div class="text-center">
                            <h6 class="font-weight-semibold">Maklumat Pemohon</h6>
                        </div>
                    </div>


                    <div class="card bg-light">

                        <div class="card-body">
                            <table class="table table-lg">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><span class="text-default">Nama</span></td>
                                        <td>{{ $application->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">E-mel</span></td>
                                        <td>{{ $application->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">Jawatan</span>
                                        </td>
                                        <td>{{ $application->user->profile->position->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">Bahagian/Seksyen</span>
                                        </td>
                                        <td>{{ $application->user->profile->department->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">No.
                                                Sambungan</span>
                                        </td>
                                        <td>{{ $application->user->profile->no_extension }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">No. Telefon
                                                Bimbit</span></td>
                                        <td>{{ $application->user->profile->no_bimbit }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Maklumat Pemohon Modal -->
@endsection

@section('script')
    <script>
        $('.submit-btn').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Adakah anda pasti?',
                showCancelButton: true,
                confirmButtonColor: '#22bb33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });

        function webexSelected() {
            var webex_ya = document.getElementById("ya");
            var webex_tidak = document.getElementById("tidak");
            var div_nama_aplikasi = document.getElementById("div_nama_aplikasi");

            if (webex_ya.checked == true) {
                div_nama_aplikasi.style.display = 'none';
            }
            if (webex_tidak.checked == true) {
                div_nama_aplikasi.style.display = 'block';
            }
        }

        function copyApplicantInfo() {
            var copy_applicant = document.getElementById("copy_applicant");
            var jawatan_urusetia_id = "<?php echo $application->user->profile->position_id; ?>";
            var bahagian_urusetia_id = "<?php echo $application->user->profile->department_id; ?>";
            var no_sambungan_urusetia = "<?php echo $application->user->profile->no_extension; ?>";
            var no_bimbit_urusetia = "<?php echo $application->user->profile->no_bimbit; ?>";

            if (copy_applicant.checked == true) {
                document.getElementById("nama_urusetia").value = nama;
                document.getElementById("email_urusetia").value = emel;
                document.getElementById("jawatan_urusetia").value = jawatan_urusetia_id;
                document.getElementById("bahagian_urusetia").value = bahagian_urusetia_id;
                document.getElementById("no_sambungan_urusetia").value = no_sambungan_urusetia;
                document.getElementById("no_bimbit_urusetia").value = no_bimbit_urusetia;
            } else {
                document.getElementById("nama_urusetia").value = null;
                document.getElementById("email_urusetia").value = null;
                document.getElementById("jawatan_urusetia").value = null;
                document.getElementById("bahagian_urusetia").value = null;
                document.getElementById("no_sambungan_urusetia").value = null;
                document.getElementById("no_bimbit_urusetia").value = null;
            }
        }

        function showHideForm() {
            var room_selected = document.getElementById("room_selected");
            var vc_selected = document.getElementById("vc_selected");
            var form_room_urusetia = document.getElementById("form_room_urusetia");
            var form_room = document.getElementById("form_room");
            var form_vc = document.getElementById("form_vc");

            if (room_selected.checked == true) {
                form_room.style.display = "block";
                form_room_urusetia.style.display = "block";

            } else {
                form_room.style.display = "none";
                form_room_urusetia.style.display = "none";

            }
            if (vc_selected.checked == true) {

                form_vc.style.display = "block";

            } else {
                form_vc.style.display = "none";
            }
        }

        function select() {
            var e = document.getElementById("ddlViewBy");
            var strUser = e.value;
            if (strUser == '2') {
                alert(strUser);
                document.getElementById('makanan').style.display = "none";
            }
        }

        function alert_nama_penganjur() {
            var penganjur = document.getElementById("penganjur").value;
            var nama_penganjur = document.getElementById("div_nama_penganjur");
            if (penganjur == "BERSAMA" || penganjur == "LUAR") {
                nama_penganjur.style.display = "block";
            } else {
                nama_penganjur.style.display = "none";
            }
        }

        function kategoriPengerusi() {
            var kategori_pengerusi = document.getElementById("kategori_pengerusi").value;
            var pengerusi = document.getElementById("div_pengerusi");
            if (kategori_pengerusi == "0") {
                pengerusi.style.display = "block";
                document.getElementById("pengerusi").value = "";
            } else {
                pengerusi.style.display = "none";
            }
        }

        function bilTempah() {
            var a = document.getElementById("bil_tempah").value;

            if (a > 35) {
                document.getElementById("alert_bil_tempahan").style.display = "block";
            } else {
                document.getElementById("alert_bil_tempahan").style.display = "none";
            }
        }

        function sajianSelected(select_item) {

            if (select_item == "Katerer Luar") {
                div_sajian.style.display = 'block';
                div_minum_pagi.style.display = 'block';
                div_makan_tengahari.style.display = 'block';
                div_minum_petang.style.display = 'block';

            } else if (select_item == "Pantri Dalaman") {
                div_sajian.style.display = 'block';
                div_minum_pagi.style.display = 'block';
                div_minum_petang.style.display = 'block';
                div_makan_tengahari.style.display = 'none';

            } else if (select_item == "Tidak Perlu") {
                div_sajian.style.display = 'none';
            }
        }
    </script>
@endsection
