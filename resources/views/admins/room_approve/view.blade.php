@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/admin/application_room/1" class="breadcrumb-item">Rekod Tempahan Bilik</a>
        <span class="breadcrumb-item active"> Paparan Tempahan</span>

    </div>
@endsection

@section('js_extensions')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h5>Paparan Tempahan</h5>
            <a href="/admin/application_room/1">
                <h6>Senarai Tindakan</h6>
            </a>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round active"
                        data-toggle="tab">Maklumat Permohonan</a></li>
                <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Maklumat
                        Pemohon/Urusetia</a></li>
            </ul>

            @if ($application->applicationRoom->status_room_id == '1')
                @if ($applicationCount > 0)
                    <div class="alert alert-warning alert-dismissible">
                        <!-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> -->
                        <span class="font-weight-semibold">Perhatian : </span> Bilik ini <b>TELAH
                            DITEMPAH</b> pada tarikh dan masa yang sama.  Mohon semakan <b>PENTADBIR BILIK</b> supaya tiada pertindihan kelulusan.
                    </div>
                @endif
            @endif

            <form id="myForm" action="/admin/application_room/result/{{ $application->batch_id }}" method="POST">
                {{ csrf_field() }}
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="maklumat_permohonan">

                        <!-- Collapsible with left control button -->
                        <div class="card-group-control card-group-control-left">

                            <div class="card-header">
                                <h6 class="card-title">
                                    <a data-toggle="collapse" class="text-default" href="#maklumat_mesyuarat">Maklumat
                                        Permohonan
                                    </a>
                                </h6>
                            </div>

                            <div id="maklumat_mesyuarat" class="collapse show">

                                <div class="card bg-light">

                                    <div class="card-body">

                                            <div class="card-body">
                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <strong class="me-3" style="min-width: 180px;">Nama Bilik/Lokasi</strong>
                                                    <span>{{ $application?->room->nama ? :'-' }}</span>
                                                </div>
                                                <br>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%;">Batch ID</th>
                                                            <th style="width: 5%;">ID</th>
                                                            <th class="text-center" style="width: 20%;">Tarikh/Masa Mula</th>
                                                            <th class="text-center" style="width: 20%;">Tarikh/Masa Tamat</th>
                                                            <th class="text-center" style="width: 20%;">Status</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="booking-rows">
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

                                                                    @if (!empty($contains))
                                                                        @if ($app->applicationRoom->status_room_id == '1')
                                                                            <span
                                                                                class="badge badge-primary">{{ $app->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                                        @elseif($app->applicationRoom->status_room_id == '2' ||
                                                                            $app->applicationRoom->status_room_id == '14')
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
                                                                    @else
                                                                        @if ($app->applicationRoom?->status_room_id == '1')
                                                                            <span
                                                                                class="badge badge-primary">{{ $app->applicationRoom->statusRoom->status_pemohon }}</span>
                                                                        @elseif($app->applicationRoom?->status_room_id == '2' ||
                                                                            $app->applicationRoom?->status_room_id == '14')
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

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <hr>

                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <strong class="me-3" style="min-width: 180px;">Tajuk Mesyuarat/Program</strong>
                                                    <span class="text-muted">{{ $application->nama_mesyuarat ?: '-' }}</span>
                                                </div>

                                                @php
                                                    $kategori_pengerusi_text = $application->kategori_pengerusi == '0'
                                                        ? $application->nama_pengerusi
                                                        : $application->kategori_pengerusi;
                                                @endphp

                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <strong class="me-3" style="min-width: 180px;">Pengerusi</strong>
                                                    <div class="flex-grow-1 text-muted">{{ $kategori_pengerusi_text }}</div>
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

                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <strong class="me-3" style="min-width: 180px;">Bil.Tempahan/Kehadiran</strong>
                                                    <span class="text-muted">{{  $application->bilangan_tempahan ?: '-' }}</span>
                                                </div>

                                                <div class="d-flex py-2 border-bottom align-items-center">
                                                    <strong class="me-3" style="min-width: 180px;">Tarikh Permohonan</strong>
                                                    <span class="text-muted">{{ date('d-m-Y g:i A', strtotime($application->created_at)) }}</span>
                                                </div>
                                            </div>
                                        <!-- </div> -->

                                    </div>

                                </div>
                            </div>

                            <div class="card-header">
                                <h6 class="card-title">
                                    <a data-toggle="collapse" class="text-default" href="#maklumat_terperinci">Maklumat
                                        Terperinci
                                        Mesyuarat/Program</a>
                                </h6>
                            </div>

                            <div id="maklumat_terperinci" class="collapse show">
                                <div class="card bg-light">
                                    <div class="card-body">

                                        <!-- <div style="padding-left: 4rem;">      -->

                                            <div class="d-flex py-2 border-bottom align-items-center">
                                                <strong class="me-3" style="min-width: 150px;">Lampiran</strong>
                                                @if ($application->applicationRoom->surat)
                                                        <a href="{{ asset($application->applicationRoom->surat) }}" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-paperclip"></i> Lampiran
                                                        </a>
                                                @else
                                                    <span class="text-muted">Tiada lampiran</span>
                                                @endif
                                            </div>

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
                                                            class="col-md-3 col-form-label">{{ __('Catatan Ditolak/Batal') }}</label>
                                                        <div class="col-md-9">
                                                            <textarea rows="2" cols="2" class="form-control" name="catatan_vc_penyelia" readonly>{{ $application->applicationRoom->komen_ditolak }}</textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                        <!-- </div> -->

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="maklumat_bilik">
                        @if (isset($application->applicationRoom))
                            @include('applications.room.view')
                        @else
                            <div class="text-center text-danger">-Tiada Permohonan-</div>
                        @endif
                    </div>

                </div>
                @if ($application->applicationRoom->status_room_id == '1')
                    @if ($applicationCount > 0)
                        <div class="alert alert-warning alert-dismissible">
                            <!-- <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button> -->
                            <span class="font-weight-semibold">Perhatian : </span> Bilik ini <b>telah
                                ditempah</b> pada tarikh dan masa yang sama. Mohon semakan Pentadbir bilik supaya tiada pertindihan kelulusan.
                        </div>
                    @endif
                @endif

                <div class="card-footer text-center">
                    <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                        Kembali</button>
                    @if ($application->applicationRoom->status_room_id == '1')

                       {{-- <form action="/admin/application_room/result/{{ $application->id }}" method="POST" class="approval-form">
                            {{ csrf_field() }} --}}
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="button" value="2">
                            <button type="button" id="btnSubmit" class="btn btn-primary btn-sm confirm-submit"

                                @disabled($applicationCount > 0)>
                                Lulus
                            </button>
                        {{-- </form> --}}

                        <button type="button" name="button" value="4" data-toggle="modal"
                            data-target="#modal_tolak" class="btn btn-danger btn-sm"
                            onclick="copy_catatan_room_penyelia_tolak()">Tolak</button>
                        <button type="button" name="button" value="13" data-toggle="modal"
                            data-target="#modal_batal" class="btn btn-danger btn-sm"
                            onclick="copy_catatan_room_penyelia_batal()">Batal</button>
                    @elseif($application->applicationRoom->status_room_id == '2' ||
                        $application->applicationRoom->status_room_id == '14')
                        <button type="button" name="button" value="12" data-toggle="modal"
                            data-target="#modal_batal" class="btn btn-warning btn-sm">Batal</button>
                    @elseif($application->applicationRoom->status_room_id == '3')

                            {{-- Butang Lulus Pembatalan --}}
                            <button type="button" name="button" value="5" class="btn btn-primary btn-sm">
                                Lulus Pembatalan
                            </button>
                            {{-- Butang Tolak Pembatalan --}}
                            <button type="button" name="button" value="6" class="btn btn-danger btn-sm">
                                Tolak Pembatalan
                            </button>
                        {{-- </form> --}}

                    @endif

                </div>
            </form>

            <!-- Alasan tolak -->
            <div id="modal_tolak" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h6 class="modal-title">Alasan Permohonan Ditolak</h6>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="/admin/application_room/result/{{ $application->batch_id }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="form-group row">
                                    <div class="col-lg-10">
                                        <textarea name="komen_ditolak" rows="3" cols="3" class="form-control"
                                            placeholder="Sila masukkan alasan sebab-sebab permohonan ditolak" required></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="catatan_room_penyelia" id="catatan_room_penyelia_tolak">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                                <button type="submit" name="button" value="4"
                                    class="btn bg-success">hantar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Alasan Batal -->
            <div id="modal_batal" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-secondary">
                            <h6 class="modal-title">Alasan Permohonan Dibatalkan</h6>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="/admin/application_room/result/{{ $application->batch_id }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="form-group row">
                                    <div class="col-lg-10">
                                        <textarea name="komen_ditolak" rows="3" cols="3" class="form-control"
                                            placeholder="Sila masukkan alasan sebab-sebab permohonan dibatalkan"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="catatan_room_penyelia" id="catatan_room_penyelia_batal">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>

                                @if($application->applicationRoom->status_room_id == '1')
                                <button type="submit" name="button" value="13"
                                    class="btn bg-success">Hantar</button>
                                @endif

                                @if($application->applicationRoom->status_room_id == '2')
                                <button type="submit" name="button" value="12"
                                    class="btn bg-success">Hantar</button>
                                @endif
                                <!-- <a href="/admin/application_room/result/{{ $application->id }}"><button type="submit" name="button" value="4" class="btn btn-danger btn-sm">Tolak</button></a> -->
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
                            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Maklumat Pemohon Modal -->

        </div>
    </div>

@endsection

@section('script')
<script>

    document.addEventListener('DOMContentLoaded', function () {
    const btnSubmit = document.getElementById('btnSubmit');
    const form = document.getElementById('myForm');

    if (!btnSubmit) return;

        btnSubmit.addEventListener('click', function (e) {
        e.preventDefault(); // elak form auto submit

        Swal.fire({
            title: 'Hantar kelulusan?',
            text: 'Pastikan semua maklumat permohonan betul sebelum diluluskan.',
            // icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, hantar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
        if (result.isConfirmed) {
            // setkan input hidden "button" = 2 sebelum submit
            let hiddenButton = form.querySelector('input[name="button"]');
            if (hiddenButton) {
            hiddenButton.value = 2;
            } else {
            // kalau tiada, cipta baru
            hiddenButton = document.createElement('input');
            hiddenButton.type = 'hidden';
            hiddenButton.name = 'button';
            hiddenButton.value = 2;
            form.appendChild(hiddenButton);
            }

            form.submit(); // hantar form
        }
        });
    });
    });
</script>

    <script>

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

        function copy_catatan_room_penyelia_tolak() {

            var catatan_room_penyelia_tolak = document.getElementById("catatan_room_penyelia_tolak");
            var catatan_room_penyelia = document.getElementById("catatan_room_penyelia");
            catatan_room_penyelia_tolak.value = catatan_room_penyelia.value;
        }

        function copy_catatan_room_penyelia_batal() {

            var catatan_room_penyelia_batal = document.getElementById("catatan_room_penyelia_batal");
            var catatan_room_penyelia = document.getElementById("catatan_room_penyelia");
            catatan_room_penyelia_batal.value = catatan_room_penyelia.value;
        }
    </script>
@endsection


