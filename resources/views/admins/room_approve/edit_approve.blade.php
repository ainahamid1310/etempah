@extends('layouts.backend_applicant')

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
        .error-border {
        border: 2px solid red !important;
        background-color: #ffe6e6; /* light red */
        }

    </style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                {{-- @foreach ($errors->all() as $error) --}}
                    <li>Sila lengkapkan borang permohonan.</li>
                {{-- @endforeach --}}
            </ul>
        </div>
    @endif

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
                               <form action="/admin/application_room/result/{{ $application->batch_id }}" method="post">
                                {{ csrf_field() }}
                                    @csrf
                                    <div class="tab-content">
                                        <div class="card-header bg-white d-flex justify-content-between">
                                            <strong>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
                                                    class="icon-info22 mr-3"></i></strong>
                                        </div>

                                        <!-- Tab 1 -->
                                        <div class="tab-pane fade show active" id="maklumat_permohonan" role="tabpanel">
                                            <div class="form-group row">

                                                <label class="col-md-3 col-form-label text-md-right"><b>Nama Bilik/Lokasi</b></label>
                                                <div class="col-md-9">
                                                    <select id="room" name="room" class="form-control select-search @error('room') is-invalid @enderror" data-placeholder="Pilih Nama Bilik/Lokasi">
                                                        <option></option>
                                                        @foreach ($rooms as $room)
                                                            <option value="{{ $room->id }}"
                                                                data-auto="{{ $room->is_auto }}"
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

                                            <div class="alert alert-warning border-0 alert-dismissible" id="div_alert_wifimiti" style="display: none">
                                                <button type="button" class="close" data-dismiss="alert"></button>
                                                <strong>Makluman : </strong> Sekiranya memerlukan Voucher <b>MITIWIFI_Guest</b>, sila emelkan permohonan kepada urki@miti.gov.my
                                            </div>

                                            <input type="hidden" id="is_auto" name="is_auto" value="{{ old('is_auto') }}">
                                                    <input type="hidden" id="is_upload" name="is_upload"
                                                        value="{{ old('is_upload') }}">
                                                    <input type="hidden" id="is_pantry" name="is_pantry"
                                                        value="{{ old('is_pantry') }}">
                                            <br>
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 5%;">ID Batch</th>
                                                        <th class="text-center" style="width: 5%;">ID</th>
                                                        <th class="text-center" style="width: 25%;">Tarikh/Masa Mula</th>
                                                        <th class="text-center" style="width: 25%;">Tarikh/Masa Tamat</th>
                                                        <th style="width: 20%;">Ketersediaan</th>
                                                        <th style="width: 15%;">Tindakan/Status</th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    // guna old() untuk kekalkan semasa validation fail
                                                $oldBookings = old('bookings', $bookings ?? []);
                                                @endphp

                                                <tbody id="booking-rows">
                                                    @forelse($oldBookings as $i => $booking)
                                                        <tr class="booking-row align-middle">
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text batch_id_input">
                                                                        #{{ $booking['batch_id'] }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text id_input">
                                                                         {{ $booking['id'] }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        name="bookings[{{ $i }}][start]"
                                                                        class="form-control start-input"
                                                                        value="{{ $booking['start'] ?? '' }}"
                                                                        placeholder="Pilih tarikh mula">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        name="bookings[{{ $i }}][end]"
                                                                        class="form-control end-input"
                                                                        value="{{ $booking['end'] ?? '' }}"
                                                                        placeholder="Pilih tarikh tamat">
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td style="display: flex; align-items: center; gap: 6px; font-size: 1.25rem;">
                                                                <span class="availability-status small"></span>
                                                                <td style="display: flex; align-items: center; gap: 6px; font-size: 1.25rem;">
                                                                <span class="availability-status small"></span>

                                                                {{-- Sembunyikan untuk data sedia ada --}}
                                                                {{-- <a href="javascript:void(0)"
                                                                class="text-danger remove-row"
                                                                title="Padam baris"
                                                                style="{{ empty($booking['id']) ? '' : 'display:none;' }}">
                                                                    <i class="fas fa-trash-alt fa-sm"></i>
                                                                </a> --}}
                                                            </td>

                                                            </td>

                                                            <td>
                                                                 <a href="javascript:void(0)"
                                                                class="text-danger remove-row"
                                                                title="Padam baris"
                                                                style="{{ empty($booking['id']) ? '' : 'display:none;' }}">
                                                                    <i class="fas fa-trash-alt fa-lg"></i>
                                                                </a>
                                                                @if ($booking['status_room_id'] == 1)
                                                                    <button type="button"
                                                                        class="btn btn-warning btn-sm btn-batal-admin text-center"
                                                                        data-room-id="{{ $booking['id'] }}"
                                                                        style="padding: 1px 6px; font-size: 0.75rem; line-height: 1.2;">
                                                                        Batal
                                                                    </button>
                                                                @else
                                                                    @php
                                                                        // Ambil nama status dan tentukan warna badge
                                                                        $statusName = $booking['status_room_name'] ?? $booking['status_room_id'] ?? 'Tidak Dikenal Pasti';

                                                                        // Tetapkan warna badge ikut status_room_id
                                                                        $badgeClass = match($booking['status_room_id']) {
                                                                            1 => 'badge badge-primary',
                                                                            2,14 => 'badge badge-success',
                                                                            3 => 'badge badge-primary',
                                                                            4,5 => 'badge badge-danger',
                                                                            6 => 'badge badge-success',
                                                                            7 => 'badge badge-success',
                                                                            12,13 => 'badge badge-warning',

                                                                            default => 'badge badge-light',
                                                                        };
                                                                    @endphp

                                                                    <span class="{{ $badgeClass }} btn-batal-admin">{{ $statusName }}</span>
                                                                @endif
                                                                <td style="display: flex; align-items: center; gap: 6px; font-size: 1.25rem;">
                                                                    <span class="availability-status small"></span>

                                                                    <a href="javascript:void(0)"
                                                                    class="text-danger remove-row"
                                                                    title="Padam baris"
                                                                    style="display: none;">
                                                                        <i class="fas fa-trash-alt fa-lg"></i>
                                                                    </a>
                                                                </td>

                                                            </td>
                                                        </tr>
                                                    @empty
                                                        {{-- fallback kalau tiada data --}}
                                                        <tr class="booking-row align-middle">
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        name="bookings[0][start]"
                                                                        class="form-control start-input"
                                                                        value=""
                                                                        placeholder="Pilih tarikh mula">
                                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        name="bookings[0][end]"
                                                                        class="form-control end-input"
                                                                        value=""
                                                                        placeholder="Pilih tarikh tamat">
                                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                                </div>
                                                            </td>
                                                            <td style="display: flex; align-items: center; gap: 6px; font-size: 1.25rem;">
                                                                <span class="availability-status small"></span>

                                                                {{-- Sembunyikan untuk data sedia ada --}}
                                                                {{-- <a href="javascript:void(0)"
                                                                class="text-danger remove-row"
                                                                title="Padam baris"
                                                                style="{{ empty($booking['id']) ? '' : 'display:none;' }}">
                                                                    <i class="fas fa-trash-alt fa-sm"></i>
                                                                </a> --}}
                                                            </td>

                                                            <td>
                                                                <a href="javascript:void(0)"
                                                                class="text-danger remove-row"
                                                                title="Padam baris"
                                                                style="{{ empty($booking['id']) ? '' : 'display:none;' }}">
                                                                    <i class="fas fa-trash-alt fa-lg"></i>
                                                                </a>
                                                                @if ($booking['status_room_id'] == 1)

                                                                <button type="button"
                                                                    class="btn btn-warning btn-sm btn-batal-admin text-center"
                                                                    data-room-id="{{ $booking['id'] }}"
                                                                    style="padding: 1px 6px; font-size: 0.75rem; line-height: 1.2;">
                                                                    Batal
                                                                </button>
                                                                @else
                                                                    @php
                                                                        // Ambil nama status dan tentukan warna badge
                                                                        $statusName = $booking['status_room_name'] ?? $booking['status_room_id'] ?? 'Tidak Dikenal Pasti';

                                                                        // Tetapkan warna badge ikut status_room_id
                                                                        $badgeClass = match($booking['status_room_id']) {
                                                                            1 => 'badge badge-primary',
                                                                            2,14 => 'badge badge-success',
                                                                            3 => 'badge badge-primary',
                                                                            4,5 => 'badge badge-danger',
                                                                            6 => 'badge badge-success',
                                                                            7 => 'badge badge-success',
                                                                            12,13 => 'badge badge-warning',

                                                                            default => 'badge badge-light',
                                                                        };
                                                                    @endphp

                                                                    <span class="{{ $badgeClass }}">{{ $statusName }}</span>
                                                                @endif

                                                                <td style="display: flex; align-items: center; gap: 6px; font-size: 1.25rem;">
                                                                    <span class="availability-status small"></span>

                                                                    <a href="javascript:void(0)"
                                                                    class="text-danger remove-row"
                                                                    title="Padam baris"
                                                                    style="display: none;">
                                                                        <i class="fas fa-trash-alt fa-lg"></i>
                                                                    </a>
                                                                </td>

                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>

                                            </table>

                                            <div class="col-md-12 col-form-label text-md-center">
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
                                                        class="form-control select-search @error('kategori_pengerusi') is-invalid @enderror" onchange="kategoriPengerusi()" disabled>
                                                        <option></option>
                                                        <option value="YBM"
                                                            @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'YBM') selected @endif>
                                                            YBM</option>
                                                        <option value="Timbalan YBM"
                                                            @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'Timbalan YBM') selected @endif>Timbalan YBM
                                                        </option>
                                                        <option value="KSU"
                                                            @if (old('kategori_pengerusi', $application->kategori_pengerusi) == 'KSU') selected @endif>
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
                                                            value="{{ old('nama_pengerusi', $application->nama_pengerusi) }}">
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
                                                    <input id="bil_tempah" type="text" class="form-control @error('bilangan_tempahan') is-invalid @enderror"
                                                        name="bilangan_tempahan" value="{{ old('bilangan_tempahan', $application->bilangan_tempahan) }}"
                                                        autocomplete="bilangan_tempahan"
                                                        placeholder="Bil. Orang">
                                                        @error('bilangan_tempahan')
                                                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                                        @enderror

                                                </div>
                                            </div>

                                            {{-- <div class="text-end">
                                                <a href="#" id="nextBtn" class="btn btn-primary">Seterusnya</a>
                                            </div> --}}

                                            <div class="d-flex justify-content-end">
                                                <a href="#" id="nextBtn" class="btn btn-primary">Seterusnya >></a>
                                            </div>

                                            <br>

                                        </div>

                                        <!-- Tab 2 -->
                                        <div class="tab-pane fade" id="maklumat_bilik" role="tabpanel">
                                            @if (isset($application->applicationRoom))
                                                @include('applications.room.view')
                                            <div class="d-flex py-2 border-bottom align-items-center">
                                                <strong class="me-3" style="min-width: 150px;">Kategori Mesyuarat</strong>
                                                <span class="text-muted">
                                                    {{ $application->applicationRoom->kategori_mesyuarat == '1'
                                                        ? 'Mesyuarat Pengurusan Tertinggi'
                                                        : 'Mesyuarat Lain-lain' }}
                                                </span>
                                            </div>

                                            @php
                                                $penganjur = $application->applicationRoom->penganjur;
                                                $penganjurLabel = match($penganjur) {
                                                    'SENDIRI' => 'Sendiri',
                                                    'BERSAMA' => 'Bersama/Kolaborasi',
                                                    'LUAR' => 'Luar',
                                                    default => '-',
                                                };
                                                $namaPenganjur = $application->applicationRoom->nama_penganjur;
                                            @endphp

                                            <div class="d-flex py-2 border-bottom align-items-center">
                                                <strong class="me-3" style="min-width: 150px;">Penganjur</strong>
                                                <span class="text-muted">{{ $penganjurLabel }}</span>
                                            </div>

                                            @if(in_array($penganjur, ['BERSAMA', 'LUAR']))
                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <strong class="me-3" style="min-width: 150px;">Nama Penganjur</strong>
                                                    <span class="text-muted">{{ $namaPenganjur ?: '-' }}</span>
                                                </div>
                                            @endif

                                            <div id="div_upload" style="display: none">
                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <div class="fw-semibold text-dark" style="min-width: 180px;">
                                                        Surat/E-mel Program (.pdf)
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        @if (!empty($application->applicationRoom->surat))
                                                            <a href="{{ asset($application->applicationRoom->surat) }}" target="_blank" class="text-primary text-decoration-none">
                                                                <i class="fas fa-paperclip me-2"></i>
                                                                Muat Turun Fail
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex py-2 border-bottom align-items-center">
                                                <strong class="me-3" style="min-width: 150px;">Sajian</strong>
                                                <div class="flex-grow-1 text-muted">
                                                    {{ $application->applicationRoom->sajian ?: '-' }}
                                                </div>
                                            </div>

                                            @if ($application->applicationRoom->sajian !== 'Tidak Perlu')
                                                <div class="d-flex py-2 border-bottom align-items-start">
                                                    <div class="fw-semibold text-dark" style="min-width: 150px;">
                                                        Pilihan Sajian
                                                    </div>
                                                    <div class="flex-grow-1 text-muted">
                                                        @php
                                                            $sajianList = [];

                                                            if ($application->applicationRoom->minum_pagi == '1') {
                                                                $sajianList[] = 'Minum Pagi';
                                                            }
                                                            if ($application->applicationRoom->makan_tengahari == '1') {
                                                                $sajianList[] = 'Makan Tengahari';
                                                            }
                                                            if ($application->applicationRoom->minum_petang == '1') {
                                                                $sajianList[] = 'Minum Petang';
                                                            }
                                                        @endphp

                                                        @if (count($sajianList))
                                                            <ul class="mb-0 ps-3">
                                                                @foreach ($sajianList as $item)
                                                                    <li>{{ $item }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="d-flex py-2 border-bottom align-items-start">
                                                <strong class="me-3" style="min-width: 150px;">Catatan</strong>
                                                <div class="flex-grow-1 text-muted white-space-prewrap">
                                                    {{ $application->applicationRoom->catatan ?: '-' }}
                                                </div>
                                            </div>

                                            <!-- Nota : Komen disini sebab komen mengikut setiap permohonan -->
                                            @if(!empty($application->applicationVc))
                                                @if($application->applicationVc->status_vc_id == '4' && is_null($application->applicationVc->komen_ditolak))
                                                    <div class="form-group row">
                                                        <label for="catatan_vc_penyelia"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Catatan Ditolak/Batal') }}</label>
                                                        <div class="col-md-9">
                                                            <textarea rows="2" cols="2" class="form-control" name="catatan_vc_penyelia" readonly>{{ $application->applicationRoom->komen_ditolak }}</textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            @else
                                                <div class="text-center text-danger">-Tiada Permohonan-</div>
                                            @endif


                                            {{-- <div class="text-center">
                                                <a href="#maklumat_permohonan" class="btn btn-secondary" id="prevBtn" data-toggle="tab">Kembali</a>
                                                <a href="#maklumat_vc" class="btn btn-primary" id="nextBtn2" data-toggle="tab">Seterusnya</a>
                                            </div> --}}
                                            <br>
                                            <div class="d-flex justify-content-between">
                                                <a href="#maklumat_permohonan" id="prevBtn" class="btn btn-secondary"><< Kembali</a>
                                                <a href="#maklumat_vc" id="nextBtn2" class="btn btn-primary">Seterusnya >></a>
                                            </div>
                                            <br>
                                        </div>

                                        <!-- Tab 3 -->
                                        <div class="tab-pane fade" id="maklumat_vc" role="tabpanel">
                                            @include('applications.vc.view')
                                            <div class="card-footer">
                                                {{-- <fieldset>
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
                                                </fieldset> --}}

                                                <div class="d-flex justify-content-start">
                                                    <a href="#maklumat_bilik" id="preBtn2" class="btn btn-secondary"><< Kembali</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                    {{-- <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                        Kembali</button> --}}
                    @if ($application->applicationRoom->status_room_id == '1')
                        {{-- <form class="delete" method="POST"> --}}
                            {{-- {{ csrf_field() }} --}}
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="button" value="14">
                            <button type="submit" class="btn btn-success btn-sm submit-btn"
                                @disabled($applicationCount > 0)>
                                Lulus dengan Pindaan
                            </button>
                        {{-- </form> --}}

                        <!-- <button type="button" name="button" value="4" data-toggle="modal"
                            data-target="#modal_tolak" class="btn btn-danger btn-sm"
                            onclick="copy_catatan_room_penyelia_tolak()">Tolak</button>
                        <button type="button" name="button" value="13" data-toggle="modal"
                            data-target="#modal_batal" class="btn btn-danger btn-sm"
                            onclick="copy_catatan_room_penyelia_batal()">Batal</button> -->
                        {{-- @elseif($application->applicationRoom->status_room_id == '2' ||
                            $application->applicationRoom->status_room_id == '14')
                            <button type="button" name="button" value="12" data-toggle="modal"
                                data-target="#modal_batal" class="btn btn-warning btn-sm">Batal L</button> --}}
                        {{-- @elseif($application->applicationRoom->status_room_id == '3') --}}
                        <!-- <a href="/admin/application_room/result/{{ $application->id }}"><button type="submit"
                                name="button5" value="5" class="btn btn-primary btn-sm">Lulus
                                Pembatalan</button></a>
                        <form class="delete" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="button" value="6">
                            <button type="submit" class="btn btn-danger btn-sm submit-btn">
                                Tolak Pembatalan
                            </button>
                        </form> -->
                        {{-- <form action="/admin/application_room/result/{{ $application->id }}" method="POST">
                            @csrf

                            <button type="submit" name="button" value="5" class="btn btn-primary btn-sm">
                                Lulus Pembatalan
                            </button>

                            <button type="submit" name="button" value="6" class="btn btn-danger btn-sm">
                                Tolak Pembatalan
                            </button>
                        </form> --}}
                    @endif

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

                <div class="modal-body">
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
    let suppressAvailabilityCheck = false;

    function kategoriPengerusi() {

        var kategori_pengerusi = document.getElementById("kategori_pengerusi").value;
        var pengerusi = document.getElementById("div_pengerusi");

        if (kategori_pengerusi == "0") {
            pengerusi.style.display = "block";
        } else {
            pengerusi.style.display = "none";
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

    function showHideForm() {
        var vc_selected = document.getElementById("vc_selected");
        var form_room_urusetia = document.getElementById("form_room_urusetia");
        var form_vc = document.getElementById("form_vc");

        if (vc_selected.checked == true) {
            form_vc.style.display = "block";
        } else {
            form_vc.style.display = "none";
        }

    }

    function markInvalidSequenceRows() {
        console.log("1. Validasi susunan tarikh sedang dijalankan...");
        const rows = document.querySelectorAll('.booking-row');
        const bookings = [];
        let sequenceHasError = false;

        // Parser tarikh
        const parseDateOnly = (str) => {
            if (!str) return null;
            const [datePart] = str.split(' ');
            const [d, m, y] = datePart.split('/');
            const date = new Date(+y, m - 1, +d);
            date.setHours(0, 0, 0, 0);
            return date;
        };

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Reset semua error
        document.querySelectorAll('.availability-status').forEach(span => {
            if (span.getAttribute('data-status') === 'sequence-error') {
                span.innerHTML = '';
                span.removeAttribute('data-status');
            }
        });
        document.querySelectorAll('.start-input, .end-input').forEach(inp => {
            inp.classList.remove('error-border');
        });

        // Kumpul data
        rows.forEach((r, idx) => {
            const startInput = r.querySelector('.start-input');
            const endInput = r.querySelector('.end-input');
            const s = startInput?.value;
            const e = endInput?.value;
            if (s && e) {
                const startDate = parseDateOnly(s);
                const endDate = parseDateOnly(e);
                const statusSpan = r.querySelector('.availability-status');

                // ❌ Tarikh lepas
                if ((startDate && startDate < today) || (endDate && endDate < today)) {
                    const message = `Tarikh mestilah hari ini/selepas hari ini`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'sequence-error');
                    sequenceHasError = true;
                    // if (startDate < today) startInput?.classList.add('error-border');
                    // if (endDate < today) endInput?.classList.add('error-border');
                }

                // ❌ Start > End
                if (startDate && endDate && startDate > endDate) {
                    const message = `Tarikh tamat mesti selepas tarikh mula.`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'sequence-error');
                    sequenceHasError = true;
                    // startInput?.classList.add('error-border');
                    // endInput?.classList.add('error-border');
                }

                bookings.push({ start: s, end: e, row: r });
            }
        });

        console.log("2. Semak susunan tarikh...");

        // ❌ Susunan mesti sequential
        for (let i = 1; i < bookings.length; i++) {
            const prevEnd = parseDateOnly(bookings[i - 1].end);
            const currStart = parseDateOnly(bookings[i].start);
            const row = bookings[i].row;
            const statusSpan = row.querySelector('.availability-status');

            if (!prevEnd || !currStart) continue;

            if (currStart <= prevEnd) {
                const message = `Tempoh baris ke-${i + 1} mesti mula selepas ${bookings[i - 1].end}`;
                statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                statusSpan.setAttribute('data-status', 'sequence-error');
                sequenceHasError = true;

                const startInput = row.querySelector('.start-input');
                startInput?.classList.add('error-border');
            }
        }

        // Kawal butang tambah tarikh
        // const addRowBtn = document.getElementById('addRow');
        // if (addRowBtn) {
        //     if (sequenceHasError) {
        //         addRowBtn.classList.add('disabled');
        //     } else {
        //         addRowBtn.classList.remove('disabled');
        //     }
        // }
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
            alert('sini');
            e.preventDefault();
            const is_auto = document.getElementById("room");
            // const is_auto = room.substr(room.length - 3, 1);
            // activateTab((is_auto === 'N' || is_auto === 'S') ? '#maklumat_permohonan' : '#maklumat_bilik');
            activateTab('#maklumat_permohonan');
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

        document.addEventListener('DOMContentLoaded', function () {
            const roomSelect = document.getElementById('room');
            if (roomSelect) {
                roomSelect.addEventListener('change', function () {
                    const rows = document.querySelectorAll('.booking-row');
                    rows.forEach(row => {
                        const start = row.querySelector('.start-input')?.value;
                        const end = row.querySelector('.end-input')?.value;

                        if (start && end) {
                            checkAvailabilityIfReady(row);
                        } else {
                            const statusSpan = row.querySelector('.availability-status');
                            if (statusSpan) {
                                statusSpan.innerHTML = '';
                                statusSpan.removeAttribute('data-status');
                                console.log('Availability cleared sebab bilik ditukar tapi input kosong');
                            }
                        }
                    });
                    markInvalidSequenceRows();
                });
            }
        });

        function bindChangeEventToRow(row) {
            console.log("4. bindChangeEventToRow...");
            row.querySelectorAll('.start-input, .end-input').forEach(input => {
                ['change', 'input'].forEach(evt => {
                    input.addEventListener(evt, function (e) {
                        const start = row.querySelector('.start-input')?.value;
                        const end = row.querySelector('.end-input')?.value;
                        const statusSpan = row.querySelector('.availability-status');

                        if (!start || !end) {
                            if (statusSpan) {
                                statusSpan.innerHTML = '';
                                statusSpan.removeAttribute('data-status');
                                console.log('⏹ Cleared availability (empty input)');
                            }
                            return;
                        }

                        checkAvailabilityIfReady(row);
                        removeDateError(e);
                        markInvalidSequenceRows();
                    });
                });
            });
        }

        function checkAvailabilityIfReady(row) {

            console.log("5. checkAvailabilityIfReady...");
            if (suppressAvailabilityCheck) return;

            const startInput = row.querySelector('.start-input');
            const endInput = row.querySelector('.end-input');
            const start = startInput?.value;
            const end = endInput?.value;
            const roomId = document.getElementById('room')?.value;
            const statusSpan = row.querySelector('.availability-status');

            // 🔹 Reset status/error lama dulu
            if (statusSpan) {
                statusSpan.innerHTML = '';
                statusSpan.removeAttribute('data-status');
            }
            startInput?.classList.remove('error-border');
            endInput?.classList.remove('error-border');

            // Kalau input kosong → keluar awal
            if (!start || !end) return;

            // Parse tarikh + masa (format: dd/mm/yyyy HH:MM)
            const parseDateTime = (str) => {
                if (!str) return null;
                const [datePart, timePart] = str.split(' ');
                const [d, m, y] = datePart.split('/');
                const date = new Date(+y, m - 1, +d);

                if (timePart) {
                    const [hh, mm] = timePart.split(':');
                    date.setHours(+hh, +mm, 0, 0);
                } else {
                    date.setHours(0, 0, 0, 0);
                }
                return date;
            };

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const startDate = parseDateTime(start);
            const endDate = parseDateTime(end);

            // ✅ Semakan 1: Tarikh mesti ≥ hari ini
            if ((startDate && startDate < today) || (endDate && endDate < today)) {
                const message = "Tarikh mula / tamat tidak boleh sebelum hari ini.";
                if (startDate < today) startInput?.classList.add('error-border');
                if (endDate < today) endInput?.classList.add('error-border');

                statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                statusSpan.setAttribute('data-status', 'date-error');

                return;
            }

            // ✅ Semakan 2: Start ≤ End
            if (startDate && endDate && startDate >= endDate) {
                const message = "Tarikh tamat mesti selepas atau sama dengan tarikh mula.";
                startInput?.classList.add('error-border');
                endInput?.classList.add('error-border');

                statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                statusSpan.setAttribute('data-status', 'date-error');

                return;
            }

            // ✅ Semakan 3: masa tamat mesti > masa mula

            if (startDate && endDate) {
                const startTime = startDate.getHours() * 60 + startDate.getMinutes();
                const endTime = endDate.getHours() * 60 + endDate.getMinutes();

                if (startTime >= endTime) {
                    const message = "Masa tamat mesti selepas masa mula.";
                    startInput?.classList.add('error-border');
                    endInput?.classList.add('error-border');

                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i>
                        <span style="font-size: 9px; color: red; margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'time-error');
                    return;

                    const icon = statusSpan.querySelector('.error-icon');
                    if (icon) {
                        icon.addEventListener('click', () => {
                            alert("Sila pastikan masa tamat lebih lewat daripada masa mula (tidak melebihi 24 jam).");
                        });
                    }
                }
            }

            // ✅ Semakan 4: Urutan sequential (guna semua rows)
            const rows = document.querySelectorAll('.booking-row');
            const bookings = Array.from(rows).map(r => {
                return {
                    start: r.querySelector('.start-input')?.value,
                    end: r.querySelector('.end-input')?.value
                };
            });

            const parseDate = (dateStr) => {
                if (!dateStr) return null;
                const [day, month, year] = dateStr.split('/');
                return new Date(+year, month - 1, +day); // month 0-based
            };

            for (let i = 1; i < bookings.length; i++) {
                const prevEnd = parseDate(bookings[i - 1].end);
                const currentStart = parseDate(bookings[i].start);

                if (!prevEnd || !currentStart) continue;

                const expectedStart = new Date(prevEnd);
                expectedStart.setDate(expectedStart.getDate() + 1);

                if (currentStart < expectedStart) {
                    const message = `Tempoh baris ke-${i + 1} mestilah bermula selepas ${bookings[i - 1].end}`;
                    statusSpan.innerHTML = `<i class="fas fa-exclamation-triangle text-danger fa-lg" title="${message}"></i><span style="font-size: 9px; color: red;margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute('data-status', 'time-error');

                    // highlight input
                    const rowError = rows[i];
                    rowError.querySelector('.start-input')?.classList.add('error-border');

                    return;
                }
            }

            // ✅ Semua lulus → baru check availability
            if (roomId) {
                debounceCheckAvailability(roomId, start, end, row);
            }

            checkAvailability(roomId, start, end, row);
        }

        const kategoriPengerusiSelect = document.getElementById("kategori_pengerusi");
        if (kategoriPengerusiSelect) {
            kategoriPengerusi(); // Panggil sekali semasa load
            kategoriPengerusiSelect.addEventListener('change', kategoriPengerusi);
        }

        const penganjurSelect = document.getElementById("penganjur");
        if (penganjurSelect) {
            alert_nama_penganjur(); // Panggil sekali semasa load
            penganjurSelect.addEventListener('change', alert_nama_penganjur);
        }

        const sajianSelect = document.getElementById("jenis_sajian");
        if (sajianSelect) {
            sajianSelected(sajianSelect.value); // Panggil sekali semasa load
            sajianSelect.addEventListener('change', function () {
                sajianSelected(this.value);
            });
        }

        const webexYa = document.getElementById("ya");
        const webexTidak = document.getElementById("tidak");
        if (webexYa && webexTidak) {
            webexSelected(); // Panggil semasa load
            webexYa.addEventListener('change', webexSelected);
            webexTidak.addEventListener('change', webexSelected);
        }

        const vcCheckbox = document.getElementById("vc_selected");
        if (vcCheckbox) {
            showHideForm(); // Panggil semasa load
            vcCheckbox.addEventListener('change', showHideForm);
        }

        const CHECK_AVAILABILITY_URL = "{{ route('check.availability') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";

        //fungsi untuk elak banyak kali panggil fungsi checkAvailability
        let debounceTimeout;
        function debounceCheckAvailability(roomId, start, end, row) {
            clearTimeout(debounceTimeout); // Reset timeout jika user masih menaip/ubah
            debounceTimeout = setTimeout(() => {
                if (!start || !end) {
                    console.log('⛔ debounceCheckAvailability batal sebab input kosong');
                    const statusSpan = row.querySelector('.availability-status');
                    if (statusSpan) {
                        statusSpan.innerHTML = '';
                        statusSpan.removeAttribute('data-status');
                    }
                    return;
                }
                checkAvailability(roomId, start, end, row); // Jalankan sebenar selepas 300ms
            }, 300);
        }

        function checkAvailability(roomId, start, end, row) {
            console.log("🔍 checkAvailability:", { roomId, start, end });

            const statusSpan = row.querySelector('.availability-status');
            const messageDefault = "Bilik tidak tersedia.";

            if (!roomId || !start || !end) {
                if (statusSpan) {
                    statusSpan.innerHTML = '';
                    statusSpan.removeAttribute('data-status');
                }
                return;
            }

            statusSpan.innerHTML = `
                <i class="fas fa-spinner fa-spin text-muted fa-sm" title="Menyemak..."></i>
            `;

            fetch(CHECK_AVAILABILITY_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": CSRF_TOKEN
                },
                body: JSON.stringify({ room_id: roomId, start, end })
            })
            .then(response => {
                if (!response.ok) throw new Error("HTTP error " + response.status);
                return response.json();
            })
            .then(data => {
                console.log("✅ Response:", data);

                if (data.available === true) {
                    const message = "Bilik tersedia";
                    statusSpan.innerHTML = `
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                        <span style="font-size: 9px; color: green; margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute("data-status", "available");
                } else {
                    const message = data.message || messageDefault;
                    statusSpan.innerHTML = `
                        <i class="fas fa-exclamation-triangle text-danger fa-lg"></i>
                        <span style="font-size: 9px; color: red; margin-left: 4px;">${message}</span>`;
                    statusSpan.setAttribute("data-status", "unavailable");
                }
            })
            .catch(error => {
                console.error("❌ checkAvailability error:", error);
                statusSpan.innerHTML = `
                    <i class="fas fa-exclamation-circle text-danger fa-lg"></i>
                    <span style="font-size: 9px; color: red; margin-left: 4px;">Ralat semakan</span>`;
                statusSpan.setAttribute("data-status", "unavailable");
            });
        }

        initFlatpickrForRow(firstRow);
        bindChangeEventToRow(firstRow);

        document.getElementById('addRow').addEventListener('click', function () {
            const newRow = firstRow.cloneNode(true);

            // Buang butang btn-batal-admin daripada row baru
            newRow.querySelectorAll('.btn-batal-admin').forEach(btn => btn.remove());

            // Kosongkan input
            newRow.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                input.value = '';
                if (name) input.setAttribute('name', name.replace(/\[\d+]/, `[${index}]`));
                input.removeAttribute('id');
                if (input._flatpickr) input._flatpickr.destroy();
                input.classList.remove('error-border');
            });

            // ✅ Kosongkan isi batch_id & id (tapi kekalkan td)
            const batchSpan = newRow.querySelector('.batch_id_input');
            if (batchSpan) batchSpan.textContent = '';

            const idSpan = newRow.querySelector('.id_input');
            if (idSpan) idSpan.textContent = '';

            // Kosongkan status paparan
            const statusSpan = newRow.querySelector('.availability-status');
            if (statusSpan) {
                statusSpan.textContent = '';
                statusSpan.innerHTML = '';
            }

            // Kosongkan sel status_room (butang atau badge)
            const statusCell = newRow.querySelector('td:last-child');
            if (statusCell) statusCell.innerHTML = '';

            // ✅ Tunjukkan ikon trash untuk row baharu
            const removeIcon = newRow.querySelector('.remove-row');
            if (removeIcon) {
                removeIcon.style.display = 'inline-block';
            } else {
                console.warn('❗Tiada .remove-row ditemui dalam firstRow — semak HTML asal.');
            }

            bookingContainer.appendChild(newRow);

            initFlatpickrForRow(newRow);
            bindChangeEventToRow(newRow);

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
                // disablekan tab bilik → letak class disabled
                $('#tab-bilik').addClass('disabled');

                // show alert manual
                $('#div_alert_bilik_manual').show();

                // kalau tab bilik sedang aktif → terus lompat ke VC
                if ($('#tab-bilik').hasClass('active')) {
                    $('#tab-vc').tab('show');
                }
            } else {
                $('#tab-bilik').removeClass('disabled');
                $('#div_alert_bilik_manual').hide();
            }

            // 2. Handle upload → show kalau isUpload == 'Y'
            if (isUpload === 'Y') {
                $('#div_upload').show();
            } else {
                $('#div_upload').hide();
            }

            // 3. Pantry → kalau ada extra action boleh letak sini

            // 4. Check availability untuk setiap row
            document.querySelectorAll('.booking-row').forEach(checkAvailabilityIfReady);
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
                // Swal.fire({
                // title: 'Susunan Tarikh Tidak Sah',
                // text: msg,
                // icon: 'warning', // boleh buang kalau guna iconHtml
                // iconHtml: '<i class="fas fa-exclamation-triangle fa-4x text-warning"></i>',
                // customClass: {
                //     icon: 'no-default-icon'
                // },
                // confirmButtonText: 'OK'
                // });

                return;
            }

            document.getElementById('submitButton').disabled = true;
        });

        document.getElementById('copy_applicant')?.addEventListener('change', function () {
            const isChecked = this.checked;
            const data = {
                nama: "{{ $user->name }}",
                email: "{{ $user->email }}",
                jawatan: "{{ $user->profile->position_id }}",
                bahagian: "{{ $user->profile->department_id }}",
                sambungan: "{{ $user->profile->no_extension }}",
                bimbit: "{{ $user->profile->no_bimbit }}"
            };

            document.getElementById("nama_urusetia").value = isChecked ? data.nama : '';
            document.getElementById("email_urusetia").value = isChecked ? data.email : '';

            // Set value dan trigger change untuk select2
            $('#jawatan_urusetia').val(isChecked ? data.jawatan : '').trigger('change');
            $('#bahagian_urusetia').val(isChecked ? data.bahagian : '').trigger('change');

            document.getElementById("no_sambungan_urusetia").value = isChecked ? data.sambungan : '';
            document.getElementById("no_bimbit_urusetia").value = isChecked ? data.bimbit : '';
        });


    //     const form = document.getElementById("bookingForm"); // ganti id ikut form awak

    // document.querySelector("form").addEventListener("submit", function (e) {
    //     const errorSpans = document.querySelectorAll(
    //         '.availability-status[data-status="unavailable"], .availability-status[data-status="sequence-error"]'
    //     );

    //     if (errorSpans.length > 0) {
    //         e.preventDefault(); // stop hantar
    //         Swal.fire({
    //             title: 'Ralat Borang',
    //             text: 'Tarikh tidak sah. Sila kemaskini tarikh sebelum menghantar permohonan.',
    //             iconHtml: '<i class="fas fa-exclamation-circle" style="font-size: 40px; color: red;"></i>',
    //             confirmButtonText: 'OK'
    //         });
    //     }
    // });
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-batal-admin').forEach(function (button) {
            button.addEventListener('click', function () {
                const roomId = this.dataset.roomId; // ambil data-room-id

                Swal.fire({
                    title: 'Adakah anda pasti?',
                    text: "Tempahan ini akan dibatalkan oleh pentadbir.",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, batal!',
                    cancelButtonText: 'Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('/admin/application_room/edit_approve') }}/${roomId}`,{
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                status_room_id: 13 // status "Batal oleh pentadbir"
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berjaya',
                                    text: 'Tempahan telah dibatalkan.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Optional: tukar teks butang terus tanpa reload
                                button.textContent = 'Telah Dibatalkan';
                                button.classList.remove('btn-warning');
                                button.classList.add('btn-secondary');
                                button.disabled = true;

                            } else {
                                Swal.fire('Ralat', data.message || 'Gagal mengemaskini status.', 'error');
                            }
                        })
                        .catch(() => Swal.fire('Ralat', 'Masalah sambungan ke pelayan.', 'error'));
                    }
                });
            });
        });
    });
</script>


@endsection
