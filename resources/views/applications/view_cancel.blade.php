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
        </div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round active"
                        data-toggle="tab">Maklumat Permohonan</a></li>
                <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan Bilik</a></li>
                <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round" data-toggle="tab">Permohonan
                        Tempahan VC</a></li>
                {{-- <li class="nav-item"><a href="#hantar" class="nav-link rounded-round" data-toggle="tab">Perakuan</a></li> --}}

            </ul>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="tab-content">
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
                                                        @if (!empty($contains))

                                                            @if ($application->applicationVc?->status_vc_id == '1' || $application->applicationVc?->status_vc_id == '2')
                                                                <span
                                                                    class="badge badge-primary">{{ $application->applicationVc?->statusVc->status_pentadbiran }}</span>
                                                            @elseif($application->applicationVc?->status_vc_id == '3')
                                                                <span
                                                                    class="badge badge-success">{{ $application->applicationVc?->statusVc->status_pentadbiran }}</span>
                                                            @elseif($application->applicationVc?->status_vc_id == '10' ||
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
                                                            @if ($application->applicationVc?->status_vc_id == '1' || $application->applicationVc?->status_vc_id == '2')
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
                            {{-- <div class="text-center text-danger">-Tiada Permohonan Bilik-</div> --}}
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
                            <div class="text-center"><a href="/application/edit/{{ $application->id }}"><button
                                        type="button" class="btn btn-primary btn-sm" title="Mohon Bilik">Mohon VC
                                    </button></a></div>
                        @endif
                    </div>
                </div>
            </form>

            <?php
            $tag = session()->get('tag');
            ?>

            @if ($tag == '1')

                <form class="batal" action="/application/cancel/{{ $application->id }}" method="POST">
                    {{ csrf_field() }}

                    <div class="card-footer text-center">
                        @if (!empty($application->applicationRoom))
                            @if (!empty($application->applicationVc))

                                @if ($application->applicationRoom->status_room_id == '1')
                                    @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2')
                                        {{-- Batal Permohonan (RV) --}}
                                        <div class="text-center">
                                            <form class="delete" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="POST">
                                                <input type="hidden" name="act" value="batal_room_vc">
                                                <button type="submit" class="btn bg-warning submit-btn">
                                                    {{-- RV --}}
                                                    Batal Permohonan 1
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        {{-- Batal Permohonan (ROOM) --}}
                                        <div class="text-center">
                                            <form class="delete" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="POST">
                                                <input type="hidden" name="act" value="batal_room">
                                                <button type="submit" class="btn bg-warning submit-btn">
                                                    Batal Permohonan 2
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @elseif($application->applicationRoom->status_room_id == '2' ||
                                    $application->applicationRoom->status_room_id == '14')
                                    @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2')
                                        {{-- <button type="button" name="button" data-toggle="modal" title="Mohon_Batal"
                                            data-target="#modalMohonBatal_room_vc"
                                            class="btn btn-warning btn-sm">Permohonan
                                            Pembatalan</button> --}}
                                        <div class="text-center">
                                            <form class="delete" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="POST">
                                                <input type="hidden" name="act" value="mohon_batal">
                                                <button type="submit" class="btn bg-warning submit-btn">
                                                    Batal Permohonan 3
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <form class="delete" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="POST">
                                                <input type="hidden" name="act" value="mohon_batal">
                                                <button type="submit" class="btn bg-warning submit-btn">
                                                    Permohonan Pembatalan
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @else
                                    @if ($application->applicationVc->status_vc_id == '2' || $application->applicationVc->status_vc_id == '9')
                                        <div class="text-center">
                                            <form class="delete" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="POST">
                                                <input type="hidden" name="act" value="batal_vc">
                                                <button type="submit" class="btn bg-warning submit-btn">
                                                    {{-- Batal VC --}}
                                                    Batal Permohonan 4
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            @else
                                {{-- <a href="/application/edit/{{ $application->id }}"><button type="button"
                                        class="btn btn-success btn-sm">Kemaskini</button></a> --}}
                                @if ($application->applicationRoom->status_room_id == '1')
                                    <div class="text-center">
                                        <form class="delete" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="POST">
                                            <input type="hidden" name="act" value="batal_room">
                                            <button type="submit" class="btn bg-warning submit-btn">
                                                {{-- ROOM --}}
                                                Batal Permohonan 5
                                            </button>
                                        </form>
                                    </div>
                                @elseif($application->applicationRoom->status_room_id == '2' ||
                                $application->applicationRoom->status_room_id == '6' ||
                                $application->applicationRoom->status_room_id == '14')
                                  
                                    <div class="text-center">
                                        <form class="delete" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="POST">
                                            <input type="hidden" name="act" value="mohon_batal">
                                            <button type="submit" class="btn bg-warning submit-btn">
                                                {{-- Batal Bilik --}}
                                                Permohonan Pembatalan
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        @else
                            @if ($application->applicationVc->status_vc_id == '1' ||
                                $application->applicationVc->status_vc_id == '2' ||
                                $application->applicationVc->status_vc_id == '3' ||
                                $application->applicationVc->status_vc_id == '12')
                                <div class="text-center">
                                    <form class="delete" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="hidden" name="act" value="batal_vc">
                                        <button type="submit" class="btn bg-warning submit-btn">
                                            {{-- Batal VC --}}
                                            Batal Permohonan 7
                                        </button>
                                    </form>
                                </div>
                            @endif

                        @endif
                    </div>
                </form>

            @endif

            @if ($errors->any())
                <script>
                    $(function() {
                        $('#modalBatal_room_vc').modal({
                            show: true
                        });
                    });
                </script>
            @endif

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
    </script>
@endsection
