@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/application/{{ $tag = session()->get('tag') }}" class="breadcrumb-item"> Rekod Pemohon</a>
        <span class="breadcrumb-item active"> Paparan Tempahan</span>

    </div>
@endsection

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Paparan Tempahan</h5>
            @if (!empty($successMessage))
                <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                            class="sr-only">Tutup</span></button>
                    <strong>Berjaya, </strong> {{ $successMessage }}
                </div>
            @endif

        </div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round active"
                        data-toggle="tab">Maklumat Permohonan</a></li>
                <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan Bilik</a></li>
                <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan VC</a></li>
            </ul>

            <form method="post" enctype="multipart/form-data">

                <div class="tab-content">
                    <div class="card-header bg-white d-flex justify-content-between">
                        <strong>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
                                class="icon-info22 mr-3"></i></strong>
                    </div>
                    <div class="tab-pane fade show active" id="maklumat_permohonan">
                        <fieldset>
                            <div class="card card bg-light">

                                <div class="card-body" style="padding-left: 5rem;">

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
                            </div>
                        </fieldset>

                    </div>

                <div class="tab-pane fade" id="maklumat_bilik">
                    @if (isset($application->applicationRoom))
                        @include('applications.room.view_pemohon')
                    @else
                        <div class="text-center text-danger">- Tempahan Bilik Secara Manual -</div>
                    @endif

                </div>

                <div class="tab-pane fade" id="maklumat_vc">
                    @if (isset($application->applicationVc))
                        @include('applications.vc.view')
                    @else
                        <div class="text-center text-danger">- Tiada Permohonan VC -</div>
                        <br>
                        <br>
                        <div class="text-center"><a href="/application/create_vc/{{ $application->id }}"><button
                                    type="button" class="btn btn-primary btn-sm" title="Mohon Bilik">Mohon VC
                                </button></a></div>
                    @endif
                </div>
            </div>
        </form>

        <?php
        $tag = session()->get('tag');
        ?>

        @if ($errors->any())
            <script>
                $(function() {
                    $('#modalBatal_room_vc').modal({
                        show: true
                    });
                });
            </script>
        @endif

    <!-- modalBatal_room_vc Modal -->
    <div id="modalBatal_room_vc" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title">Pembatalan</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="/application/cancel/{{ $application->id }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-styled-right alert-dismissible">
                                    <button type="button" class="close"
                                        data-dismiss="alert"><span>&times;</span><span
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
                            <div class="col-lg-10">

                                <div class="form-group">
                                    <label class="font-weight-semibold">Pilihan</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="option_cancel[]" value="room"
                                                class="form-check-input">
                                            Bilik
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="option_cancel[]" value="vc"
                                                class="form-check-input">
                                            VC
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>

                        <button type="submit" name="button" value="batal"
                            class="btn bg-warning">Submit</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- /modalBatal_room_vc Modal -->

    <!-- modalMohonBatal_room_vc Modal -->
    <div id="modalMohonBatal_room_vc" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title">Permohonan Pembatalan</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="/application/edit/{{ $application->id }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-lg-10">

                                <div class="form-group">
                                    <label class="font-weight-semibold">Pilihan</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="option_apply_cancel[]" value="room"
                                                class="form-check-input">
                                            Bilik
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="option_apply_cancel[]" value="vc"
                                                class="form-check-input">
                                            VC
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>

                        <button type="submit" name="button" value="mohon_batal"
                            class="btn bg-warning">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- /modalBatal_room_vc Modal -->

    <!-- Maklumat Pemohon Modal -->
    <!-- <div id="modal_default" class="modal fade" tabindex="-1">
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
    </div> -->
    <div class="modal fade" id="modal_default" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-3 shadow">

                <div class="modal-header border-0 bg-primary text-white">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="fas fa-user-circle mr-2" style="font-size: 1.5rem;"></i>
                        Maklumat Pemohon
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @php
                        $user = $application->user;
                        $profile = $user->profile;
                    @endphp

                    <div class="row gy-3">
                        @foreach ([
                            'Nama' => $user->name,
                            'E-mel' => $user->email,
                            'Jawatan' => $profile->position->nama ?? '-',
                            'Bahagian/Seksyen' => $profile->department->nama ?? '-',
                            'No. Sambungan' => $profile->no_extension ?? '-',
                            'No. Telefon Bimbit' => $profile->no_bimbit ?? '-',
                        ] as $label => $value)
                            <div class="col-12 d-flex border-bottom pb-2">
                                <div class="text-dark fw-bold" style="min-width: 160px;">{{ $label }}</div>
                                <div class="text-muted flex-grow-1">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
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
        $('.submit-btn').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Adakah anda pasti ?',
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
    </script>
@endsection
