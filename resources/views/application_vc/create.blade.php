@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Permohonan Tempahan</span>

    </div>
@endsection

@section('content')

    <body onload="onLoadFunction()">
        <div class="card">
            <div class="card-header">
                <h5>Permohonan Tempahan</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round active"
                            data-toggle="tab" id="idAppTab">Maklumat Permohonan</a></li>
                    <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab"
                            id="idRoomTab">Permohonan Tempahan Bilik</a></li>
                    <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round" data-toggle="tab"
                            id="idVcTab">Permohonan Tempahan VC</a></li>

                </ul>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="maklumat_permohonan">
                            <fieldset>
                                <div class="card card bg-light">

                                    <div id="form_permohonan" class="collapse show">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label for="tarikh_mula"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Mula') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="datetime-local" id="tarikh_mula"
                                                        name="tarikh_mula" value="{{ old('tarikh_mula') }}"
                                                        onchange="selectRoom()">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tarikh_hingga"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Tamat') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="datetime-local" id="tarikh_hingga"
                                                        name="tarikh_hingga" value="{{ old('tarikh_hingga') }}"
                                                        onchange="selectRoom()">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nama_mesyuarat"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tajuk Mesyuarat/Program') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nama_mesyuarat"
                                                        value="{{ old('nama_mesyuarat') }}">
                                                </div>
                                            </div>

                                            <div class="alert alert-warning border-0 alert-dismissible"
                                                id="div_alert_bilik_manual" style="display: none">
                                                <button type="button" class="close" data-dismiss="alert"></button>
                                                <strong>Makluman : </strong> Bilik ini perlu mendapat kelulusan secara
                                                manual
                                                dari bahagian tersebut . Hanya permohonan VC akan diproses.
                                            </div>

                                            <div id="availabilityRoom">
                                            </div>

                                            <div class="form-group row">
                                                <label for="bilik"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Bilik/Lokasi') }}</label>
                                                <div class="col-lg-9">
                                                    <select id="room" name="room" class="form-control select-search"
                                                        data-placeholder="Pilih Bilik" onchange="selectRoom()">
                                                        <option></option>
                                                        @foreach ($rooms as $room)
                                                            <option
                                                                value="{{ $room->id }}{{ $room->is_auto }}{{ $room->is_upload }}"
                                                                @if (old('room') == $room->id) selected @endif>
                                                                {{ $room->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" id="is_auto_input" name="is_auto_input"
                                                        value="{{ old('is_auto_input') }}">
                                                    <input type="hidden" id="is_upload_input" name="is_upload_input"
                                                        value="{{ old('is_upload_input') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="kategori_pengerusi"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Kategori Pengerusi') }}</label>
                                                <div class="col-md-9">
                                                    <select name="kategori_pengerusi" id="kategori_pengerusi"
                                                        data-placeholder="Pilih Kategori Pengerusi" class="form-control"
                                                        onchange="kategoriPengerusi()">
                                                        <option>Pilih Kategori Pengerusi</option>
                                                        <option value="YBM"
                                                            @if (old('kategori_pengerusi') == 'YBM') selected @endif>
                                                            YBM</option>
                                                        <option value="Timbalan YBM"
                                                            @if (old('kategori_pengerusi') == 'YBM') selected @endif>Timbalan YBM
                                                        </option>
                                                        <option value="KSU"
                                                            @if (old('kategori_pengerusi') == 'KSU') selected @endif>
                                                            KSU</option>
                                                        <option value="TKSU I"
                                                            @if (old('kategori_pengerusi') == 'TKSU I') selected @endif>TKSU(I)
                                                        </option>
                                                        <option value="TKSU P"
                                                            @if (old('kategori_pengerusi') == 'TKSU P') selected @endif>TKSU(P)
                                                        </option>
                                                        <option value="TKSU PP"
                                                            @if (old('kategori_pengerusi') == 'TKSU PP') selected @endif>TKSU(PP)
                                                        </option>
                                                        <option value="0"
                                                            @if (old('kategori_pengerusi') == '0') selected @endif>
                                                            Lain-Lain</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="div_pengerusi" style="display: none">
                                                <div class="form-group row">
                                                    <label for="nama_pengerusi"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Nama Pengerusi') }}</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" type="text" id="nama_pengerusi"
                                                            name="nama_pengerusi" id="pengerusi"
                                                            value="{{ old('nama_pengerusi') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="alert alert-warning" role="alert" id="alert_bil_tempahan"
                                                style="display:none">
                                                <b>Mesej</b>
                                                <li>Had maksimum <b>50 pax</b> (TKSU/KSU/YBTM/YBM)</li>
                                                <li>Had maksimum <b>35 pax</b> (Lain-lain)</li>
                                                <li>Sekiranya melebihi had maksimum, bahagian perlu membuat tempahan katerer
                                                    luar</li>
                                                <li>Had maksimum dikecualikan bagi Mesyuarat Pengurusan dan Mesyuarat
                                                    <i>Post-Cabinet.</i>
                                                </li>
                                            </div>

                                            <div class="form-group row">
                                                <label for="bil_tempah"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Bil.Tempahan/Kehadiran') }}</label>
                                                <div class="col-md-2">
                                                    <input id="bil_tempah" type="text" class="form-control"
                                                        name="bilangan_tempahan" value="{{ old('bilangan_tempahan') }}"
                                                        onkeyup="return bilTempah()" autocomplete="bilangan_tempahan"
                                                        placeholder="Bil. Orang">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="tab-pane fade" id="maklumat_bilik">
                            <fieldset>

                                <div class="card-group-control card-group-control-left">

                                    {{-- Borang Urusetia --}}
                                    <div class="card bg-light">

                                        {{-- <div class="card-header">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline form-check-right">
                                                <label class="form-check-label">
                                                    <i class="icon-file-plus mr-2"></i>
                                                    <span class="text-primary">Permohononan Tempahan Bilik</span>
                                                    <input type="checkbox" id="room_selected" name="room_selected"
                                                        class="form-check-input" onclick="showHideForm()">
                                                </label>
                                            </div>
                                        </div>

                                    </div> --}}

                                        {{-- <div id="form_room_urusetia" style="display: none"> --}}

                                        <div id="collapsible-control-group1" class="collapse show">

                                            <div class="card-header bg-white d-flex justify-content-between">
                                                <span class="text-default"><b>Maklumat Urusetia</b></span>
                                            </div>

                                            <div class="card-body">

                                                <div class="form-group">
                                                    <div class="form-check form-check-inline form-check-right">
                                                        <label class="form-check-label">
                                                            <span>Maklumat Seperti <a href="#" data-toggle="modal"
                                                                    data-target="#modal_default"> Pemohon</a></span>
                                                            <input type="checkbox" id="copy_applicant"
                                                                name="copy_applicant" class="form-check-input"
                                                                onclick="copyApplicantInfo()">
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
                                                                    value="{{ old('nama_urusetia') }}"
                                                                    autocomplete="no_sambungan">
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
                                                                    value="{{ old('email_urusetia') }}"
                                                                    autocomplete="no_sambungan">
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
                                                                    data-placeholder="Pilih Jawatan" class="form-control">
                                                                    <option>Pilih Jawatan</option>
                                                                    @foreach ($positions as $position)
                                                                        <option value="{{ $position->id }}"
                                                                            @if (old('jawatan_urusetia') == $position->id) selected @endif>
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
                                                                <select name="bahagian_urusetia" id="bahagian_urusetia"
                                                                    data-placeholder="Pilih Bahagian"
                                                                    class="form-control">
                                                                    <option>Pilih Bahagian</option>
                                                                    @foreach ($departments as $department)
                                                                        <option value="{{ $department->id }}"
                                                                            @if (old('bahagian_urusetia') == $department->id) selected @endif>
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
                                                                <input id="no_sambungan_urusetia" type="text"
                                                                    class="form-control" name="no_sambungan_urusetia"
                                                                    value="{{ old('no_sambungan_urusetia') }}"
                                                                    autocomplete="no_sambungan_urusetia">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="no_bimbit_urusetia"
                                                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>
                                                            <div class="col-md-8">
                                                                <input id="no_bimbit_urusetia" type="text"
                                                                    class="form-control" name="no_bimbit_urusetia"
                                                                    value="{{ old('no_bimbit_urusetia') }}"
                                                                    autocomplete="no_bimbit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- </div> --}}
                                    </div>
                                </div>
                                {{-- <div id="form_room" style="display: none"> --}}
                                <div class="card card bg-light">
                                    <div class="card-header bg-white d-flex justify-content-between">
                                        <span class="text-default"><b>Maklumat Mesyuarat</b></span>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="kategori_mesyuarat"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                                            <div class="col-md-9">
                                                <select name="kategori_mesyuarat"
                                                    data-placeholder="Pilih Kategori Mesyuarat" class="form-control">
                                                    <option>Pilih Kategori Mesyuarat</option>
                                                    <option value="1"
                                                        @if (old('kategori_mesyuarat') == '1') selected @endif>
                                                        Mesyuarat Pengurusan Tertinggi</option>
                                                    <option value="2"
                                                        @if (old('kategori_mesyuarat') == '2') selected @endif>
                                                        Mesyuarat Lain-lain</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="penganjur"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                                            <div class="col-md-9">
                                                <select name="penganjur" id="penganjur"
                                                    data-placeholder="Pilih Penganjur" class="form-control"
                                                    onchange="alert_nama_penganjur()">
                                                    <option>Pilih Penganjur</option>
                                                    <option value="SENDIRI"
                                                        @if (old('penganjur') == 'SENDIRI') selected @endif>Sendiri</option>
                                                    <option value="BERSAMA"
                                                        @if (old('penganjur') == 'BERSAMA') selected @endif>
                                                        Bersama/Kolabrasi</option>
                                                    <option value="LUAR"
                                                        @if (old('penganjur') == 'LUAR') selected @endif>
                                                        Luar</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="div_nama_penganjur" style="display: none">
                                            <div class="form-group row">
                                                <label for="nama_penganjur"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                                                <div class="col-md-9">
                                                    <input id="nama_penganjur" type="text" class="form-control"
                                                        name="nama_penganjur" value="{{ old('nama_penganjur') }}"
                                                        autocomplete="nama_penganjur">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_upload" style="display: none">
                                            <div class="form-group row">
                                                <label for="surat_emel"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                                                <div class="col-md-9">
                                                    <input type="file" class="form-control-uniform-custom"
                                                        name="surat_emel" id="surat_emel">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sajian"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Sajian') }}</label>
                                            <div class="col-md-9">
                                                <select name="sajian" id="sajian" data-placeholder="Pilih Sajian"
                                                    onChange="java_script_:sajianSelected(this.options[this.selectedIndex].value)"
                                                    class="form-control form-control-select2">
                                                    <option></option>
                                                    <option value="Tidak Perlu"
                                                        @if (old('sajian') == 'Tidak Perlu') selected @endif>Tidak Perlu
                                                    </option>
                                                    <option value="Pantri Dalaman"
                                                        @if (old('sajian') == 'Pantri Dalaman') selected @endif>Pantri Dalaman
                                                    </option>
                                                    <option value="Katerer Luar"
                                                        @if (old('sajian') == 'Katerer Luar') selected @endif>Katerer Luar
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="div_sajian" style="display: none">
                                            <div class="form-group row">

                                                <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                                                <div id="div_minum_pagi" style="display: none">
                                                    <div class="col-md-12">
                                                        <div
                                                            class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="minum_pagi" name="minum_pagi" value="1"
                                                                @if (old('minum_pagi')) checked @endif>
                                                            <label class="custom-control-label position-static"
                                                                for="minum_pagi">Minum Pagi</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="div_makan_tengahari" style="display: none">
                                                    <div class="col-md-12">
                                                        <div
                                                            class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="makan_tengahari" name="makan_tengahari"
                                                                value="1"
                                                                @if (old('makan_tengahari')) checked @endif>
                                                            <label class="custom-control-label position-static"
                                                                for="makan_tengahari">Makan Tengahari</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="div_minum_petang" style="display: none">
                                                    <div class="col-md-12">
                                                        <div
                                                            class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="minum_petang" name="minum_petang" value="1"
                                                                @if (old('minum_petang')) checked @endif>
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
                                                <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room">{{ old('catatan_room') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}

                            </fieldset>
                        </div>

                        <div class="tab-pane fade" id="maklumat_vc">
                            <fieldset>

                                <div class="card card bg-light">
                                    <div class="card-header">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline form-check-right">
                                                <label class="form-check-label">
                                                    <i class="icon-file-plus mr-2"></i>
                                                    <span class="text-primary">Permohononan Tempahan VC</span>
                                                    <input type="checkbox" id="vc_selected" name="vc_selected"
                                                        class="form-check-input" onclick="showHideForm()">
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div id="form_vc" style="display: none"> --}}
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                                            <div class="col-md-1">
                                                <div class="custom-control custom-control-right custom-radio">
                                                    <input type="radio" class="custom-control-input" name="webex"
                                                        id="ya" value="1" onclick="webexSelected()"
                                                        @if (old('webex') == '1') checked @endif>
                                                    <label class="custom-control-label position-static"
                                                        for="ya">Ya</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="custom-control custom-control-right custom-radio">
                                                    <input type="radio" class="custom-control-input" name="webex"
                                                        id="tidak" value="0" onclick="webexSelected()"
                                                        @if (old('webex') == '0') checked @endif>
                                                    <label class="custom-control-label position-static"
                                                        for="tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_nama_aplikasi" style="display: none">
                                            <div class="form-group row">
                                                <label for="nama_aplikasi"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}</label>
                                                <div class="col-md-9">
                                                    <input id="nama_aplikasi" type="text" class="form-control"
                                                        name="nama_aplikasi" value="{{ old('nama_aplikasi') }}"
                                                        autocomplete="nama_aplikasi">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="catatan"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                                            <div class="col-md-9">
                                                <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_vc">{{ old('catatan_vc') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- </div> --}}

                                </div>
                            </fieldset>
                        </div>

                    </div>
                    <div class="card-footer text-center">

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="perakuan" id="perakuan"
                                        value="1">
                                    <label class="custom-control-label" for="perakuan">Pemohon bertanggung jawab di atas
                                        permohonan yang dibuat</label>
                                </div>
                            </div>
                        </div>


                        <button type="submit" id="btn-submit" class="btn btn-primary btn-sm">Hantar
                            Permohonan</button>
                    </div>
                </form>

            </div>

        </div>
    </body>

    <!-- Basic modal -->
    <div id="modal_default" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                </div>

                <div class="modal-body">
                    <h6 class="font-weight-semibold">Maklumat Pemohon</h6>
                    {{-- Papar Maklumat Pemohon --}}
                    <div class="card bg-light">

                        {{-- <div id="papar_maklumat_pemohon" class="collapse"> --}}
                        <div class="card-body">
                            <table class="table table-lg">
                                <tbody>

                                    <tr>
                                        <td class="text-right"><span class="text-default">Nama</span></td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">E-mel</span></td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">Jawatan</span></td>
                                        <td>Penolong Pegawai Teknologi Maklumat</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">Bahagian</span></td>
                                        <td>Bahagian Pengurusan Maklumat</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">No. Sambungan</span></td>
                                        <td>2358</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><span class="text-default">No. Telefon Bimbit</span>
                                        </td>
                                        <td>017-23412000</td>
                                    </tr>

                                </tbody>
                            </table>


                        </div>

                    </div>
                    {{-- Borang Urusetia --}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic modal -->
@endsection

@section('script')
    <script>
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
            webexSelected()
            alert_nama_penganjur()
        }

        function activationPerakuan(tab) {
            var perakuan = document.getElementById("perakuan");

            if (tab == 'idAppTab') {
                perakuan.disabled == true;
            }
            if (tab == 'idRoomTab') {
                perakuan.disabled == false;
            }
            if (tab == 'idVcTab') {
                perakuan.style.display == false;
            }
        }

        function selectRoom() {
            // var room_selected = document.getElementById("room_selected").value;
            var room = document.getElementById("room").value;

            var roomId = room.substr(room.length - 3, 1);
            var is_auto = room.substr(room.length - 2, 1);
            var is_upload = room.substr(room.length - 1);

            var div_alert_bilik_manual = document.getElementById("div_alert_bilik_manual");
            document.getElementById("is_auto_input").value = is_auto;
            document.getElementById("is_upload_input").value = is_upload;

            if (is_upload == 'Y') {
                document.getElementById("div_upload").style.display = "block";
            } else {
                document.getElementById("div_upload").style.display = "none";
            }

            if (is_auto == 'N') {
                div_alert_bilik_manual.style.display = "block";
                document.getElementById("idRoomTab").className = "nav-link rounded-round disabled";
                document.getElementById("idVcTab").className = "nav-link rounded-round enabled";
                // document.getElementById("room_selected").checked = false;
                document.getElementById("availabilityRoom").style.display = "none";

            } else {
                div_alert_bilik_manual.style.display = "none";
                document.getElementById("idRoomTab").className = "nav-link rounded-round enabled";
                document.getElementById("idVcTab").className = "nav-link rounded-round enabled";

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
            var nama = "<?php echo $user->name; ?>";
            var emel = "<?php echo $user->email; ?>";
            var jawatan_urusetia_id = "<?php echo $profile->position_id; ?>";
            var bahagian_urusetia_id = "<?php echo $profile->department_id; ?>";
            var no_sambungan_urusetia = "<?php echo $profile->no_extension; ?>";
            var no_bimbit_urusetia = "<?php echo $profile->no_bimbit; ?>";

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
            //     var room_selected = document.getElementById("room_selected");
            var vc_selected = document.getElementById("vc_selected");
            var form_room_urusetia = document.getElementById("form_room_urusetia");
            var form_room = document.getElementById("form_room");
            var form_vc = document.getElementById("form_vc");
            var perakuan = document.getElementById("perakuan");
            // var submitBtn = document.getElementById("submit");
            var submitBtn = document.getElementById("sweet_warning");

            if (room_selected.checked == true || vc_selected.checked == true) {
                perakuan.disabled = false;
                submitBtn.disabled = false;
            } else if (room_selected.checked == false || vc_selected.checked == false) {
                perakuan.disabled = true;
                submitBtn.disabled = true;
            }
            if (room_selected.checked == true) {
                form_room.style.display = "block";
                form_room_urusetia.style.display = "block";
            } else {
                form_room.style.display = "none";
                form_room_urusetia.style.display = "none";
                perakuan.disabled = false;
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
                // alert(strUser);
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
