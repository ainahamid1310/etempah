@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/application/{{ $tag = session()->get('tag') }}" class="breadcrumb-item"> Rekod Pemohon</a>
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
                            <div class="text-center text-danger">-Tiada Permohonan Bilik-</div>
                        @endif
                        {{-- <fieldset>

                        <div class="card-group-control card-group-control-left">

                            <div class="card card bg-light">


                                @if (isset($application->applicationRoom))

                                    <div id="collapsible-control-group1" class="collapse show">

                                        <div class="card-header bg-white d-flex justify-content-between">
                                            <span>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon</a></span>

                                        </div>

                                        <div class="card-body">

                                            <div class="form-group">
                                                <div class="form-check form-check-inline form-check-right">
                                                    <label class="form-check-label">
                                                        <span class="text-default">Maklumat Urusetia</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="nama_urusetia" type="text" class="form-control " name="nama_urusetia" value="{{ $application->applicationRoom->nama_urusetia }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mel') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="email_urusetia" type="text" class="form-control" name="email_urusetia" value="{{ $application->applicationRoom->emel_urusetia }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="jawatan_urusetia" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="jawatan_urusetia" type="text" class="form-control" name="jawatan_urusetia" value="{{ $application->applicationRoom->position->nama }}" readonly>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="bahagian_urusetia" class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="bahagian_urusetia" type="text" class="form-control" name="bahagian_urusetia" value="{{ $application->applicationRoom->department->nama }}" readonly>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="no_sambungan_urusetia" class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="no_sambungan_urusetia" value="{{ $application->applicationRoom->no_extension_urusetia }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="no_bimbit_urusetia" class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="no_bimbit_urusetia" value="{{ $application->applicationRoom->no_telefon_bimbit_urusetia }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                @else
                                    <span class="text-default">Tiada permohonan bilik</span>
                                @endif

                            </div>
                        </div>

                        <div class="card card bg-light">
                            <div class="card-header bg-white d-flex justify-content-between">
                                <span class="text-default">Maklumat Mesyuarat</span>
                            </div>

                            <?php
                            if ($application->applicationRoom->kategori_mesyuarat == '1') {
                                $kategori_mesyuarat = 'Mesyuarat Pengurusan Tertinggi';
                            } elseif ($application->applicationRoom->kategori_mesyuarat == '2') {
                                $kategori_mesyuarat = 'Mesyuarat Lain-lain';
                            }
                            ?>

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="kategori_mesyuarat" class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="no_sambungan_urusetia" value="{{ $kategori_mesyuarat }}" readonly>

                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <label for="penganjur" class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="penganjur" value="{{ $application->applicationRoom->penganjur }}" readonly>

                                        </div>
                                    </div>

                                <div id="div_nama_penganjur" style="display: none">
                                    <div class="form-group row">
                                        <label for="nama_penganjur" class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama_penganjur" value="{{ $application->applicationRoom->nama_penganjur }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="surat_emel" class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-uniform-custom" name="surat_emel" id="surat_emel">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="sajian" class="col-md-3 col-form-label text-md-right">{{ __('Sajian') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sajian" value="{{ $application->applicationRoom->sajian }}" readonly>

                                    </div>
                                </div>

                                @if ($application->applicationRoom->sajian == 'Katerer Luar')
                                    <div class="form-group row">
                                        <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                                        <div class="col-md-2">
                                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="minum_pagi" name="minum_pagi" @if ($application->applicationRoom->minum_pagi == '1') checked  @endif disabled>
                                                <label class="custom-control-label position-static" for="minum_pagi">Minum Pagi</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="makan_tengahari" @if ($application->applicationRoom->makan_tengahari == '1') checked  @endif disabled>
                                                <label class="custom-control-label position-static" for="makan_tengahari">Makan Tengahari</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="minum_petang" name="minum_petang" @if ($application->applicationRoom->minum_petang == '1') checked  @endif disabled>
                                                <label class="custom-control-label position-static" for="minum_petang">Minum Petang</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($application->applicationRoom->sajian == 'Pantri Dalaman')
                                    <div class="form-group row">
                                        <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                                        <div class="col-md-2">
                                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input"name="minum_pagi" @if ($application->applicationRoom->minum_pagi == '1') checked  @endif disabled>
                                                <label class="custom-control-label position-static" for="minum_pagi">Minum Pagi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" name="minum_petang" @if ($application->applicationRoom->minum_petang == '1') checked  @endif disabled>
                                                <label class="custom-control-label position-static" for="minum_petang">Minum Petang</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                                    <div class="col-md-9">
                                        <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room">{{ $application->applicationRoom->catatan }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </fieldset> --}}
                    </div>

                    <div class="tab-pane fade" id="maklumat_vc">
                        @if (isset($application->applicationVc))
                            @include('applications.vc.view')
                            {{-- <fieldset>

                            <div class="card card bg-light">

                                @if (isset($application->applicationVc))

                                    <div class="card-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                                            <div class="col-md-1">
                                                <div class="custom-control custom-control-right custom-radio">
                                                    <input type="radio" class="custom-control-input" @if ($application->applicationVc->webex == '1') checked  @endif disabled>
                                                    <label class="custom-control-label position-static" for="ya">Ya</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="custom-control custom-control-right custom-radio">
                                                    <input type="radio" class="custom-control-input" @if ($application->applicationVc->webex == '0') checked  @endif disabled>
                                                    <label class="custom-control-label position-static" for="tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div_nama_aplikasi" style="display: none">
                                            <div class="form-group row">
                                                <label for="nama_aplikasi" class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}</label>
                                                <div class="col-md-9">
                                                    <input id="nama_aplikasi" type="text" class="form-control" name="nama_aplikasi" value="{{ $application->applicationVc->nama_aplikasi }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 text-md-right">Memerlukan Peralatan VC</label>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" @if ($application->applicationVc->kamera == '1') checked  @endif disabled>
                                                    <label class="custom-control-label position-static" for="kamera">Kamera</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" @if ($application->applicationVc->mikrofon == '1') checked  @endif disabled>
                                                    <label class="custom-control-label position-static" for="mikrofon">Mikrofon</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" @if ($application->applicationVc->speaker == '1') checked  @endif disabled>
                                                    <label class="custom-control-label position-static" for="speaker1">Speaker</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                                            <div class="col-md-9">
                                                <textarea rows="3" cols="3" class="form-control" name="catatan_vc" readonly>{{ $application->applicationVc->catatan }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                @else
                                    <span class="text-danger text-center">Tiada permohonan VC</span>
                                @endif

                            </div>
                        </fieldset> --}}
                        @else
                            <div class="text-center text-danger">-Tiada Permohonan VC-</div>
                        @endif
                    </div>
                </div>
            </form>

            <?php
            $tag = session()->get('tag');
            ?>

            @if ($tag == '1')
                <form class="batal" action="/application/edit/{{ $application->id }}" method="POST">
                    {{ csrf_field() }}

                    <div class="card-footer text-center">
                        @if (!empty($application->applicationRoom))
                            @if (!empty($application->applicationVc))
                                {{-- Room & VC --}}
                                @if ($application->applicationRoom->status_room_id == '1')
                                    <a href="/application/edit/{{ $application->id }}"><button type="button"
                                            class="btn btn-primary btn-sm">Kemaskini Permohonan</button></a>

                                    @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2')
                                        <button type="button" name="button" data-toggle="modal" title="Batal"
                                            data-target="#modalBatal_room_vc" class="btn btn-warning btn-sm">Batal
                                            Permohonan (RV)</button>
                                    @else
                                        <button type="submit" name="button" value="batal_room"
                                            class="btn btn-danger btn-sm" title="Pembatalan">Batal Permohonan
                                            (Room)</button>
                                    @endif
                                @elseif($application->applicationRoom->status_room_id == '2' ||
                                    $application->applicationRoom->status_room_id == '14')
                                    @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2')
                                        <button type="button" name="button" data-toggle="modal" title="Mohon_Batal"
                                            data-target="#modalMohonBatal_room_vc"
                                            class="btn btn-warning btn-sm">Permohonan
                                            Pembatalan</button>
                                    @else
                                        <button type="submit" name="button" value="mohon_batal_room"
                                            class="btn btn-warning btn-sm" title="Pembatalan">Permohonan Pembatalan
                                            (Room)</button>
                                    @endif
                                @else
                                    @if ($application->applicationVc->status_vc_id == '2' || $application->applicationVc->status_vc_id == '9')
                                        <button type="submit" name="button" value="batal_vc"
                                            class="btn btn-danger btn-sm" title="Pembatalan VC">Batal Permohonan
                                            (VC)</button>
                                    @endif
                                @endif
                            @else
                                {{-- Room --}}
                                <a href="/application/edit/{{ $application->id }}"><button type="button"
                                        class="btn btn-primary btn-sm">Kemaskini Permohonan</button></a>

                                @if ($application->applicationRoom->status_room_id == '1')
                                    <button type="submit" name="button" value="batal_room"
                                        class="btn btn-danger btn-sm" title="Pembatalan ">Batal Permohonan (Room)</button>
                                @else
                                    <button type="submit" name="button" value="mohon_batal_room"
                                        class="btn btn-warning btn-sm" title="Pembatalan ">Permohonan Pembatalan
                                        (Room)</button>
                                @endif
                            @endif
                        @else
                            <a href="/application/edit/{{ $application->id }}"><button type="button"
                                    class="btn btn-primary btn-sm">Kemaskini Permohonan</button></a>

                            <button type="submit" name="button" value="batal_vc" class="btn btn-danger btn-sm"
                                title="Pembatalan VC">Batal Permohonan (VC)</button>
                        @endif
                    </div>
                </form>
            @endif

            <!-- modalBatal_room_vc Modal -->
            <div id="modalBatal_room_vc" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h6 class="modal-title">Pembatalan</h6>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        {{-- <form action="/admin/application_room/result/{{ $application->id }}" method="post"> --}}
                        <form action="/application/cancel/{{ $application->id }}" method="post">
                            @csrf
                            <div class="modal-body">

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
                                {{-- <button type="submit" name="button" value="7" class="btn bg-warning">Submit</button> --}}
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
                                {{-- <button type="submit" name="button" value="35" class="btn bg-warning">Submit</button> --}}
                                <button type="submit" name="button" value="mohon_batal"
                                    class="btn bg-warning">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /modalBatal_room_vc Modal -->


            <!-- Basic modal -->
            <div id="modal_default" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>

                        <div class="modal-body">
                            <h6 class="font-weight-semibold">Maklumat Pemohon</h6>
                            {{-- Papar Maklumat Pemohon --}}
                            <div class="card bg-light">

                                {{-- <div id="papar_maklumat_pemohon" class="collapse"> --}}
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
                                                <td class="text-right"><span class="text-default">Jawatan</span>
                                                </td>
                                                <td>Penolong Pegawai Teknologi Maklumat</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><span class="text-default">Bahagian</span>
                                                </td>
                                                <td>Bahagian Pengurusan Maklumat</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><span class="text-default">No.
                                                        Sambungan</span>
                                                </td>
                                                <td>2358</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><span class="text-default">No. Telefon
                                                        Bimbit</span></td>
                                                <td>017-23412000</td>
                                            </tr>

                                        </tbody>
                                    </table>


                                </div>

                            </div>
                            {{-- Borang Urusetia --}}
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /basic modal -->





        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".batal").on("submit", function() {
            return confirm("Adakah anda pasti?");
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
            // var name = {{ $user->name }};
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
