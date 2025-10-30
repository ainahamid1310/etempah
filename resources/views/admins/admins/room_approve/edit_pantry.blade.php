@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/admin/application_room/1" class="breadcrumb-item">Rekod Tempahan Bilik</a>
        <span class="breadcrumb-item active"> Paparan Tempahan</span>

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
                <h5>Kemaskini Tempahan (Pantry)</h5>

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
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Perhatian : </span> Bilik ini <b>telah
                                ditempah</b> pada tarikh dan masa yang sama.
                        </div>
                    @endif
                @endif

                {{-- <form class="confirm" action="/admin/application_room/edit_pantry/{{ $application->id }}" method="POST"> --}}
                <form method="post" action="/admin/application_room/edit_pantry/{{ $application->id }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="maklumat_permohonan">

                            <!-- Collapsible with left control button -->
                            <div class="card-group-control card-group-control-left">

                                <div class="card-header">
                                    <h6 class="card-title">
                                        <a data-toggle="collapse" class="text-default" href="#maklumat_mesyuarat">Maklumat
                                            Permohonan</a>
                                    </h6>
                                </div>

                                <div id="maklumat_mesyuarat" class="collapse show">
                                    <div class="card-body">

                                        <div class="card bg-light">

                                            <div id="form_permohonan" class="collapse show">
                                                <div class="card-body">

                                                    <div class="form-group row">
                                                        <label for="id_permohonan"
                                                            class="col-md-3 col-form-label text-md-right"><b>{{ __('ID Permohonan') }}</b></label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="id_permohonan"
                                                                style="font-weight: bold" value="{{ $application->id }}"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="tarikh_mula"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Mula') }}</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="tarikh_mula"
                                                                value="{{ date('d-m-Y h:i A', strtotime($application->tarikh_mula)) }}"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="tarikh_hingga"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Tarikh/Masa Tamat') }}</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="tarikh_hingga"
                                                                value="{{ date('d-m-Y h:i A', strtotime($application->tarikh_hingga)) }}"
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
                                                            <input type="text" class="form-control"
                                                                name="kategori_pengerusi" value="{{ $kategori_pengerusi }}"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    @if ($application->kategori_pengerusi == '0')
                                                        <div class="form-group row">
                                                            <label for="nama_pengerusi"
                                                                class="col-md-3 col-form-label text-md-right">{{ __('Nama Pengerusi') }}</label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" type="text"
                                                                    name="nama_pengerusi" id="pengerusi"
                                                                    value="{{ old('nama_pengerusi', $application->nama_pengerusi) }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="alert alert-warning" role="alert"
                                                        id="alert_bil_tempahan" style="display:none">
                                                        <b>Mesej</b>
                                                        <li>Had maksimum <b>50 pax</b> (TKSU/KSU/YBTM/YBM)</li>
                                                        <li>Had maksimum <b>35 pax</b> (Lain-lain)</li>
                                                        <li>Sekiranya melebihi had maksimum, bahagian perlu membuat
                                                            tempahan katerer
                                                            luar</li>
                                                        <li>Had maksimum dikecualikan bagi Mesyuarat Pengurusan dan
                                                            Mesyuarat
                                                            <i>Post-Cabinet.</i>
                                                        </li>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="bil_tempah"
                                                            class="col-md-3 col-form-label text-md-right text-primary">{{ __('Bil.Tempahan/Kehadiran') }}</label>
                                                        <div class="col-md-9">
                                                            <input id="bil_tempah" type="text" class="form-control"
                                                                name="bilangan_tempahan"
                                                                value="{{ $application->bilangan_tempahan }}">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="card-header">
                                    <h6 class="card-title">
                                        <a class="text-default" data-toggle="collapse"
                                            href="#maklumat_terperinci">Maklumat
                                            Terperinci
                                            Mesyuarat/Program
                                        </a>
                                    </h6>
                                </div>

                                <div id="maklumat_terperinci" class="collapse show">
                                    <div class="card-body">

                                        <div class="card card bg-light">

                                            <?php
                                            if ($application->applicationRoom->kategori_mesyuarat == '1') {
                                                $kategori_mesyuarat = 'Mesyuarat Pengurusan Tertinggi';
                                            } elseif ($application->applicationRoom->kategori_mesyuarat == '2') {
                                                $kategori_mesyuarat = 'Mesyuarat Lain-lain';
                                            }
                                            ?>

                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="kategori_mesyuarat"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            name="kategori_mesyuarat"
                                                            @if ($application->applicationRoom->kategori_mesyuarat == '1') value="Mesyuarat Pengurusan Tertinggi"
                                                @elseif($application->applicationRoom->kategori_mesyuarat == '2')
                                                    value="Mesyuarat Lain-lain" @endif
                                                            readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="penganjur"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="penganjur"
                                                            value="{{ $application->applicationRoom->penganjur }}"
                                                            readonly>

                                                    </div>
                                                </div>

                                                <div id="div_nama_penganjur" style="display: none">
                                                    <div class="form-group row">
                                                        <label for="nama_penganjur"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                name="nama_penganjur"
                                                                value="{{ $application->applicationRoom->nama_penganjur }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if (!empty($application->room->is_upload == 'Y'))
                                                    <div class="form-group row">
                                                        <label for="surat_emel"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                                                        <div class="col-md-9">
                                                            <a href="{{ asset($application->applicationRoom->surat) }}"
                                                                target="_blank"><i class="icon-attachment mr-3"></i></a>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label for="sajian"
                                                        class="col-md-3 col-form-label text-md-right text-primary">{{ __('Sajian') }}</label>
                                                    <div class="col-md-9">
                                                        <select name="sajian" id="sajian"
                                                            data-placeholder="Pilih Sajian"
                                                            onChange="java_script_:sajianSelected(this.options[this.selectedIndex].value)"
                                                            class="form-control select-search">
                                                            <option></option>
                                                            <option value="Tidak Perlu"
                                                                @if (old('sajian', $application->applicationRoom->sajian) == 'Tidak Perlu') selected @endif>Tidak
                                                                Perlu
                                                            </option>
                                                            <option value="Pantri Dalaman"
                                                                @if (old('sajian', $application->applicationRoom->sajian) == 'Pantri Dalaman') selected @endif>Pantri
                                                                Dalaman
                                                            </option>
                                                            <option value="Katerer Luar"
                                                                @if (old('sajian', $application->applicationRoom->sajian) == 'Katerer Luar') selected @endif>Katerer
                                                                Luar
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="div_sajian">
                                                    <div class="form-group row">
                                                        {{-- @if ($application->applicationRoom->sajian == 'Pantri Dalaman') --}}
                                                        <label class="col-md-3 text-md-right text-primary">Pilihan
                                                            Sajian</label>
                                                        <div id="div_minum_pagi">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="minum_pagi" name="minum_pagi" value="1"
                                                                        @if (old('minum_pagi', $application->applicationRoom->minum_pagi) == 1) checked @endif>
                                                                    <label class="custom-control-label position-static"
                                                                        for="minum_pagi">Minum
                                                                        Pagi</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="div_minum_petang">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="minum_petang" name="minum_petang"
                                                                        value="1"
                                                                        @if (old('minum_petang', $application->applicationRoom->minum_petang) == 1) checked @endif>
                                                                    <label class="custom-control-label position-static"
                                                                        for="minum_petang">Minum
                                                                        Petang</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- @endif --}}
                                                        {{-- @if ($application->applicationRoom->sajian == 'Katerer Luar') --}}
                                                        <div id="div_makan_tengahari">
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="makan_tengahari" name="makan_tengahari"
                                                                        value="1"
                                                                        @if (old('makan_tengahari', $application->applicationRoom->makan_tengahari) == 1) checked @endif>
                                                                    <label class="custom-control-label position-static"
                                                                        for="makan_tengahari">Makan
                                                                        Tengahari</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- @endif --}}

                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="catatan"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Pemohon') }}</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room" readonly>{{ $application->applicationRoom->catatan }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="status_room"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                                                    <div class="col-md-9">
                                                        @if ($application->applicationRoom->status_room_id == '1')
                                                            <span
                                                                class="badge badge-primary">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                        @elseif($application->applicationRoom->status_room_id == '2')
                                                            <span
                                                                class="badge badge-success">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                        @elseif($application->applicationRoom->status_room_id == '4')
                                                            <span
                                                                class="badge badge-danger">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-secondary">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <hr>
                                                @if ($application->applicationRoom->status_room_id == '4' ||
                                                    $application->applicationRoom->status_room_id == '13')
                                                    <div class="form-group row">
                                                        <label for="komen_ditolak"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Sebab Ditolak / Dibatalkan') }}</label>
                                                        <div class="col-md-9">
                                                            <textarea rows="2" cols="2" class="form-control" placeholder="Sebab Ditolak" name="komen_ditolak">{{ $application->applicationRoom->komen_ditolak }}</textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="form-group row">
                                                    <label for="created_at"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Permohonan') }}</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="created_at"
                                                            value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->created_at)) }}"
                                                            readonly>
                                                    </div>
                                                </div>

                                                @if ($application->applicationRoom->status_room_id == '2' || $application->applicationRoom->status_room_id == '4')
                                                    <div class="form-group row">
                                                        <label for="tarikh_keputusan"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Keputusan') }}</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                name="tarikh_keputusan"
                                                                value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->tarikh_keputusan)) }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($application->applicationRoom->status_room_id == '13')
                                                    <div class="form-group row">
                                                        <label for="tarikh_batal"
                                                            class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Batal') }}</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                name="tarikh_batal"
                                                                value="{{ date('d-m-Y g:i A', strtotime($application->applicationRoom->tarikh_batal)) }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label for="catatan"
                                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Penyelia') }}</label>
                                                    <div class="col-md-9">
                                                        @if ($application->applicationRoom->status_room_id == '1')
                                                            <textarea rows="3" cols="3" class="form-control" placeholder="Catatan Penyelia Bilik"
                                                                name="catatan_room_penyelia" id="catatan_room_penyelia"></textarea>
                                                        @else
                                                            <textarea rows="3" cols="3" class="form-control" placeholder="Catatan Penyelia Bilik"
                                                                name="catatan_room_penyelia" readonly>{{ $application->applicationRoom->catatan_penyelia }}</textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- </div> --}}

                            </div>
                            <!-- /collapsible with left control button -->

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
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <span class="font-weight-semibold">Perhatian : </span> Bilik ini <b>telah
                                    ditempah</b> pada tarikh dan masa yang sama.
                            </div>
                        @endif
                    @endif
                    {{-- Button --}}
                    <div class="card-footer text-center">
                        <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                            Kembali</button>
                        {{-- <form class="confirm" action="/admin/application_room/edit_pantry/{{ $application->id }}" --}}
                        {{-- method="POST"> --}}
                        {{-- {{ csrf_field() }} --}}
                        {{-- <input type="hidden" name="_method" value="POST"> --}}
                        {{-- <input type="hidden" name="button" value="2"> --}}
                        <button type="submit" class="btn btn-success btn-sm submit-btn">
                            Simpan
                        </button>


                        {{-- </form> --}}
                    </div>
                </form>

                <div id="modal_tolak" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h6 class="modal-title">Alasan Permohonan Ditolak</h6>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <form action="/admin/application_room/result/{{ $application->id }}" method="post">
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
                                        class="btn bg-success">Hantar</button>
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

                            <form action="/admin/application_room/result/{{ $application->id }}" method="post">
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
                                    <button type="submit" name="button" value="13"
                                        class="btn bg-success">Hantar</button>
                                    {{-- <a href="/admin/application_room/result/{{ $application->id }}"><button type="submit" name="button" value="4" class="btn btn-danger btn-sm">Tolak</button></a> --}}
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
                                                    <td class="text-right"><span
                                                            class="text-default">Bahagian/Seksyen</span>
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

        function onLoadFunction() {

            var sajian = document.getElementById("sajian").value;
            sajianSelected(sajian);

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

        // function copy_catatan_room_penyelia_tolak() {

        //     var catatan_room_penyelia_tolak = document.getElementById("catatan_room_penyelia_tolak");
        //     var catatan_room_penyelia = document.getElementById("catatan_room_penyelia");
        //     catatan_room_penyelia_tolak.value = catatan_room_penyelia.value;
        // }

        // function copy_catatan_room_penyelia_batal() {

        //     var catatan_room_penyelia_batal = document.getElementById("catatan_room_penyelia_batal");
        //     var catatan_room_penyelia = document.getElementById("catatan_room_penyelia");
        //     catatan_room_penyelia_batal.value = catatan_room_penyelia.value;
        // }
    </script>
@endsection
