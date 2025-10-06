@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/application/{{ $tag = session()->get('tag') }}" class="breadcrumb-item"> Rekod Pemohon</a>
        <span class="breadcrumb-item active"> Kemaskini Tempahan</span>
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

                <form method="post" id="applicationFormVc" enctype="multipart/form-data">>
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
                                            <label for="bilik"
                                                class="col-md-3 col-form-label text-md-right"><b>{{ __('Nama Bilik/Lokasi') }}</b></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="bilik"
                                                    value="{{ $application->room->nama }}" readonly>
                                            </div>
                                        </div>

                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Batch ID</th>
                                                    <th style="width: 5%;">ID</th>
                                                    <th class="text-center" style="width: 20%;">Tarikh/Masa Mula</th>
                                                    <th class="text-center" style="width: 20%;">Tarikh/Masa Tamat</th>         
                                                    <th class="text-center" style="width: 20%;">Status Pemohonan Bilik</th>
                                                    <th class="text-center" style="width: 20%;">Status Pemohonan VC</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody id="booking-rows"> {{-- ✅ only one tbody --}}
                                                @foreach ($applications as $app)
                                                    <tr class="booking-row align-middle">
                                                        
                                                        <td>
                                                            #{{ $app->batch_id }}
                                                        </td>

                                                        <td>
                                                            {{ $app->id }}
                                                        </td>

                                                        <td class="text-center">
                                                            <span>{{ date('d-m-Y h:i A', strtotime($app->tarikh_mula)) }}</span>
                                                        </td>

                                                        <td class="text-center">
                                                            <span>{{ date('d-m-Y h:i A', strtotime($app->tarikh_hingga)) }}</span>
                                                        </td>

                                                        <td class="text-center">
                                                            <!-- pengguna -->
                                                            <span class="text-muted small">
                                                                @if(empty($app->applicationRoom))
                                                                
                                                                    Tiada permohonan
                                                        
                                                                @endif
                                                            </span>
                                                            @if (!empty($contains)) 
                                                                @if ($app->applicationRoom->status_room_id == '1')                                                            
                                                                    <span
                                                                        class="badge badge-primary">{{ $app->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                                @elseif($app->applicationRoom->status_room_id == '2' ||
                                                                    $app->applicationRoom->statusRoom->status_pentadbiran == '14')
                                                                    <span
                                                                        class="badge badge-success">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                                @elseif($app->applicationRoom->status_room_id == '3')
                                                                    <span
                                                                        class="badge badge-danger">{{ $app->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                                @elseif($app->applicationVc->status_vc_id == '4' && is_null($app->applicationVc->komen_ditolak))

                                                                <!-- diasingkan untuk CR Admin VC pada 5 Jun 2024 -->
                                                                    <span
                                                                        class="badge badge-danger">Ditolak Oleh Pentadbir Bilik</span>
                                                                @elseif($app->applicationVc->status_vc_id == '4' && !is_null($app->applicationVc->komen_ditolak))

                                                                <!-- diasingkan untuk CR Admin VC -->
                                                                <span
                                                                    class="badge badge-danger">Ditolak Oleh Pentadbir VC</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-secondary">{{ $app->applicationRoom->statusRoom->status_pentadbiran ?? 'Tiada Permohonan' }}
                                                                    </span> 
                                                                @endif
                                                            <!-- Admin     -->
                                                            @else
                                                                @if ($app->applicationRoom?->status_room_id == '1')
                                                                    <span
                                                                        class="badge badge-primary">{{ $app->applicationRoom->statusRoom->status_pemohon }}</span>
                                                                @elseif($app->applicationRoom?->status_room_id == '2' ||
                                                                    $app->applicationRoom?->statusRoom->status_pentadbiran == '14')
                                                                    <span
                                                                        class="badge badge-success">{{ $app->applicationRoom?->statusRoom->status_pemohon }}</span>
                                                                @elseif($app->applicationRoom?->status_room_id == '3' || $app->applicationRoom?->status_room_id == '4')
                                                                    <span
                                                                        class="badge badge-danger">{{ $app->applicationRoom?->statusRoom->status_pemohon }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-secondary">{{ $app->applicationRoom?->statusRoom->status_pemohon }}</span>
                                                                @endif

                                                            @endif

                                                        </td>
                                                        <td class="text-center">

                                                            <span class="text-muted small">
                                                                @if(empty($app->applicationVc))
                                                                
                                                                    Tiada permohonan
                                                        
                                                                @endif
                                                            </span>

                                                            @if (!empty($contains))

                                                                @if ($application->applicationVc?->status_vc_id == '1' || $application->applicationVc?->status_vc_id == '2')
                                                                    <span
                                                                        class="badge badge-primary">{{ $application->applicationVc?->statusVc->status_pentadbiran }}</span>
                                                                @elseif($application->applicationVc?->status_vc_id == '3')
                                                                    <span
                                                                        class="badge badge-success">{{ $application->applicationVc?->statusVc->status_pentadbiran }}</span>
                                                                @elseif($application->applicationVc?->status_vc_id == '5' ||
                                                                    $application->applicationVc?->status_vc_id == '10' ||
                                                                    $application->applicationVc?->status_vc_id == '11')
                                                                    <span
                                                                        class="badge badge-danger">{{ $application->applicationVc?->statusVc->status_pentadbiran }}</span>
                                                                @elseif($application->applicationVc?->status_vc_id == '4' && is_null($application->applicationVc?->komen_ditolak))
                                                                {{-- diasingkan untuk CR Admin VC pada 5 Jun 2024--}}
                                                                    <span
                                                                        class="badge badge-danger">Ditolak Oleh Pentadbir Bilik</span>

                                                                @elseif($application->applicationVc?->status_vc_id == '4' && !is_null($application->applicationVc?->komen_ditolak))
                                                                {{-- diasingkan untuk CR Admin VC --}}
                                                                    <span
                                                                        class="badge badge-danger">Ditolak Oleh Pentadbir VC</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-secondary">{{ $application->applicationVc?->statusVc->status_pentadbiran }}</span>
                                                                @endif
                                                            @else
                                                                @if ($application->applicationVc?->status_vc_id == '1') 
                                                                    <span
                                                                        class="badge badge-secondary">{{ $application->applicationVc?->statusVc->status_pemohon }}</span>
                                                                @elseif($application->applicationVc?->status_vc_id == '2')
                                                                    <span
                                                                        class="badge badge-primary">{{ $application->applicationVc?->statusVc->status_pemohon }}</span>
                                                                @elseif($application->applicationVc?->status_vc_id == '3')
                                                                    <span
                                                                        class="badge badge-success">{{ $application->applicationVc?->statusVc->status_pemohon }}</span>
                                                                @elseif($application->applicationVc?->status_vc_id == '5' ||
                                                                    $application->applicationVc?->status_vc_id == '10' ||
                                                                    $application->applicationVc?->status_vc_id == '11')
                                                                    <span
                                                                        class="badge badge-danger">{{ $application->applicationVc?->statusVc->status_pemohon }}</span>

                                                                @elseif($application->applicationVc?->status_vc_id == '4' && is_null($application->applicationVc?->komen_ditolak))
                                                                {{-- diasingkan untuk CR Admin VC pada 5 Jun 2024--}}
                                                                    <span
                                                                        class="badge badge-danger">Ditolak Oleh Pentadbir Bilik</span>

                                                                @elseif($application->applicationVc?->status_vc_id == '4' && !is_null($application->applicationVc?->komen_ditolak))
                                                                {{-- diasingkan untuk CR Admin VC --}}
                                                                    <span
                                                                        class="badge badge-danger">Ditolak Oleh Pentadbir VC</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-secondary">{{ $application->applicationVc?->statusVc->status_pemohon }}</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>

                                        <hr>

                                        <div class="form-group row">
                                            <label for="nama_mesyuarat"
                                                class="col-md-3 col-form-label text-md-right">{{ __('Tajuk Mesyuarat/Program') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nama_mesyuarat"
                                                    value="{{ $application->nama_mesyuarat }}" readonly>
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


                        {{-- <button type="submit" class="btn btn-success btn-sm">Kemaskini</button> --}}
                    </div>

                    <div class="text-center"><button type="submit" id="submitButtonVc" class="btn btn-success btn-sm">Hantar
                            Permohonan</button></div>
                </form>

                <script>
                document.getElementById('applicationFormVc').onsubmit = function() {
                    document.getElementById('submitButtonVc').disabled = true;
                };
                </script>

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

    function showHideForm() {
            var vc_selected = document.getElementById("vc_selected");
            var form_room_urusetia = document.getElementById("form_room_urusetia");

            if (vc_selected.checked == true) {
                form_vc.style.display = "block";
            } else {
                form_vc.style.display = "none";
            }
        }

    document.addEventListener('DOMContentLoaded', function () { 

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
        
        const webexYa = document.getElementById("ya");
        const webexTidak = document.getElementById("tidak");
        if (webexYa && webexTidak) {
            webexSelected(); // Panggil semasa load
            webexYa.addEventListener('change', webexSelected);
            webexTidak.addEventListener('change', webexSelected);
        }

        
    });
    </script>
@endsection
