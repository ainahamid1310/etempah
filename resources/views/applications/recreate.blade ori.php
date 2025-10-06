@extends('layouts.backend_applicant')

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
                <h5>Permohonan Tempahan (Salin)</h5>
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

                <form method="post" id="applicationFormRecreate" action="/application/applicant/create" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content">
                        <!-- Tab 1 -->

                        <div class="tab-pane fade show active" id="maklumat_permohonan">
                            
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">Nama Bilik/Lokasi</label>
                                <div class="col-md-9">
                                    <select id="room" name="room" class="form-control select-search @error('room') is-invalid @enderror" data-placeholder="Pilih Nama Bilik/Lokasi">
                                        <option></option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                data-auto="{{ $room->is_auto }}"
                                                data-upload="{{ $room->is_upload }}"
                                                data-pantry="{{ $room->is_pantry }}"                                               
                                                {{ old('room', $application->room_id) == $room->id ? 'selected' : '' }}>
                                                {{ $room->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" id="is_auto" name="is_auto" value="{{ old('is_auto') }}">
                                    <input type="hidden" id="is_upload" name="is_upload"
                                        value="{{ old('is_upload') }}">
                                    <input type="hidden" id="is_pantry" name="is_pantry"
                                        value="{{ old('is_pantry') }}">


                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 25%;">Tarikh/Masa Mula</th>
                                        <th class="text-center" style="width: 25%;">Tarikh/Masa Tamat</th>         
                                        <th style="width: 20%;">Ketersediaan/Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody id="booking-rows">
                                    <tr class="booking-row align-middle">
                                        <td>
                                            @php
                                                $index = 0; // atau $loop->index jika dalam @foreach
                                            @endphp

                                            <div class="input-group">
                                                <input type="text"
                                                    name="bookings[{{ $index }}][start]"
                                                    value="{{ old("bookings.$index.start") }}"
                                                    class="form-control start-input flatpickr-date text-center @error("bookings.$index.start") is-invalid @enderror">

                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>

                                                @error("bookings.$index.start")
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-white text-danger" title="{{ $message }}">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        </span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text"
                                                    name="bookings[{{ $index }}][end]"
                                                    value="{{ old("bookings.$index.end") }}"
                                                    class="form-control end-input flatpickr-date text-center @error("bookings.$index.end") is-invalid @enderror">

                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>

                                                @error("bookings.$index.end")
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-white text-danger" title="{{ $message }}">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        </span>
                                                    </div>
                                                @enderror
                                            </div>
                                            
                                        </td>
                                        
                                        
                                        <td style="display: flex; align-items: center; gap: 6px; font-size: 1.25rem;">
                                            <span class="availability-status small" title="Klik untuk melihat tarikh TIDAK TERSEDIA">
                                                <!-- <i class="fas fa-times-circle text-danger"></i> -->
                                            </span>
                                            <a href="javascript:void(0)" class="text-danger remove-row" style="display: none;" title="Padam baris">
                                                <i class="fas fa-trash-alt fa-sm"></i>
                                            </a>
                                        </td>
                                                                                                    
                                    </tr>
                                    <!-- <tr class="booking-row align-middle" data-index="{{ $index }}"> -->
                                </tbody>
                            </table>

                            <!-- <fieldset> -->
                                <div class="card card bg-light">

                                    <div id="form_permohonan" class="collapse show">
                                        <div class="card-body">

                                            <!-- <div class="form-group row">
                                                <label for="tarikh_mula"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Mula') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="datetime-local" id="tarikh_mula"
                                                        name="tarikh_mula" value="{{ old('tarikh_mula', date('Y-m-d\TH:i', strtotime($application->tarikh_mula))) }}"
                                                        onchange="selectRoom()">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tarikh_hingga"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Tamat') }}</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" type="datetime-local" id="tarikh_hingga"
                                                        name="tarikh_hingga"
                                                        value="{{ old('tarikh_hingga', date('Y-m-d\TH:i', strtotime($application->tarikh_hingga))) }}"
                                                        onchange="selectRoom()">
                                                </div>
                                            </div> -->

                                            <div class="form-group row">
                                                <label for="nama_mesyuarat"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tajuk Mesyuarat/Program') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nama_mesyuarat"
                                                        value="{{ old('nama_mesyuarat', $application->nama_mesyuarat) }}">
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
                                                <strong>Makluman : </strong> <b>Bilik sendiri</b> tidak perlu proses
                                                kelulusan
                                                bilik . Hanya permohonan VC akan diproses.
                                            </div>

                                            {{-- <div class="alert alert-warning border-0 alert-dismissible" id="div_alert_wifimiti" style="display: none">
                                                <button type="button" class="close" data-dismiss="alert"></button>
                                                <strong>Makluman : </strong> Sekiranya memerlukan Voucher <b>MITIWIFI_Guest</b>, sila emelkan permohonan kepada urki@miti.gov.my
                                            </div> --}}

                                            <div id="availabilityRoom">
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="bilik"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Nama Bilik/Lokasi') }}</label>
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
                                                    <input type="hidden" id="is_pantry_input" name="is_pantry_input"
                                                        value="{{ old('is_pantry_input') }}">
                                                </div>
                                            </div> -->

                                            <div class="form-group row">
                                                <label for="kategori_pengerusi"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Kategori Pengerusi') }}</label>
                                                <div class="col-md-9">
                                                    <select name="kategori_pengerusi" id="kategori_pengerusi"
                                                        data-placeholder="Pilih Kategori Pengerusi"
                                                        class="form-control select-search" onchange="kategoriPengerusi()">
                                                        <option></option>
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
                                                        <option value="TKSU SP"
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
                                                <label for="bil_tempah"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Bil.Tempahan/Kehadiran') }}</label>
                                                <div class="col-md-9">
                                                    <input id="bil_tempah" type="text" class="form-control"
                                                        name="bilangan_tempahan"
                                                        value="{{ old('bil_tempah', $application->bilangan_tempahan) }}"
                                                        onkeyup="return bilTempah()" autocomplete="bil_tempah">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <a class="btn btn-primary" href="#maklumat_bilik" onclick="next()" id="nextBtn"
                                        role="button">Seterusnya</a>
                                </div>
                            <!-- </fieldset> -->
                        </div>


                        <div class="tab-pane fade" id="maklumat_bilik">

                            @if (isset($application->applicationRoom))
                                @include('applications.room.edit')
                            @else
                                @include('applications.room.create')
                            @endif

                            <div class="text-center">
                                <a class="btn btn-secondary" href="#maklumat_permohonan" onclick="previous()"
                                    id="preBtn" role="button">Kembali</a>
                                <a class="btn btn-primary" href="#maklumat_vc" id="nextBtn2" role="button"
                                    onclick="nextRoom()" id="nextBtn">Seterusnya</a>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="maklumat_vc">
                            @if (isset($application->applicationVc))
                                @include('applications.vc.edit')
                            @else
                                @include('applications.vc.create')
                            @endif
                            <div class="card-footer">
                                <fieldset>
                                    <legend><b><i>Perakuan</i></b></legend>
                                    <div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="perakuan"
                                                    id="perakuan" value="1">
                                                <label class="custom-control-label" for="perakuan">Pemohon
                                                    bertanggungjawab di
                                                    atas maklumat dan permohonan yang telah dibuat.</label>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                                <div class="text-center">
                                    <a class="btn btn-secondary" href="#maklumat_bilik" onclick="previousVc()"
                                        id="preBtn2" role="button">Kembali</a>
                                    <button type="submit" id="submitButtonRecreate" class="btn btn-primary submit-btn">
                                        Hantar Permohonan
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>

                <script>
                document.getElementById('applicationForm').onsubmit = function() {
                    document.getElementById('submitButton').disabled = true;
                };
                </script>
            </div>

        </div>
    </body>

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
                                        <td class="text-right"><span class="text-default">Bahagian/Seksyen</span></td>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                </div>

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
            showHideForm();
            webexSelected();
            alert_nama_penganjur();
            selectRoom();

        }

        function next() {
            var nextBtn = document.getElementById("nextBtn");
            var room = document.getElementById("room").value;

            room_length = room.length;

            if (room_length == 5) {
                var roomId = room.substr(0, 2);
            }
            if (room_length == 4) {
                var roomId = room.substr(0, 1);
            }

            var is_auto = room.substr(room.length - 3, 1);

            if (nextBtn.click) {

                if (is_auto == 'N' || is_auto == 'S') {
                    // alert('N');
                    nextBtn.href = "#maklumat_vc";
                    document.getElementById("idAppTab").className = "nav-link rounded-round enabled";
                    document.getElementById("maklumat_permohonan").className = "tab-pane fade";
                    document.getElementById("idRoomTab").className = "nav-link rounded-round disabled";
                    document.getElementById("maklumat_bilik").className = "tab-pane fade";
                    document.getElementById("idVcTab").className = "nav-link rounded-round active";
                    document.getElementById("maklumat_vc").className = "tab-pane fade show active";

                } else {
                    // alert('Y');
                    nextBtn.href = "#maklumat_bilik";
                    document.getElementById("idAppTab").className = "nav-link rounded-round enabled";
                    document.getElementById("maklumat_permohonan").className = "tab-pane fade";
                    document.getElementById("idRoomTab").className = "nav-link rounded-round active";
                    document.getElementById("maklumat_bilik").className = "tab-pane fade show active";
                    document.getElementById("idVcTab").className = "nav-link rounded-round enabled";
                    document.getElementById("maklumat_vc").className = "tab-pane fade";
                }
            }
        }

        function nextRoom() {
            var nextBtn2 = document.getElementById("nextBtn2");

            var room = document.getElementById("room").value;

            room_length = room.length;

            if (room_length == 5) {
                var roomId = room.substr(0, 2);
            }
            if (room_length == 4) {
                var roomId = room.substr(0, 1);
            }

            var is_auto = room.substr(room.length - 3, 1);
            document.getElementById("idVcTab").className = "nav-link rounded-round active";
            document.getElementById("maklumat_vc").className = "tab-pane fade show active";

            if (is_auto == 'N' || is_auto == 'S') {
                document.getElementById("idRoomTab").className = "nav-link rounded-round disabled";
                document.getElementById("maklumat_bilik").className = "tab-pane fade";
            } else {
                document.getElementById("idRoomTab").className = "nav-link rounded-round enabled";
                document.getElementById("maklumat_bilik").className = "tab-pane fade";
            }

        }

        function previous() {

            document.getElementById("maklumat_bilik").className = "tab-pane fade";
            document.getElementById("maklumat_permohonan").className = "tab-pane fade show active";
            document.getElementById("idAppTab").className = "nav-link rounded-round active";
            document.getElementById("idRoomTab").className = "nav-link rounded-round";
        }

        function previousVc() {

            var room = document.getElementById("room").value;

            room_length = room.length;

            if (room_length == 5) {
                var roomId = room.substr(0, 2);
            }
            if (room_length == 4) {
                var roomId = room.substr(0, 1);
            }

            var is_auto = room.substr(room.length - 3, 1);

            if (is_auto == 'N' || is_auto == 'S') {
                nextBtn.href = "#maklumat_permohonan";
                document.getElementById("idAppTab").className = "nav-link rounded-round active";
                document.getElementById("maklumat_permohonan").className = "tab-pane fade show active";
                document.getElementById("idRoomTab").className = "nav-link rounded-round disabled";
                document.getElementById("maklumat_bilik").className = "tab-pane fade";
                document.getElementById("idVcTab").className = "nav-link rounded-round";
                document.getElementById("maklumat_vc").className = "tab-pane fade";
            } else {
                nextBtn.href = "#maklumat_bilik";
                document.getElementById("idAppTab").className = "nav-link rounded-round";
                document.getElementById("maklumat_permohonan").className = "tab-pane fade";
                document.getElementById("idRoomTab").className = "nav-link rounded-round active";
                document.getElementById("maklumat_bilik").className = "tab-pane fade show active";
                document.getElementById("idVcTab").className = "nav-link rounded-round";
                document.getElementById("maklumat_vc").className = "tab-pane fade";
            }

        }

        function kategoriPengerusi() {

            var kategori_pengerusi = document.getElementById("kategori_pengerusi").value;
            var pengerusi = document.getElementById("div_pengerusi");

            if (kategori_pengerusi == "0") {
                pengerusi.style.display = "block";
            } else {
                pengerusi.style.display = "none";
            }
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
            // document.getElementById("div_sajian").style.display = "none";
            var room = document.getElementById("room").value;
            room_length = room.length;

            // alert(room);
            if (room_length == 5) {
                var roomId = room.substr(0, 2);
            }
            if (room_length == 4) {
                var roomId = room.substr(0, 1);
            }

            var is_auto = room.substr(room.length - 3, 1);
            var is_upload = room.substr(room.length - 2, 1);
            var is_pantry = room.substr(room.length - 1);
            var div_alert_bilik_manual = document.getElementById("div_alert_bilik_manual");

            document.getElementById("is_auto_input").value = is_auto;
            document.getElementById("is_upload_input").value = is_upload;
            document.getElementById("is_pantry_input").value = is_pantry;

            if (room == '20YYN' || room == '21YYN' || room == '32YYN' ){
            document.getElementById("div_alert_wifimiti").style.display = "block";

            } else {
            document.getElementById("div_alert_wifimiti").style.display = "none";

            }

            if (is_upload == 'Y') {
                document.getElementById("div_upload").style.display = "block";
            } else {
                document.getElementById("div_upload").style.display = "none";
            }


            if (is_pantry == 'N') {
                //  document.getElementById("sajian").value = "";
                document.getElementById("sajian").disabled = true;
                document.getElementById("mesej_tiada_sajian").style.display = "block";
                document.getElementById("div_sajian").style.display = "none";
                document.getElementById("minum_pagi").checked = false;
                document.getElementById("makan_tengahari").checked = false;
                document.getElementById("minum_petang").checked = false;

            } else if(is_pantry == 'Y') {
                document.getElementById("sajian").disabled = false;
                document.getElementById("mesej_tiada_sajian").style.display = "none";
                document.getElementById("div_sajian").style.display = "none";
            }else{

            }

            if (is_auto == 'N') {
                div_alert_bilik_manual.style.display = "block";
                div_alert_bilik_sendiri.style.display = "none";
                document.getElementById("idRoomTab").className = "nav-link rounded-round disabled";
                document.getElementById("idVcTab").className = "nav-link rounded-round enabled";
                document.getElementById("availabilityRoom").style.display = "none";
                // idRoomBtn.href = "#maklumat_vc";
            } else if (is_auto == 'S') {
                div_alert_bilik_manual.style.display = "none";
                div_alert_bilik_sendiri.style.display = "block";
                document.getElementById("idRoomTab").className = "nav-link rounded-round disabled";
                document.getElementById("idVcTab").className = "nav-link rounded-round enabled";
                document.getElementById("availabilityRoom").style.display = "none";
            } else {
                div_alert_bilik_manual.style.display = "none";
                div_alert_bilik_sendiri.style.display = "none";
                document.getElementById("idRoomTab").className = "nav-link rounded-round enabled";
                document.getElementById("idVcTab").className = "nav-link rounded-round enabled";
                // idRoomBtn.href = "#maklumat_bilik";


                // Tambah checking bilik
                var tarikh_mula = document.getElementById("tarikh_mula").value;
                var tarikh_hingga = document.getElementById("tarikh_hingga").value;

                if (roomId.length == 0 || tarikh_mula.length == 0 || tarikh_hingga.length == 0) {

                    document.getElementById("availabilityRoom").innerHTML = "";
                    document.getElementById("availabilityRoom").style.border = "0px";
                    return;
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

        function alert_nama_penganjur() {

            var penganjur = document.getElementById("penganjur").value;
            var nama_penganjur = document.getElementById("div_nama_penganjur");

            if (penganjur == "BERSAMA" || penganjur == "LUAR") {
                nama_penganjur.style.display = "block";
            } else {
                nama_penganjur.style.display = "none";
            }
        }

        function sajianSelected(select_item) {

            if (select_item == "Katerer Luar") {
                div_sajian.style.display = 'block';
                div_minum_pagi.style.display = 'block';
                div_makan_tengahari.style.display = 'block';
                div_minum_petang.style.display = 'block';
                // document.getElementById("mesej_sajian_dalaman").style.display = "none";

            } else if (select_item == "Pantri Dalaman") {
                div_sajian.style.display = 'block';
                div_minum_pagi.style.display = 'block';
                div_minum_petang.style.display = 'block';
                div_makan_tengahari.style.display = 'none';
                // document.getElementById("mesej_sajian_dalaman").style.display = "block";

            } else if (select_item == "Tidak Perlu") {
                div_sajian.style.display = 'none';
                // document.getElementById("mesej_sajian_dalaman").style.display = "none";
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
            var jawatan_urusetia_id = "<?php echo $user->profile->position_id; ?>";
            var bahagian_urusetia_id = "<?php echo $user->profile->department_id; ?>";
            var no_sambungan_urusetia = "<?php echo $user->profile->no_extension; ?>";
            var no_bimbit_urusetia = "<?php echo $user->profile->no_bimbit; ?>";

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
            var vc_selected = document.getElementById("vc_selected");
            var form_room_urusetia = document.getElementById("form_room_urusetia");
            var form_vc = document.getElementById("form_vc");

            if (vc_selected.checked == true) {
                form_vc.style.display = "block";
            } else {
                form_vc.style.display = "none";
                // document.getElementById("tidak").value = null;
                // document.getElementById("ya").value = null;
                // document.getElementById("peralatan_ya").value = null;
                // document.getElementById("peralatan_tidak").value = null;
            }
        }

        // function bilTempah() {
        //     var a = document.getElementById("bil_tempah").value;

        //     if (a > 35) {
        //         document.getElementById("alert_bil_tempahan").style.display = "block";
        //     } else {
        //         document.getElementById("alert_bil_tempahan").style.display = "none";
        //     }
        // }
    </script>
@endsection
