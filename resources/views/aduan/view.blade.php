@extends('layouts.backend_applicant')

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/report" class="breadcrumb-item"> Aduan Pemohon</a>
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
                <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan Bilik</a></li>
                <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan VC</a></li>
                <li class="nav-item"><a href="#maklumat_aduan" class="nav-link rounded-round active"
                        data-toggle="tab">Aduan</a></li>

            </ul>
            {{-- <form method="post" enctype="multipart/form-data"> --}}
            @csrf
            <div class="tab-content">
                <div class="tab-pane fade" id="maklumat_permohonan">
                    <fieldset>
                        <div class="card card bg-light">

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
                                                    id="pengerusi" value="{{ old('nama_pengerusi') }}" readonly>
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
                                                name="bilangan_tempahan" value="{{ $application->bilangan_tempahan }}"
                                                readonly>
                                        </div>
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

                <div class="tab-pane fade  show active" id="maklumat_aduan">
                    @if (isset($application->report))
                        <fieldset>

                            <div class="card-group-control card-group-control-left">

                                <div class="card card bg-light">

                                    <div id="collapsible-control-group1" class="collapse show">

                                        <div class="card-body">

                                            <div class="form-group">
                                                <div class="form-check form-check-inline form-check-right">
                                                    <label class="form-check-label">
                                                        <span class="text-default">Maklumat Aduan</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="nama"
                                                            class="col-md-4 col-form-label text-md-right">{{ __('Aduan') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="nama_urusetia" type="text"
                                                                class="form-control " name="nama_urusetia"
                                                                value="{{ $application->report->aduan }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label for="email"
                                                            class="col-md-4 col-form-label text-md-right">{{ __('Cadangan Penambahbaikan') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="email_urusetia" type="text"
                                                                class="form-control" name="email_urusetia"
                                                                value="{{ $application->report->cadangan }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <form class="delete" method="POST"
                                                    action="/report/destroy/{{ $application->report->id }}">
                                                    {{ csrf_field() }}
                                                    <a href="/report/edit/{{ $application->report->id }}"><button
                                                            type="button" class="btn bg-success">Kemaskini</button></a>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn bg-warning submit-btn">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div>
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
