@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/application/{{ $tag = session()->get('tag') }}" class="breadcrumb-item"> Rekod Pemohon</a>
        <span class="breadcrumb-item active"> Kemaskini Tempahan</span>
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
                    <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round" data-toggle="tab"
                            id="idAppTab">Maklumat Permohonan</a></li>
                    <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab"
                            id="idRoomTab">Permohonan Tempahan Bilik</a></li>
                    <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round active" data-toggle="tab"
                            id="idVcTab">Permohonan Tempahan VC</a></li>

                </ul>
                <form method="post" enctype="multipart/form-data" action="/application/edit/{{ $application->id }}">
                    @csrf
                    <div class="tab-content">

                        <div class="tab-pane fade" id="maklumat_permohonan">
                            <fieldset>
                                <div class="card card bg-light">
                                    {{-- <div class="card-header">
                                <i class="icon-info22 mr-3"></i>
                                <span class="text-muted">Semua medan wajib diisi</span>
                            </div> --}}

                                    <div id="form_permohonan" class="collapse show">
                                        <div class="card-body">

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

                        <div class="tab-pane fade" id="maklumat_bilik">
                            @include('applications.room.view')
                        </div>

                        <div class="tab-pane fade show active" id="maklumat_vc">
                            @include('applications.vc.create')
                        </div>
                    </div>
                    <div class="card-footer text-center">

                        {{-- Perakuan --}}
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


                        <button type="submit" class="btn btn-success btn-sm">Kemaskini</button>
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
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">E-mel</span></td>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">Jawatan</span></td>
                                                    <td>{{ $user->profile->position->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">Bahagian</span></td>
                                                    <td>{{ $user->profile->department->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">No. Sambungan</span>
                                                    </td>
                                                    <td>{{ $user->profile->no_extension }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">No. Telefon
                                                            Bimbit</span></td>
                                                    <td>{{ $user->profile->no_bimbit }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
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
    </body>
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
            // var name = {{ $user->name }};
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
