@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Permohonan Tempahan</span>

    </div>
@endsection

@section('js_extensions')
<!-- +++++++++ UNTUK CELAR VALIDATION ERROR MESSAGE  +++++++++++++ -->
<script>

    function removeDateError(e) {
        const input = e.target;

        // Buang class is-invalid jika ada (optional kalau anda guna)
        input.classList.remove('is-invalid');

        // Cari elemen error icon (input-group-append) dalam input-group dan buang
        const group = input.closest('.input-group');
        if (!group) return;

        const errorIcon = group.querySelector('.input-group-append');
        if (errorIcon) {
            errorIcon.remove();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        function removeError(e) {
            const target = e.target;
            target.classList.remove('is-invalid');

            const feedback = target.closest('.form-group')?.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.style.display = 'none';
            }
        }

        // Semua input, select, textarea biasa
        document.querySelectorAll('input, select, textarea').forEach(function (el) {
            el.addEventListener('input', removeError);
            el.addEventListener('change', removeError);
        });

        // Untuk select2 sahaja
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select-search').on('select2:select', function () {
                const select = $(this);
                select.removeClass('is-invalid');
                select.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                select.closest('.form-group').find('.invalid-feedback').hide();
            });
        }

        // SEMAKAN SUSUNAN TARIKH BILA TARIKH DITUKAR
        document.querySelectorAll('input[name^="bookings"]').forEach(function (el) {
                el.addEventListener('change', function (e) {
                removeDateError(e);            // ✅ Buang error sebelum ini
                markInvalidSequenceRows();     // ✅ Semak susunan tarikh terkini
            });
        });


        // function removeDateError(e) {
        //     const input = e.target;

        //     // Buang class is-invalid jika ada (optional kalau anda guna)
        //     input.classList.remove('is-invalid');

        //     // Cari elemen error icon (input-group-append) dalam input-group dan buang
        //     const group = input.closest('.input-group');
        //     if (!group) return;

        //     const errorIcon = group.querySelector('.input-group-append');
        //     if (errorIcon) {
        //         errorIcon.remove();
        //     }
        // }

    });

</script>

@endsection

@section('content')

<style>
    .availability-status {
        display: block !important;
        font-weight: bold;
        color: red;
    }

    .swal2-icon.no-default-icon {
        display: flex;
        align-items: center;
        justify-content: center;


    }
        a.disabled {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
        text-decoration: none;
    }

    .swal2-icon.no-default-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        margin: 0 auto;
    }

    .nav-link.disabled {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }

        .nav-link.disabled {
        pointer-events: none;   /* elak boleh klik */
        opacity: 0.6;           /* bagi pudar */
        cursor: not-allowed;    /* tukar cursor */
    }

</style>

    <body>
        <div class="card">

            <div class="card-body">

                @if(session('email_error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('email_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                    <div class="tab-content">

                        <div class="card">

                            <div class="card-header">
                                <h5 class="mb-0">Permohonan Tempahan</h5>
                            </div>

                            <div class="card-body">

                                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#maklumat_permohonan" role="tab">
                                            Maklumat Permohonan
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-bilik" data-toggle="tab" href="#maklumat_bilik" role="tab">
                                            Permohonan Tempahan Bilik
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#maklumat_vc" role="tab">
                                            Permohonan Tempahan VC
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <form method="post" enctype="multipart/form-data"
                    action="/admin/application_room/edit/{{ $application->applicationRoom->id }}">
                                    @csrf
                                    <div class="tab-content">
                                        <!-- Tab 1 -->
                                        <div class="tab-pane fade show active" id="maklumat_permohonan" role="tabpanel">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label text-md-right">Nama Bilik/Lokasi</label>
                                                <div class="col-md-9">
                                                    <select id="room" name="room" class="form-control select-search" disabled data-placeholder="Pilih Nama Bilik/Lokasi">
                                                        <option></option>
                                                        @foreach ($rooms as $room)
                                                            <option value="{{ $room->id }}" data-auto="{{ $room->is_auto }}"
                                                                data-upload="{{ $room->is_upload }}"
                                                                data-pantry="{{ $room->is_pantry }}"
                                                                {{ (old('room', $application->room_id ?? '') == $room->id) ? 'selected' : '' }}>
                                                                {{ $room->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('room')
                                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="alert alert-danger border-0 alert-dismissible"
                                                id="div_alert_bilik_manual" style="display: none">
                                                <button type="button" class="close" data-dismiss="alert"></button><i
                                                    class="icon-exclamation mr-1"></i>
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

                                            <div class="alert alert-warning border-0 alert-dismissible" id="div_alert_wifimiti"         style="display: none">
                                                <button type="button" class="close" data-dismiss="alert"></button>
                                                <strong>Makluman : </strong> Sekiranya memerlukan Voucher <b>MITIWIFI_Guest</b>, sila emelkan permohonan kepada urki@miti.gov.my
                                            </div>

                                            <input type="hidden" id="is_auto" name="is_auto" value="{{ old('is_auto') }}">
                                                    <input type="hidden" id="is_upload" name="is_upload"
                                                        value="{{ old('is_upload') }}">
                                                    <input type="hidden" id="is_pantry" name="is_pantry"
                                                        value="{{ old('is_pantry') }}">

                                            <!-- Booking Dates -->
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 25%;">Tarikh/Masa Mula</th>
                                                        <th class="text-center" style="width: 25%;">Tarikh/Masa Tamat</th>
                                                        <th style="width: 20%;">Ketersediaan/Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="booking-rows">
                                                    @foreach ($applications as $index => $booking)
                                                        <tr class="booking-row align-middle">
                                                            <td>
                                                                <input type="text" name="bookings[{{ $index }}][start]"
                                                                    class="form-control start-input"
                                                                    value="{{ old('bookings.$index.start', \Carbon\Carbon::parse($booking->tarikh_mula)->format('d/m/Y H:i')) }}" disabled>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="bookings[{{ $index }}][end]"
                                                                    class="form-control end-input"
                                                                    value="{{ old('bookings.$index.end', \Carbon\Carbon::parse($booking->tarikh_hingga)->format('d/m/Y H:i')) }}" disabled>
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
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="col-md-12 col-form-label text-md-right">
                                                <a href="javascript:void(0)" id="addRow"
                                                title="Jika tempoh lebih 1 hari dan masa yang berbeza"
                                                class="d-inline-flex align-items-center gap-2">
                                                    <i class="fas fa-plus-circle fa-lg"></i>Tambah Tarikh
                                                </a>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nama_mesyuarat"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Tajuk Mesyuarat/Program') }}</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control @error('nama_mesyuarat') is-invalid @enderror" name="nama_mesyuarat" id="nama_mesyuarat"
                                                        value="{{ old('nama_mesyuarat', $application->nama_mesyuarat) }}" readonly>
                                                        @error('nama_mesyuarat')
                                                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                                        @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="kategori_pengerusi"
                                                    class="col-md-3 col-form-label text-md-right">{{ __('Kategori Pengerusi') }}</label>
                                                <div class="col-md-9">
                                                    <select name="kategori_pengerusi" id="kategori_pengerusi"
                                                        data-placeholder="Pilih Kategori Pengerusi"
                                                        class="form-control select-search @error('kategori_pengerusi') is-invalid @enderror">
                                                        <option></option>
                                                        <option value="YBM" @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'YBM') selected @endif>YBM
                                                        </option>
                                                        <option value="Timbalan YBM"
                                                            @if (old('kategori_pengerusi',$application->kategori_pengerusi) == 'Timbalan YBM') selected @endif>Timbalan YBM
                                                        </option>
                                                        <option value="KSU"
                                                            @if (old('kategori_pengerusi',$application->kategori_pengerusi) == 'KSU') selected @endif>
                                                            KSU</option>
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
                                                            @if (old('kategori_pengerusi', $application->kategori_pengerusi) == '0') selected @endif>
                                                            Lain-Lain</option>
                                                    </select>
                                                    @error('kategori_pengerusi')
                                                        <div class="invalid-feedback">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div id="div_pengerusi" style="display: none">
                                                <div class="form-group row">
                                                    <label for="nama_pengerusi"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Nama Pengerusi') }}</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control @error('nama_pengerusi') is-invalid @enderror" type="text" id="nama_pengerusi"
                                                            name="nama_pengerusi"
                                                            value="{{ old('nama_pengerusi') }}">
                                                            @error('nama_pengerusi')
                                                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                                            @enderror
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
                                                <div class="col-md-2">
                                                    <input id="bil_tempah" type="text" class="form-control @error('nama_mesyuarat') is-invalid @enderror"
                                                        name="bilangan_tempahan" value="{{ old('bilangan_tempahan', $application->bilangan_tempahan) }}"
                                                        autocomplete="bilangan_tempahan"
                                                        placeholder="Bil. Orang">
                                                        @error('bilangan_tempahan')
                                                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                                        @enderror

                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <a href="#" id="nextBtn" class="btn btn-primary">Seterusnya</a>
                                            </div>

                                        </div>

                                        <!-- Tab 2 -->
                                        <div class="tab-pane fade" id="maklumat_bilik" role="tabpanel">
                                            @include('applications.room.edit')
                                            <div class="text-center">
                                                <a href="#maklumat_permohonan" class="btn btn-secondary" id="prevBtn" data-toggle="tab">Kembali</a>
                                                <a href="#maklumat_vc" class="btn btn-primary" id="nextBtn2" data-toggle="tab">Seterusnya</a>
                                            </div>
                                        </div>

                                        <!-- Tab 3 -->
                                        <div class="tab-pane fade" id="maklumat_vc" role="tabpanel">
                                            @include('applications.vc.edit')
                                            <div class="card-footer">
                                                <fieldset>
                                                    <legend><b><i>Perakuan</i></b></legend>
                                                    <div>
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input @error('perakuan') is-invalid @enderror" name="perakuan"
                                                                    id="perakuan" value="1">
                                                                <label class="custom-control-label" for="perakuan">Pemohon
                                                                    bertanggungjawab di
                                                                    atas maklumat dan permohonan yang telah dibuat.</label>
                                                            </div>
                                                        </div>
                                                        @error('perakuan')
                                                            <div class="invalid-feedback d-block">
                                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>
                                                </fieldset>
                                                <div class="text-center">
                                                    <a class="btn btn-secondary" href="#maklumat_bilik" onclick="previousVc()"
                                                        id="preBtn2" role="button">Kembali</a>

                                                    <!-- <a href="#maklumat_bilik" class="btn btn-secondary" id="prevBtn" data-toggle="tab">Kembali</a> -->

                                                    <button type="submit" class="btn btn-primary btn-sm submit-btn">
                                                    Lulus Dengan Pindaan
                                                </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>

            </div>

        </div>

    </body>

    <!-- Modal Papar pemohon -->
    <div id="modal_default" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="font-weight-semibold">Maklumat Pemohon</h6>
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
    let suppressAvailabilityCheck = false;

    function getRoomId() {
        return document.getElementById('room')?.value || null;
    }

    function checkAllRows() {
        const roomId = $('#room').val();
        if (!roomId) {
            console.log('❌ Tiada roomId, skip checkAllRows');
            return;
        }

        document.querySelectorAll('.booking-row').forEach(row => {
            const start = row.querySelector('.start-input')?.value;
            const end   = row.querySelector('.end-input')?.value;

            if (start && end) {
                console.log('📌 checkAvailability untuk row:', row);
                // BUAT debounce khas untuk row ini
                debounceCheckAvailability(roomId, start, end, row);
            } else {
                console.log('⚠️ Skip row sebab start/end kosong:', row);
            }
        });
    }



    function markInvalidSequenceRows() {
        console.log("Validasi susunan tarikh sedang dijalankan...(markInvalidSequenceRows)");
        const rows = document.querySelectorAll('.booking-row');
        const bookings = [];
        let sequenceHasError = false;

        // Kumpulkan data booking
        rows.forEach((r) => {
            const s = r.querySelector('.start-input')?.value;
            const e = r.querySelector('.end-input')?.value;
            if (s && e) bookings.push({ start: s, end: e, row: r });
        });

        // Parse tarikh sahaja (buang masa)
        const parseDateOnly = (str) => {
            if (!str) return null;
            const [datePart] = str.split(' '); // Ambil bahagian tarikh sahaja
            const [d, m, y] = datePart.split('/');
            const date = new Date(+y, m - 1, +d);
            date.setHours(0, 0, 0, 0); // Reset masa
            return date;
        };

        // Reset status error sebelum validasi
        document.querySelectorAll('.availability-status').forEach(span => {
            if (span.getAttribute('data-status') === 'sequence-error') {
                span.innerHTML = '';
                span.removeAttribute('data-status');
            }
        });

        console.log("Semak susunan tarikh...");

        for (let i = 1; i < bookings.length; i++) {
            const prevEnd = parseDateOnly(bookings[i - 1].end);
            const currStart = parseDateOnly(bookings[i].start);
            const row = bookings[i].row;
            const statusSpan = row.querySelector('.availability-status');

            if (!prevEnd || !currStart) continue;

            // Pastikan tarikh sekarang > tarikh sebelum
            if (currStart <= prevEnd) {
                const message = `Tempoh ke-${i + 1} mestilah bermula selepas tarikh ${bookings[i - 1].end}`;

                statusSpan.innerHTML = `
                    <i class="fas fa-exclamation-triangle text-danger fa-lg show-sequence-error"
                    style="cursor:pointer;" title="${message}"></i>`;
                statusSpan.setAttribute('data-status', 'sequence-error');

                // Kosongkan input start dan end
                const startInput = row.querySelector('input[name^="bookings"][name$="[start]"]');
                const endInput = row.querySelector('input[name^="bookings"][name$="[end]"]');

                suppressAvailabilityCheck = true;

                setTimeout(() => {
                    [startInput, endInput].forEach(input => {
                        if (!input) return;

                        input.removeAttribute('readonly');

                        if (input._flatpickr) {
                            input._flatpickr.clear();
                            console.log(`Cleared via flatpickr: ${input.name}`);
                            input.dispatchEvent(new Event('change', { bubbles: true }));
                        }

                        input.value = ''; // fallback
                    });

                    // Kosongkan ikon & status availability
                    if (statusSpan) {
                        statusSpan.innerHTML = '';
                        statusSpan.removeAttribute('data-status');
                    }
                    suppressAvailabilityCheck = false;
                }, 300);

                startInput?.focus();

                Swal.fire({
                    title: 'Susunan Tarikh Tidak Sah',
                    text: message,
                    iconHtml: '<i class="fas fa-exclamation-circle" style="font-size: 40px; color: red;"></i>',
                    customClass: {
                        icon: 'no-default-icon'
                    },
                    confirmButtonText: 'OK'
                });

                sequenceHasError = true;
            }
        }

        // Kawal butang tambah tarikh
        const addRowBtn = document.getElementById('addRow');
        if (addRowBtn) {
            if (sequenceHasError) {
                addRowBtn.classList.add('disabled');
            } else {
                addRowBtn.classList.remove('disabled');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        // init semua yang sedia ada masa load
        document.querySelectorAll('.start-input, .end-input').forEach(input => {
            flatpickr(input, {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                time_24hr: true,
                defaultDate: input.value || null
            });
        });

        const kategoriPengerusi = "{{ $application->kategori_pengerusi }}";
        const divPengerusi = document.getElementById("div_pengerusi");

        if (kategoriPengerusi === "0") {
            divPengerusi.style.display = "block";
        } else {
            divPengerusi.style.display = "none";
        }

        // ===================== UTILITIES ===================== //

        function activateTab(tabId) {
            // clear semua dulu
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

            const tabLink = document.querySelector(`a[href="${tabId}"]`);
            const tabPane = document.querySelector(tabId);

            if (tabLink && tabPane) {
                tabLink.classList.add('active');
                tabPane.classList.add('show', 'active');
            }
        }

        // Format tarikh
        function formatTarikhDMY(tarikh) {
            const date = new Date(tarikh);
            if (isNaN(date)) return tarikh;
            return `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
        }

        // ===================== TAB LOGIC ===================== //
        const nextBtn = document.getElementById("nextBtn");
        const nextBtn2 = document.getElementById("nextBtn2");
        const prevBtn = document.getElementById("prevBtn");
        const prevBtn2 = document.getElementById("prevBtn2");

        if (nextBtn) nextBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const roomSelect = document.getElementById("room");
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const is_auto = selectedOption ? selectedOption.getAttribute('data-auto') : 'Y';

            // Kalau tab bilik disable, terus skip ke VC
            if (is_auto === 'N' || is_auto === 'S') {
                // lompat ke VC
                activateTab('#maklumat_vc');

                // pastikan content bilik tak aktif
                document.querySelector('#maklumat_bilik')?.classList.remove('show', 'active');
            } else {
                activateTab('#maklumat_bilik');
            }
        });

        if (nextBtn2) nextBtn2.addEventListener("click", function (e) {
            e.preventDefault();
            activateTab('#maklumat_vc');
        });

        if (prevBtn) prevBtn.addEventListener("click", function (e) {
            e.preventDefault();
            activateTab('#maklumat_permohonan');
        });

        if (prevBtn2) prevBtn2.addEventListener("click", function (e) {
            e.preventDefault();
            const room = document.getElementById("room")?.value || '';
            const is_auto = room.substr(room.length - 3, 1);
            activateTab((is_auto === 'N' || is_auto === 'S') ? '#maklumat_permohonan' : '#maklumat_bilik');
        });

        // ===================== BOOKING & FLATPICKR ===================== //
        const firstRow = document.querySelector('.booking-row');
        const bookingContainer = document.getElementById('booking-rows');
        let index = 1;

        function initFlatpickrForRow(row) {
            row.querySelectorAll('.start-input, .end-input').forEach(input => {
                flatpickr(input, {
                    enableTime: true,
                    dateFormat: "d/m/Y H:i",
                    time_24hr: true,
                    defaultDate: input.value || null
                });
            });
        }

        function bindChangeEventToRow(row) {
            row.querySelectorAll('.start-input, .end-input').forEach(input => {
                input.addEventListener('change', function (e) {

                    // Tambah semakan: kosongkan status jika input kosong
                    const start = row.querySelector('.start-input')?.value;
                    const end = row.querySelector('.end-input')?.value;

                    if (!start || !end) {
                        const statusSpan = row.querySelector('.availability-status');
                        if (statusSpan) {
                            statusSpan.innerHTML = '';
                            statusSpan.removeAttribute('data-status');
                            console.log('Availability icon cleared due to empty input');
                        }
                        return; // Elak checkAvailability & markInvalidSequenceRows bila input kosong
                    }

                    checkAvailabilityIfReady(row);
                    removeDateError(e);
                    markInvalidSequenceRows();
                });
            });
        }

        function checkAvailabilityIfReady(row) {
            console.log('checkAvailabilityIfReady dipanggil');
            if (suppressAvailabilityCheck) {
                console.log('🔕 Availability check suppressed');
                return;
            }
            const start = row.querySelector('.start-input')?.value;
            const end = row.querySelector('.end-input')?.value;
            const roomId = document.getElementById('room')?.value;

             if (!start || !end || !roomId) {
                console.log('Tidak cukup data, checkAvailability tidak dipanggil');
                const statusSpan = row.querySelector('.availability-status');
                if (statusSpan) {
                    statusSpan.innerHTML = '';
                    statusSpan.removeAttribute('data-status');
                }
                return;
            }

            debounceCheckAvailability(roomId, start, end, row);
        }

        // ✅ Fungsi untuk semak semua rows
        function checkAllRows() {
            const rows = document.querySelectorAll('.booking-row');
            rows.forEach(row => checkAvailabilityIfReady(row));
        }

        function validateSequentialDateRanges(bookings) {
            console.log('validateSequentialDateRanges');
            const parseDate = (dateStr) => {
                const [day, month, year] = dateStr.split('/');
                return new Date(+year, month - 1, +day); // month is 0-based
            };

            for (let i = 1; i < bookings.length; i++) {
                const prevEnd = parseDate(bookings[i - 1].end);
                const currentStart = parseDate(bookings[i].start);

                // Tambah 1 hari kepada prevEnd
                const expectedStart = new Date(prevEnd);
                expectedStart.setDate(expectedStart.getDate() + 1);

                if (currentStart < expectedStart) {
                    return {
                        valid: false,
                        index: i,
                        message: `Tempoh ke-${i + 1} mestilah bermula selepas ${bookings[i - 1].end}`
                    };
                }
            }

            return { valid: true };
        }

        const CHECK_AVAILABILITY_URL = "{{ route('check.availability') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";

        //fungsi untuk elak banyak kali panggil fungsi checkAvailability
        let debounceTimeout;

        // Debounce helper tanpa lodash
    function debounce(fn, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

const debounceMap = new WeakMap();

    function debounceCheckAvailability(roomId, start, end, row) {
        if (!debounceMap.has(row)) {
            debounceMap.set(row, debounce((roomId, start, end, row) => {
                checkAvailability(roomId, start, end, row);
            }, 500));
        }
        debounceMap.get(row)(roomId, start, end, row);
    }


        function checkAvailability(roomId, start, end, row) {
            console.log('semak checkAvailability', row);

            const statusSpan = row.querySelector('.availability-status');
            if (!statusSpan) return;

            if (!start || !end || !roomId) {
                statusSpan.innerHTML = '';
                statusSpan.removeAttribute('data-status');
                return;
            }

            statusSpan.innerHTML = '<i class="fas fa-spinner fa-spin text-muted fa-lg" title="Menyemak..."></i>';

            fetch(CHECK_AVAILABILITY_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": CSRF_TOKEN
                },
                body: JSON.stringify({ room_id: roomId, start, end })
            })
            .then(response => response.json())
            .then(data => {
                // ⚡ penting → masih guna row yang dihantar
                const thisStatusSpan = row.querySelector('.availability-status');
                if (!thisStatusSpan) return;

                if (data.available) {
                    thisStatusSpan.innerHTML =
                        '<i class="fas fa-check-circle text-success fa-lg" title="Semua tarikh tersedia"></i>';
                } else if (data.unavailable_dates?.length) {
                    const formattedList = data.unavailable_dates.map(formatTarikhDMY).join('<br>');
                    thisStatusSpan.innerHTML =
                        `<i class="fas fa-exclamation-circle text-danger fa-lg show-unavailable" style="cursor:pointer;"></i>`;
                    thisStatusSpan.querySelector('.show-unavailable').addEventListener('click', () => {
                        Swal.fire({
                            title: 'Tarikh Tidak Tersedia',
                            html: formattedList,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    });
                } else {
                    thisStatusSpan.innerHTML =
                        '<i class="fas fa-times-circle text-danger fa-lg" title="Bilik tidak tersedia"></i>';
                }
            });
        }

        initFlatpickrForRow(firstRow);
        bindChangeEventToRow(firstRow);

        document.getElementById('addRow').addEventListener('click', function () {
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                input.value = '';

                const name = input.getAttribute('name');
                if (name) input.setAttribute('name', name.replace(/\[\d+]/, `[${index}]`));

                input.removeAttribute('id');

                if (input._flatpickr) {
                    input._flatpickr.destroy(); // hapus Flatpickr instance dari hasil clone
                }

                input.removeAttribute('readonly'); // optional: elak gangguan clear manual
            });

            newRow.querySelector('.availability-status').textContent = '';
            newRow.querySelector('.remove-row').style.display = 'inline-block';

            bookingContainer.appendChild(newRow);

            initFlatpickrForRow(newRow);      // ✅ re-init Flatpickr pada baris baru
            bindChangeEventToRow(newRow);     // ✅ untuk fungsi checkAvailability dll.
            index++;
        });

        bookingContainer.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-row');
            if (btn && bookingContainer.querySelectorAll('.booking-row').length > 1) {
                btn.closest('.booking-row').remove();
            }
        });

        // ===================== SELECT2 & ROOM CHANGE ===================== //

       $('#room').on('select2:select change', function () {
    console.log('🏠 Room change → semak semua rows');

    const selected = $(this).find('option:selected');

    const isAuto   = selected.data('auto');   // Y / N
    const isUpload = selected.data('upload'); // Y / N
    const isPantry = selected.data('pantry'); // Y / N

    // simpan dalam hidden input
    $('#is_auto').val(isAuto);
    $('#is_upload').val(isUpload);
    $('#is_pantry').val(isPantry);

    // 1. Handle tab bilik
    if (isAuto === 'N') {
        $('#tab-bilik').addClass('disabled');
        $('#div_alert_bilik_manual').show();
        if ($('#tab-bilik').hasClass('active')) {
            $('#tab-vc').tab('show');
        }
    } else {
        $('#tab-bilik').removeClass('disabled');
        $('#div_alert_bilik_manual').hide();
    }

    // 2. Handle upload
    $('#div_upload').toggle(isUpload === 'Y');

    // 3. Pantry → kalau ada logic lain boleh tambah sini

    // 4. Check semua rows sekali sahaja
    checkAllRows();
}).trigger('change');


        // ===================== SUBMIT FORM ===================== //
        document.getElementById('applicationForm')?.addEventListener('submit', function (e) {
            removeDateError(e);
            markInvalidSequenceRows(); // 🚨 jalankan semula untuk pastikan validation terkini

            const sequenceError = document.querySelector('.availability-status[data-status="sequence-error"]');

            if (sequenceError) {
                e.preventDefault(); // ❌ halang submit jika masih salah

                // Ambil mesej dari ikon
                const msg = sequenceError.querySelector('i')?.getAttribute('title') || 'Susunan tarikh tidak sah';

                // ✅ Popup masa submit
                Swal.fire({
                title: 'Susunan Tarikh Tidak Sah',
                text: msg,
                icon: 'warning', // boleh buang kalau guna iconHtml
                iconHtml: '<i class="fas fa-exclamation-triangle fa-4x text-warning"></i>',
                customClass: {
                    icon: 'no-default-icon'
                },
                confirmButtonText: 'OK'
                });

                return;
            }

            document.getElementById('submitButton').disabled = true;
        });


        // Loop semua row yang dah wujud masa edit
        document.querySelectorAll('.booking-row').forEach(row => {
            initFlatpickrForRow(row);
            bindChangeEventToRow(row);

            // terus check availability kalau dah ada value
            checkAvailabilityIfReady(row);
        });

        // ✅ Trigger room change untuk populate hidden inputs
    $('#room').trigger('change');

    // ✅ Init dan bind semua row sedia ada
    document.querySelectorAll('.booking-row').forEach(row => {
        initFlatpickrForRow(row);
        bindChangeEventToRow(row);
    });

    // ✅ Lepas select2 siap, terus semak availability semua row
    setTimeout(() => {
        const roomId = document.getElementById('room')?.value;
        document.querySelectorAll('.booking-row').forEach(row => {
            const start = row.querySelector('.start-input')?.value;
            const end   = row.querySelector('.end-input')?.value;
            if (start && end && roomId) {
                checkAvailability(roomId, start, end, row);
            }
        });

        // ✅ Jangan lupa validasi susunan juga masa load
        markInvalidSequenceRows();
    }, 200); // beri masa sikit untuk select2 trigger populate

    const rows = document.querySelectorAll('.booking-row');
    rows.forEach((row, index) => {
        const removeBtn = row.querySelector('.remove-row');
        if (removeBtn) {
            if (index === 0) {
                removeBtn.style.display = 'none'; // row pertama disembunyi
            } else {
                removeBtn.style.display = 'inline-block'; // row lain tunjuk
            }
        }
    });

    });
</script>

@endsection
