@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Permohonan Tempahan</span>

    </div>
@endsection

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')

    <body onload="onLoadFunction()">
        <div class="card">

            <div class="card-header">
                <h5>Kemaskini Tempahan</h5>

                <div class="alert alert-info alert-styled-left alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <span class="font-weight-semibold">Perubahan medan yang bertanda <i class="icon-pencil"></i>diambilkira
                        sebagai LULUS DENGAN PINDAAN.
                </div>

            </div>

            <div class="card-body">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round active"
                            data-toggle="tab">Maklumat Permohonan</a></li>
                    <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Maklumat
                            Pemohon/Urusetia</a></li>

                </ul>
                <form method="post" enctype="multipart/form-data"
                    action="/admin/application_room/edit/{{ $application->applicationRoom->id }}">
                    @csrf
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="maklumat_permohonan">
                           
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
                                        <div class="form-group row">
                                            <label for="id_permohonan"
                                                class="col-md-3 col-form-label text-md-right"><b>{{ __('ID Permohonan') }}</b></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="id_permohonan"
                                                    style="font-weight: bold" value="{{ $application->id }}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bilik" class="col-md-3 col-form-label text-md-right"><i
                                                    class="icon-pencil"></i>{{ __('Nama Bilik/Lokasi') }}</label>
                                            <div class="col-lg-9">
                                                <select id="room" name="room" class="form-control select-search"
                                                    data-placeholder="Pilih Bilik" onchange="selectRoom()">
                                                    <option></option>
                                                    @foreach ($rooms as $room)
                                                        <option
                                                            value="{{ $room->id }}{{ $room->is_auto }}{{ $room->is_upload }}{{ $room->is_pantry }}"
                                                            @if (old('room', $application->room_id) == $room->id) selected @endif>
                                                            {{ $room->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="is_auto_input" name="is_auto_input"
                                                    value="{{ old('is_auto_input', $application->room->is_auto) }}">
                                                <input type="hidden" id="is_upload_input" name="is_upload_input"
                                                    value="{{ old('is_upload_input', $application->room->is_upload) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tarikh_mula" class="col-md-3 col-form-label text-md-right"><i
                                                    class="icon-pencil"></i>{{ __('Tarikh/Masa Mula') }}</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="datetime-local" class="date"
                                                    name="tarikh_mula" id="tarikh_mula"
                                                    value="{{ old('tarikh_mula', date('Y-m-d\TH:i', strtotime($application->tarikh_mula))) }}"
                                                    onchange="selectRoom()">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tarikh_hingga" class="col-md-3 col-form-label text-md-right"><i
                                                    class="icon-pencil"></i>{{ __('Tarikh/Masa Tamat') }}</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="datetime-local" name="tarikh_hingga"
                                                    id="tarikh_hingga"
                                                    value="{{ old('tarikh_hingga', date('Y-m-d\TH:i', strtotime($application->tarikh_hingga))) }}"
                                                    onchange="selectRoom()">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_mesyuarat"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Tajuk Mesyuarat/Program') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nama_mesyuarat"
                                                    value="{{ old('nama_mesyuarat', $application->nama_mesyuarat) }}"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="alert alert-warning border-0 alert-dismissible"
                                            id="div_alert_bilik_manual" style="display: none">
                                            <button type="button" class="close" data-dismiss="alert"></button>
                                            <strong>Makluman : </strong> Bilik ini perlu mendapat kelulusan secara
                                            manual
                                            dari bahagian tersebut . Hanya permohonan VC akan diproses.
                                        </div>

                                        <div class="alert alert-warning border-0 alert-dismissible"
                                            id="div_alert_bilik_sendiri" style="display: none">
                                            <button type="button" class="close" data-dismiss="alert"></button>
                                            <strong>Makluman : </strong> <b>Bilik sendiri</b> tidak perlu proses kelulusan
                                            bilik . Hanya permohonan VC akan diproses.
                                        </div>


                                        <div id="availabilityRoom">
                                        </div>                                        

                                        <div class="form-group row">
                                            <label for="kategori_pengerusi"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Kategori Pengerusi') }}</label>
                                            <div class="col-md-9">
                                                <select name="kategori_pengerusi" id="kategori_pengerusi"
                                                    data-placeholder="Pilih Kategori Pengerusi" class="form-control"
                                                    onchange="kategoriPengerusi()" disabled>
                                                    <option>Pilih Kategori Pengerusi</option>
                                                    <option value="YBM"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'YBM') selected @endif>YBM</option>
                                                    <option value="Timbalan YBM"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'Timbalan YBM') selected @endif>Timbalan YBM
                                                    </option>
                                                    <option value="KSU"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'KSU') selected @endif>KSU</option>
                                                    <option value="TKSU I"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'TKSU I') selected @endif>TKSU(I)
                                                    </option>
                                                    <option value="TKSU P"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'TKSU P') selected @endif>TKSU(P)
                                                    </option>
                                                    <option value="TKSU PP"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'TKSU PP') selected @endif>TKSU(PP)
                                                    </option>
                                                    <option value="0"
                                                        @if (old('kategori_pengerusi', $application->kategori_pengerusi) == '0') selected @endif>Lain-Lain
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="div_pengerusi" style="display: none">
                                            <div class="form-group row">
                                                <label for="nama_pengerusi"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Pengerusi') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="text" name="nama_pengerusi"
                                                        id="pengerusi"
                                                        value="{{ old('nama_pengerusi', $application->nama_pengerusi) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-warning" role="alert" id="alert_bil_tempahan"
                                            style="display:none">
                                            <b>Mesej</b>
                                            {{-- <li>Had maksimum <b>50 pax</b> (TKSU/KSU/YBTM/YBM)</li>
                                                <li>Had maksimum <b>35 pax</b> (Lain-lain)</li>
                                                <li>Sekiranya melebihi had maksimum, bahagian perlu membuat tempahan katerer
                                                    luar</li>
                                                <li>Had maksimum dikecualikan bagi Mesyuarat Pengurusan dan Mesyuarat
                                                    <i>Post-Cabinet.</i>
                                                </li> --}}
                                            <li>Had maksimum sajian mengikut <u>kapasiti bilik</u>.</li>
                                            <li>Had peruntukan sajian pantri dalaman hanya untuk <u>Mesyuarat Rasmi
                                                    Sahaja</u>.</li>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bil_tempah" class="col-md-3 col-form-label text-md-right"><i
                                                    class="icon-pencil"></i>{{ __('Bil.Tempahan/Kehadiran') }}</label>
                                            <div class="col-md-9">
                                                <input id="bil_tempah" type="text" class="form-control"
                                                    name="bilangan_tempahan"
                                                    value="{{ old('bil_tempah', $application->bilangan_tempahan) }}"
                                                    onkeyup="return bilTempah()" autocomplete="bil_tempah">
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div class="card-header">
                                    <h6 class="card-title">
                                        <a class="text-default" data-toggle="collapse"
                                            href="#maklumat_terperinci">Maklumat
                                            Terperinci
                                            Mesyuarat/Program
                                        </a>
                                    </h6>
                                </div>

                                <div id="maklumat_terperinci" class="collapse show">
                                    <div class="card-body">

                                        <div class="card bg-light">
                                            <div class="card-header bg-white d-flex justify-content-between">
                                                <span class="text-default"><b>Maklumat Mesyuarat</b></span>
                                            </div>

                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="kategori_mesyuarat"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                                                    <div class="col-md-9">
                                                        <select name="kategori_mesyuarat"
                                                            data-placeholder="Pilih Kategori Mesyuarat"
                                                            class="form-control select-search" disabled>
                                                            <option></option>
                                                            <option value="1"
                                                                @if (old('kategori_mesyuarat', $application->applicationRoom->kategori_mesyuarat) == '1') selected @endif>
                                                                Mesyuarat Pengurusan Tertinggi</option>
                                                            <option value="2"
                                                                @if (old('kategori_mesyuarat', $application->applicationRoom->kategori_mesyuarat) == '2') selected @endif>
                                                                Mesyuarat Lain-lain</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="penganjur"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                                                    <div class="col-md-9">
                                                        <select name="penganjur" id="penganjur"
                                                            data-placeholder="Pilih Penganjur"
                                                            class="form-control select-search"
                                                            onchange="alert_nama_penganjur()" disabled>
                                                            <option></option>
                                                            <option value="SENDIRI"
                                                                @if (old('penganjur', $application->applicationRoom->penganjur) == 'SENDIRI') selected @endif>Sendiri
                                                            </option>
                                                            <option value="BERSAMA"
                                                                @if (old('penganjur', $application->applicationRoom->penganjur) == 'BERSAMA') selected @endif>
                                                                Bersama/Kolabrasi
                                                            </option>
                                                            <option value="LUAR"
                                                                @if (old('penganjur', $application->applicationRoom->penganjur) == 'LUAR') selected @endif>
                                                                Luar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="div_nama_penganjur" style="display: none">
                                                    <div class="form-group row">
                                                        <label for="nama_penganjur"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                                                        <div class="col-md-9">
                                                            <input id="nama_penganjur" type="text"
                                                                class="form-control" name="nama_penganjur"
                                                                value="{{ old('nama_penganjur', $application->applicationRoom->nama_penganjur) }}"
                                                                autocomplete="nama_penganjur" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="div_upload" style="display: none">
                                                    <div class="form-group row">
                                                        <label for="surat_emel"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                                                        <div class="col-md-9">
                                                            @if (!empty($application->applicationRoom->surat))
                                                                <a href="{{ asset($application->applicationRoom->surat) }}"
                                                                    target="_blank"><i
                                                                        class="icon-attachment mr-3"></i></a>
                                                                <input type="hidden" class="form-control-uniform-custom"
                                                                    name="surat_emel"
                                                                    value="{{ $application->applicationRoom->surat }}"
                                                                    id="surat_emel" readonly>
                                                            @endif

                                                            <input type="file" class="form-control-uniform-custom"
                                                                name="surat_emel" id="surat_emel" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="alert alert-primary" role="alert" id="mesej_tiada_sajian">
                                                    <i class="icon-info22 mr-2"></i><b>Mesej</b> : Tempahan sajian
                                                    mesyuarat (Pantri Dalaman) hanya untuk bilik mesyuarat sahaja. Sebarang
                                                    pertanyaan sila hubungi <u>Bahagian Pentadbiran</u>.
                                                </div>

                                                <div class="form-group row">
                                                    <label for="sajian" class="col-md-3 col-form-label text-md-right"><i
                                                            class="icon-pencil"></i>{{ __('Sajian') }}</label>
                                                    <div class="col-md-9">
                                                        <select name="sajian" id="sajian"
                                                            data-placeholder="Pilih Sajian"
                                                            onChange="java_script_:sajianSelected(this.options[this.selectedIndex].value)"
                                                            class="form-control select-search">
                                                            <option></option>
                                                            <option value="Tidak Perlu"
                                                                @if (old('sajian', $application->applicationRoom->sajian) == 'Tidak Perlu') selected @endif>Tidak
                                                                Perlu
                                                            </option>
                                                            <option value="Pantri Dalaman"
                                                                @if (old('sajian', $application->applicationRoom->sajian) == 'Pantri Dalaman') selected @endif>Pantri
                                                                Dalaman
                                                            </option>
                                                            <option value="Katerer Luar"
                                                                @if (old('sajian', $application->applicationRoom->sajian) == 'Katerer Luar') selected @endif>Katerer
                                                                Luar
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="div_sajian" style="display: block">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 text-md-right"><i
                                                                class="icon-pencil"></i>Pilihan
                                                            Sajian</label>
                                                        <div id="div_minum_pagi">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="minum_pagi" name="minum_pagi"
                                                                        @if ($application->applicationRoom->minum_pagi == '1') checked @endif>
                                                                    <label class="custom-control-label position-static"
                                                                        for="minum_pagi">Minum Pagi</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="div_makan_tengahari">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="makan_tengahari" name="makan_tengahari"
                                                                        @if ($application->applicationRoom->makan_tengahari == '1') checked @endif>
                                                                    <label class="custom-control-label position-static"
                                                                        for="makan_tengahari">Makan Tengahari</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="div_minum_petang">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="minum_petang" name="minum_petang"
                                                                        @if ($application->applicationRoom->minum_petang == '1') checked @endif>
                                                                    <label class="custom-control-label position-static"
                                                                        for="minum_petang">Minum Petang</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="catatan"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room" readonly>{{ $application->applicationRoom->catatan }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

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
                                            <div class="form-group row">
                                                <label for="created_at"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Permohonan') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="created_at"
                                                        value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->created_at)) }}"
                                                        readonly>
                                                </div>
                                            </div>

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

                                            @if ($application->applicationRoom->status_room_id == '1')
                                                @if ($applicationCount > 0)
                                                    <div class="alert alert-warning alert-dismissible">
                                                        <button type="button" class="close"
                                                            data-dismiss="alert"><span>&times;</span></button>
                                                        <span class="font-weight-semibold">Perhatian : </span> Bilik ini
                                                        <b>telah ditempah</b> pada tarikh dan masa yang
                                                        sama.
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}

                            </div>
                            <!-- /collapsible with left control button -->


                        </div>

                        <div class="tab-pane fade" id="maklumat_bilik">

                            <fieldset>

                                <div class="card-group-control card-group-control-left">

                                    <div class="card bg-light">

                                        <div id="collapsible-control-group1" class="collapse show">

                                            <div id="collapsible-control-group1" class="collapse show">

                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline form-check-right">
                                                            <label class="form-check-label">
                                                                <span class="text-default"><b>Maklumat Urusetia</b></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline form-check-right">
                                                            <label class="form-check-label">
                                                                <span>Maklumat Seperti <a href="#"
                                                                        data-toggle="modal" data-target="#modal_default">
                                                                        Pemohon</a></span>
                                                                <input type="checkbox" id="copy_applicant"
                                                                    name="copy_applicant" class="form-check-input"
                                                                    onclick="copyApplicantInfo()" disabled>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="nama"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                                                                <div class="col-md-8">
                                                                    <input id="nama_urusetia" type="text"
                                                                        class="form-control " name="nama_urusetia"
                                                                        value="{{ $application->applicationRoom->nama_urusetia }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="email"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('E-mel') }}</label>
                                                                <div class="col-md-8">
                                                                    <input id="email_urusetia" type="text"
                                                                        class="form-control" name="email_urusetia"
                                                                        value="{{ $application->applicationRoom->emel_urusetia }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="jawatan_urusetia"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>
                                                                <div class="col-md-8">

                                                                    <select name="jawatan_urusetia" id="jawatan_urusetia"
                                                                        data-placeholder="Pilih Jawatan"
                                                                        class="form-control select-search" disabled>
                                                                        <option>Pilih Jawatan</option>
                                                                        @foreach ($positions as $position)
                                                                            <option value="{{ $position->id }}"
                                                                                @if (old('jawatan_urusetia', $application->applicationRoom->position_id) == $position->id) selected @endif>
                                                                                {{ $position->nama }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="bahagian_urusetia"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>
                                                                <div class="col-md-8">

                                                                    <select name="bahagian_urusetia"
                                                                        id="bahagian_urusetia"
                                                                        data-placeholder="Pilih Bahagian"
                                                                        class="form-control select-search" disabled>
                                                                        <option>Pilih Bahagian</option>
                                                                        @foreach ($departments as $department)
                                                                            <option value="{{ $department->id }}"
                                                                                @if (old('department', $application->applicationRoom->position_id) == $department->id) selected @endif>
                                                                                {{ $department->nama }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="no_sambungan_urusetia"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        id="no_sambungan_urusetia"
                                                                        name="no_sambungan_urusetia"
                                                                        value="{{ $application->applicationRoom->no_extension_urusetia }}"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="no_bimbit_urusetia"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        id="no_bimbit_urusetia" name="no_bimbit_urusetia"
                                                                        value="{{ $application->applicationRoom->no_telefon_bimbit_urusetia }}"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                            Kembali</button>

                        @if ($application->applicationRoom->status_room_id == '1')
                            <form class="delete" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="POST">
                                <button type="submit" class="btn btn-primary btn-sm submit-btn">
                                    Lulus Dengan Pindaan
                                </button>
                            </form>
                            {{-- <button type="submit" class="btn btn-info btn-sm">Lulus Dengan Pindaan</button> --}}
                        @endif
                    </div>
                </form>

                <!-- Modal Papar pemohon -->
                <div id="modal_default" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">

                            </div>

                            <div class="modal-body">
                                <h6 class="font-weight-semibold">Maklumat Pemohon</h6>

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
                                                    <td class="text-right"><span class="text-default">Jawatan</span></td>
                                                    <td>{{ $application->user->profile->position->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">Bahagian</span></td>
                                                    <td>{{ $application->user->profile->department->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">No. Sambungan</span>
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

            </div>
        </div>
    </body>
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

        function onLoadFunction() {

            var kategori_pengerusi = document.getElementById("kategori_pengerusi").value;

            if (kategori_pengerusi == '0') {
                document.getElementById("div_pengerusi").style.display = "block";
            }

            var is_upload_input = document.getElementById("is_upload_input").value;
            if (is_upload_input == 'Y') {
                document.getElementById("div_upload").style.display = "block";
            }

            var sajian = document.getElementById("sajian").value;
            sajianSelected(sajian);
            selectRoom();
            bilTempah();
            webexSelected();
            alert_nama_penganjur();
        }

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

            var nama = "<?php echo $application->user->name; ?>";
            var emel = "<?php echo $application->user->email; ?>";
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

        function showHideFormRoom() {

            var room_selected = document.getElementById("room_selected");
            var form_room_urusetia = document.getElementById("form_room_urusetia");
            var form_room = document.getElementById("form_room");

            if (room_selected.checked == true) {
                form_room.style.display = "block";
                form_room_urusetia.style.display = "block";

            } else {
                form_room.style.display = "none";
                form_room_urusetia.style.display = "none";
            }

        }

        function showHideFormVc() {

            var vc_selected = document.getElementById("vc_selected");
            var form_vc = document.getElementById("form_vc");

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
                document.getElementById("div_sajian").style.display = 'block';
                document.getElementById("div_minum_pagi").style.display = 'block';
                document.getElementById("div_makan_tengahari").style.display = 'block';
                document.getElementById("div_minum_petang").style.display = 'block';

            } else if (select_item == "Pantri Dalaman") {
                document.getElementById("div_sajian").style.display = 'block';
                document.getElementById("div_minum_pagi").style.display = 'block';
                document.getElementById("div_minum_petang").style.display = 'block';
                document.getElementById("div_makan_tengahari").style.display = 'none';

            } else if (select_item == "Tidak Perlu") {
                document.getElementById("div_sajian").style.display = "none";
                document.getElementById("div_minum_pagi").style.display = 'none';
                document.getElementById("div_minum_petang").style.display = 'none';
                document.getElementById("div_makan_tengahari").style.display = 'none';
            }
        }

        function selectRoom() {
            var room = document.getElementById("room").value;
            room_length = room.length;

            if (room_length == 5) {
                var roomId = room.substr(0, 2);
            }
            if (room_length == 4) {
                var roomId = room.substr(0, 1);
            }

            var is_auto = room.substr(room.length - 3, 1);
            var is_upload = room.substr(room.length - 2, 1);
            var is_pantry = room.substr(room.length - 1);

            // alert(is_pantry);
            var div_alert_bilik_manual = document.getElementById("div_alert_bilik_manual");
            document.getElementById("is_auto_input").value = is_auto;
            document.getElementById("is_upload_input").value = is_upload;

            if (is_upload == 'Y') {
                document.getElementById("div_upload").style.display = "block";
            } else {
                document.getElementById("div_upload").style.display = "none";
            }

            if (is_pantry == 'N') {

                document.getElementById("sajian").disabled = true;
                document.getElementById("div_sajian").style.display = "none";
                document.getElementById("mesej_tiada_sajian").style.display = "block";
            } else {
                document.getElementById("sajian").disabled = false;
                document.getElementById("div_sajian").style.display = "block";
                document.getElementById("mesej_tiada_sajian").style.display = "none";

            }

            if (is_auto == 'N') {
                div_alert_bilik_manual.style.display = "block";
                document.getElementById("availabilityRoom").style.display = "none";
            } else if (is_auto == 'S') {
                div_alert_bilik_manual.style.display = "none";
                div_alert_bilik_sendiri.style.display = "block";
                document.getElementById("availabilityRoom").style.display = "none";

            } else {
                div_alert_bilik_manual.style.display = "none";

                // Tambah checking bilik
                var tarikh_mula = document.getElementById("tarikh_mula").value;
                var tarikh_hingga = document.getElementById("tarikh_hingga").value;

                if (roomId.length == 0 || tarikh_mula.length == 0 || tarikh_hingga.length == 0) {

                    // document.getElementById("availabilityRoom").innerHTML = "";
                    // document.getElementById("availabilityRoom").style.border = "0px";
                    // return;
                }

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {

                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("availabilityRoom").innerHTML = this.responseText;
                    } else {

                    }
                }

                xmlhttp.open("GET", "/application/room/check?room=" + roomId + "&tarikh_mula=" + tarikh_mula +
                    "&tarikh_hingga=" + tarikh_hingga, true);
                xmlhttp.send();
            }

        }
    </script>
@endsection
