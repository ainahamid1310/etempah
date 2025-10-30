@extends('layouts.backend_admin')

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
                <h5>Kemaskini Tempahan</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round"
                            data-toggle="tab">Maklumat
                            Permohonan</a></li>
                    {{-- <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round"
                        data-toggle="tab">Permohonan Tempahan Bilik</a></li> --}}
                    <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round active"
                            data-toggle="tab">Permohonan
                            Tempahan VC</a></li>
                    <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Maklumat
                            Pemohon/Urusetia Bilik
                        </a></li>
                    {{-- <li class="nav-item"><a href="#hantar" class="nav-link rounded-round" data-toggle="tab">Hantar Permohonan</a></li> --}}

                </ul>
                <form method="post" enctype="multipart/form-data"
                    action="/admin/application_vc/result/{{ $application->id }}">
                    @csrf
                    <div class="tab-content">

                        <div class="tab-pane fade" id="maklumat_permohonan">
                            <fieldset>
                                <div class="card card bg-light">

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
                                                        value="{{ date('d-m-Y H:i', strtotime($application->tarikh_mula)) }}"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tarikh_hingga"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Tamat') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="tarikh_hingga"
                                                        value="{{ date('d-m-Y H:i', strtotime($application->tarikh_hingga)) }}"
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
                                                <li>Sekiranya melebihi had maksimum, bahagian perlu membuat tempahan katerer
                                                    luar</li>
                                                <li>Had maksimum dikecualikan bagi Mesyuarat Pengurusan dan Mesyuarat
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
                            </fieldset>
                        </div>

                        <div class="tab-pane fade show active" id="maklumat_vc">

                            <fieldset>
                                <div class="card-body">

                                    <div class="form-group row">

                                        <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                                        <div class="col-md-1">
                                            <div class="custom-control custom-control-right custom-radio">
                                                <input type="radio" class="custom-control-input" name="akaun_webex"
                                                    id="ya" value="1" onclick="webexSelected()"
                                                    @if (old('akaun_webex', $application->applicationVc->webex) == '1') checked @endif>
                                                <label class="custom-control-label position-static"
                                                    for="ya">Ya</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="custom-control custom-control-right custom-radio">
                                                <input type="radio" class="custom-control-input" name="akaun_webex"
                                                    id="tidak" value="0" onclick="webexSelected()"
                                                    @if (old('akaun_webex', $application->applicationVc->webex) == '0') checked @endif>
                                                <label class="custom-control-label position-static"
                                                    for="tidak">Tidak</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label class="col-md-3 text-md-right">Memerlukan Peralatan VC</label>
                                        <div class="col-md-1">
                                            <div class="custom-control custom-control-right custom-radio">
                                                <input type="radio" class="custom-control-input" name="peralatan"
                                                    id="peralatan_ya" value="1"
                                                    @if (old('peralatan', $application->applicationVc->peralatan) == '1') checked @endif>
                                                <label class="custom-control-label position-static"
                                                    for="peralatan_ya">Ya</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="custom-control custom-control-right custom-radio">
                                                <input type="radio" class="custom-control-input" name="peralatan"
                                                    id="peralatan_tidak" value="0"
                                                    @if (old('peralatan', $application->applicationVc->peralatan) == '0') checked @endif>
                                                <label class="custom-control-label position-static"
                                                    for="peralatan_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                    <label for="catatan"
                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Pemohon') }}</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="2" class="form-control" name="catatan_vc" readonly>
                            {{ trim($application->applicationVc->catatan) }}</textarea>
                                    </div>
                                </div> --}}

                                    <div id="div_webex" style="display: none">
                                        <fieldset>
                                            <legend><i class="icon-user"></i>Tindakan Penyelia VC</legend>
                                            <div class="form-group row">
                                                <label for="link_webex"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Log Masuk WEBEX') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-md-9">

                                                    @if (!empty($application->applicationVc->link_webex))
                                                        <input type="text" class="form-control" id="link_webex"
                                                            name="link_webex"
                                                            value="{{ $application->applicationVc->link_webex }}">
                                                    @else
                                                        <input type="text" class="form-control" id="link_webex"
                                                            name="link_webex"
                                                            value="{{ old('link_webex', 'miti.webex.com') }}">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="id_webex"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('ID WEBEX') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-md-6">

                                                    @if (!empty($application->applicationVc->id_webex))
                                                        <input type="text" class="form-control" id="id_webex"
                                                            name="id_webex"
                                                            value="{{ $application->applicationVc->id_webex }}"
                                                            placeholder="id@miti.gov.my">
                                                    @else
                                                        <input type="text" class="form-control" id="id_webex"
                                                            name="id_webex" value="{{ old('id_webex') }}"
                                                            placeholder="id@miti.gov.my">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password_webex"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Kata laluan WEBEX') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="password_webex"
                                                        id="password_webex"
                                                        value="{{ old('password_webex', $application->applicationVc->password_webex) }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password_expired"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Luput Kata laluan') }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-md-9">
                                                    @if (!empty($application->applicationVc->password_expired))
                                                        <input class="form-control" type="date" id="password_expired"
                                                            name="password_expired"
                                                            value="{{ old('password_expired', date('Y-m-d', strtotime($application->applicationVc->password_expired))) }}">
                                                    @else
                                                        <input class="form-control" type="date" id="password_expired"
                                                            name="password_expired"
                                                            value="{{ old('password_expired') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div id="div_nama_aplikasi" style="display: none">

                                        <div class="form-group row">
                                            <label for="nama_aplikasi"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input id="nama_aplikasi" type="text"
                                                    class="form-control @error('no_extension') is-invalid @enderror""
                                                    name="nama_aplikasi"
                                                    value="{{ old('nama_aplikasi', $application->applicationVc->nama_aplikasi) }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                        </div>

                        <div class="tab-pane fade" id="maklumat_bilik">

                            @if (isset($application->applicationRoom))
                                @include('applications.room.view')
                            @else
                                <div class="text-center text-danger">-Tiada Permohonan-</div>
                            @endif

                        </div>

                    </div>
                    <div class="card-footer text-center">

                        <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                            Kembali</button>
                        {{-- <a href="/admin/application_room/result/{{ $application->applicationVc->id }}"><button type="submit"
                            name="button" value="2" class="btn btn-primary btn-sm">Lulus</button></a>
                    <button type="button" name="button" value="4" data-toggle="modal" data-target="#modal_tolak"
                        class="btn btn-danger btn-sm">Tolak</button> --}}
                        <input name="button" value="12" type="hidden">
                        <button type="submit" class="btn btn-primary btn-sm">Lulus Dengan Pindaan</button>
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
                                                    <td class="text-right"><span class="text-default">Jawatan</span>
                                                    </td>
                                                    <td>{{ $application->user->profile->position->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">Bahagian</span>
                                                    </td>
                                                    <td>{{ $application->user->profile->department->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">No.
                                                            Sambungan</span></td>
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
                                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
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
        function onLoadFunction() {
            webexSelected();
        }

        function webexSelected() {
            var webex_ya = document.getElementById("ya");
            var webex_tidak = document.getElementById("tidak");
            var div_nama_aplikasi = document.getElementById("div_nama_aplikasi");
            var div_webex = document.getElementById("div_webex");

            if (webex_ya.checked == true) {
                div_nama_aplikasi.style.display = 'none';
                div_webex.style.display = 'block';
            }
            if (webex_tidak.checked == true) {
                div_nama_aplikasi.style.display = 'block';
                div_webex.style.display = 'none';

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
