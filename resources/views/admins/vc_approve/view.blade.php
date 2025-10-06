@extends('layouts.backend_admin')

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/admin/application_vc/1" class="breadcrumb-item"> Tindakan</a>
        <span class="breadcrumb-item active"> Paparan Tempahan</span>
    </div>
@endsection

@section('content')

    <body onload="onLoadFunction()">
        <div class="card">
            <div class="card-header">
                <h5>Paparan Tempahan</h5>
                <a href="/admin/application_vc/1">
                    <h6>Senarai Tindakan</h6>
                </a>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item"><a href="#maklumat_permohonan" class="nav-link rounded-round"
                            data-toggle="tab">Maklumat Permohonan</a></li>
                    <li class="nav-item"><a href="#maklumat_vc" class="nav-link rounded-round active"
                            data-toggle="tab">Permohonan
                            Tempahan VC</a></li>
                    <li class="nav-item"><a href="#maklumat_bilik" class="nav-link rounded-round" data-toggle="tab">Maklumat
                            Pemohon/Urusetia Bilik
                        </a></li>

                </ul>
                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <span class="badge badge-primary">
                            @role('user|super-admin')
                                {{-- {{ $application }}
                            @else --}}
                                {{ $application->applicationVc->statusVc->status_pentadbiran }}
                            @endrole
                        </span>

                    </div>
                </div>
                <form class="confirm" action="/admin/application_vc/result/{{ encrypt($application->batch_id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div class="tab-pane fade" id="maklumat_permohonan">

                            <fieldset>
                                <div class="card card bg-light">

                                    <div id="form_permohonan" class="collapse show">
                                        <div class="card-body">

                                            <div class="d-flex py-2 border-bottom align-items-center">
                                                <strong class="me-3" style="min-width: 180px;">Nama Bilik/Lokasi</strong>
                                                <span>{{ $application?->room->nama ? :'-' }}</span>
                                            </div>  
                                            <br>

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
                                                                        @if ($app->applicationVc->status_vc_id == '1')                                                            
                                                                            <span
                                                                                class="badge badge-warning">{{ $app->applicationVc->statusVc->status_pentadbiran }}</span>
                                                                        @elseif($app->applicationVc->status_vc_id == '2' ||
                                                                            $app->applicationVc->statusVc->status_pentadbiran == '14')
                                                                            <span
                                                                                class="badge badge-primary">{{ $application->applicationVc->statusVc->status_pentadbiran }}</span>
                                                                        @elseif($app->applicationVc->status_vc_id == '3')
                                                                            <span
                                                                                class="badge badge-success">{{ $app->applicationVc->statusVc->status_pentadbiran }}</span>
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
                                                                        @if ($app->applicationVc->status_vc_id == '1')
                                                                            <span
                                                                                class="badge badge-warning">{{ $app->applicationRoom->statusRoom->status_pemohon }}</span>
                                                                        @elseif($app->applicationVc->status_vc_id == '2' ||
                                                                            $app->applicationRoom->statusRoom->status_pentadbiran == '14')
                                                                            <span
                                                                                class="badge badge-primary">{{ $app->applicationRoom?->statusRoom->status_pemohon }}</span>
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
                            {{-- Blok 9 Jan 23 --}}
                            @if (isset($application->applicationVc))
                                @if ($application->applicationVc->status_vc_id == 2 ||
                                    $application->applicationVc->status_vc_id == 3 ||
                                    $application->applicationVc->status_vc_id == 12)
                                    @include('applications.vc.edit')
                                @else
                                    @include('applications.vc.view')
                                @endif
                            @else
                                <div class="text-center text-danger">-Tiada Permohonan-</div>
                            @endif

                            {{-- @if (isset($application->applicationVc))
                                @include('applications.vc.view')
                            @else
                                <div class="text-center text-danger">-Tiada Permohonan-</div>
                            @endif --}}

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
                        @if ($application->applicationVc->status_vc_id == '2')
                            <form class="delete" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="button" value="3">
                                <button type="submit" class="btn btn-primary btn-sm submit-btn">
                                    Lulus
                                </button>
                            </form>

                            <button type="button" name="button" value="4" data-toggle="modal"
                                data-target="#modal_tolak" class="btn btn-danger btn-sm"
                                onclick="copy_catatan_vc_penyelia_tolak()">Tolak</button>

                            <button type="button" name="button" value="10" data-toggle="modal"
                                data-target="#modal_batal" class="btn btn-warning btn-sm"
                                onclick="copy_catatan_vc_penyelia_batal()">Batal</button>
                        @elseif($application->applicationVc->status_vc_id == '3' || $application->applicationVc->status_vc_id == '12')
                            <form class="update" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="button" value="12">
                                <!-- <button type="submit" class="btn btn-primary btn-sm submit-btn">
                                    Kemaskini
                                </button> -->
                            </form>
                            <button type="button" name="button" value="10" data-toggle="modal"
                                data-target="#modal_batal" class="btn btn-danger btn-sm"
                                onclick="copy_catatan_vc_penyelia_batal()">Batal</button>
                        @endif
                    </div>
                </form>


                <div id="modal_tolak" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header bg-danger">
                                <h6 class="modal-title">Alasan Permohonan Ditolak</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form action="/admin/application_vc/result/{{ encrypt($application->batch_id) }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">

                                    <div class="form-group row">
                                        <div class="col-lg-10">
                                            <textarea name="komen_ditolak" rows="3" cols="3" class="form-control"
                                                placeholder="Sila masukkan alasan sebab-sebab permohonan ditolak"></textarea>
                                        </div>
                                    </div>

                                    <input type="hidden" name="catatan_vc_penyelia" id="catatan_vc_penyelia_tolak">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>


                                    <form class="delete" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="hidden" name="button" value="4">
                                        <button type="submit" class="btn btn-success btn-sm submit-btn">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modal_batal" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-secondary">
                                <h6 class="modal-title">Alasan Permohonan Dibatalkan</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form action="/admin/application_vc/result/{{ encrypt($application->batch_id) }}" method="post">
                                @csrf
                                <div class="modal-body">

                                    <div class="form-group row">
                                        <div class="col-lg-10">
                                            <textarea name="komen_ditolak" rows="3" cols="3" class="form-control"
                                                placeholder="Sila masukkan alasan sebab-sebab permohonan dibatalkan"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="catatan_vc_penyelia" id="catatan_vc_penyelia_batal">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                                    <form class="delete" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="hidden" name="button" value="10">
                                        <button type="submit" class="btn btn-success btn-sm submit-btn">
                                            Batal
                                        </button>
                                    </form>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                $url = url()->current();
                $start = 'application/';
                $end = '/';
                $action = Str::between($url, $start, $end);
                ?>

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
                                                    <td class="text-right"><span class="text-default">Jawatan</span></td>
                                                    <td>{{ $application->user->profile->position->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">Bahagian</span></td>
                                                    <td>{{ $application->user->profile->department->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><span class="text-default">No. Sambungan</span>
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

            </div>
        </div>
    </body>
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
        $('.cancel-btn').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal({
                    title: 'Adakah anda pasti?',
                    text: 'Permohonan akan dibatalkan!',
                    icon: "warning",
                    buttons: ["Tidak", "Batal!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        function onLoadFunction() {
            webexSelected();
        }

        function webexSelected() {
            var webex_data = <?php echo $application->applicationVc->webex; ?>;
            var webex_ya = document.getElementById("ya");
            var webex_tidak = document.getElementById("tidak");
            var div_nama_aplikasi = document.getElementById("div_nama_aplikasi");
            var id_webex = document.getElementById("id_webex");
            var password_expired = document.getElementById("password_expired");
            var div_webex = document.getElementById("div_webex");
            var password_webex = document.getElementById("password_webex");
            // var currentText = id_webex.text();
            // alert(currentText);

            if (webex_ya.checked == true) {
                div_nama_aplikasi.style.display = 'none';
                div_webex.style.display = 'block';
                // id_webex.value = '@miti.gov.my';
            }

            if (webex_tidak.checked == true) {
                div_nama_aplikasi.style.display = 'block';
                div_webex.style.display = 'none';
                id_webex.value = null;
                password_expired.value = null;
                password_webex.value = null;

            }
        }

        function copy_catatan_vc_penyelia_tolak() {

            var catatan_vc_penyelia_tolak = document.getElementById("catatan_vc_penyelia_tolak");
            var catatan_vc_penyelia = document.getElementById("catatan_vc_penyelia");

            catatan_vc_penyelia_tolak.value = catatan_vc_penyelia.value;

        }

        function copy_catatan_vc_penyelia_batal() {

            var catatan_vc_penyelia_batal = document.getElementById("catatan_vc_penyelia_batal");
            var catatan_vc_penyelia = document.getElementById("catatan_vc_penyelia");

            catatan_vc_penyelia_batal.value = catatan_vc_penyelia.value;

        }

        // function hostMiti(id) {

        //     var akaun_webex = document.getElementById("akaun_webex");

        //     document.getElementById("id_webex").value = id + '@miti.gov.my';
        //     if (akaun_webex == 0) {
        //         document.getElementById("id_webex").value = null;
        //     }
        // }
    </script>
@endsection
