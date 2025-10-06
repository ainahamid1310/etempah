@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home/select/1" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/reference/room" class="breadcrumb-item">Pengurusan Bilik > Profil Bilik
            Mesyuarat</a>
        <span class="breadcrumb-item active"> Papar Profil Bilik</span>
    </div>
@endsection


@section('content')
    <!-- Advanced legend -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Papar Profil Bilik</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="#">
                <fieldset>
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-file-text2 mr-2"></i>
                        <b>Maklumat Bilik</b>
                        <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </legend>

                    <div class="collapse show" id="demo1">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nama Bilik:</label>
                            <div class="col-lg-9">
                                <input type="text" name="nama_bilik" value="{{ $room->nama }}" class="form-control"
                                    readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nama Bilik Panjang:</label>
                            <div class="col-lg-9">
                                <input type="text" name="nama_bilik_panjang" value="{{ $room->nama_panjang }}"
                                    class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nama Petugas:</label>
                            <div class="col-lg-9">
                                <input type="text" value="{{ $room->nama_petugas }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">No. Telefon Petugas:</label>
                            <div class="col-lg-9">
                                <input type="text" value="{{ $room->no_tel_petugas }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Bahagian:</label>
                            <div class="col-lg-9">
                                <input type="text" value="{{ $room->department->nama }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Aras:</label>
                            <div class="col-lg-9">
                                <input type="text" value="{{ $room->aras }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Kapasiti:</label>
                            <div class="col-lg-3">
                                <input type="text" value="{{ $room->kapasiti }}" class="form-control" readonly>
                                Orang
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Peralatan VC:</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_equipment" class="form-input-styled"
                                            @if ($room->is_equipment == 'Y') checked @endif disabled>
                                        Ada
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_equipment" class="form-input-styled"
                                            @if ($room->is_equipment == 'N') checked @endif disabled>
                                        Tiada
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Projektor:</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_projector" class="form-input-styled"
                                            @if ($room->is_projector == 'Y') checked @endif disabled>
                                        Ada
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_projector" class="form-input-styled"
                                            @if ($room->is_projector == 'N') checked @endif disabled>
                                        Tiada
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Keperluan Lampiran:</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_upload" class="form-input-styled"
                                            @if ($room->is_upload == 'Y') checked @endif disabled>
                                        Ada
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_upload" class="form-input-styled"
                                            @if ($room->is_upload == 'N') checked @endif disabled>
                                        Tiada
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-9">
                                <textarea rows="2" cols="2" class="form-control" placeholder="Masukkan keterangan tambahan di sini"
                                    readonly>{{ $room->keterangan }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Status:</label>
                            <div class="col-lg-9">
                                @if ($room->status == '1')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($room->status == '0')
                                    <span class="badge badge-warning">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Permohonan bilik melalui Sistem eTempah :</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_auto" class="form-input-styled"
                                            @if ($room->is_auto == 'Y') checked @endif disabled>
                                        Ya
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_auto" class="form-input-styled"
                                            @if ($room->is_auto == 'N') checked @endif disabled>
                                        Tidak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_auto" class="form-input-styled"
                                            @if ($room->is_auto == 'S') checked @endif disabled>
                                        Bilik Sendiri
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </fieldset>

                @if ($room->is_auto == 'Y')
                    <fieldset>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Permohonan Sajian :</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_pantry" class="form-input-styled"
                                            @if ($room->is_pantry == 'Y') checked @endif disabled>
                                        Ada
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_pantry" class="form-input-styled"
                                            @if ($room->is_pantry == 'N') checked @endif disabled>
                                        Tiada
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p>Bahagian Pemohon Bilik :</p>
                        <p class="mb-2">
                            <select name="departments[]" data-placeholder="Pilih Bahagian" multiple="multiple"
                                class="form-control select-access-multiple-open select-access-multiple-clear" disabled
                                data-fouc>
                                @forelse ($room->departments as $department)
                                    <option value="{{ $department->id }}"
                                        @if (old('departments', $department->id) == $department->id) selected @endif
                                        style="background-color: #00ff00;">{{ $department->nama }}</option>
                                @empty
                                    <option>Tiada Bahagian</option>
                                @endforelse
                            </select>
                        </p>

                        {{-- <button type="button" class="btn bg-teal-400 access-multiple-open btn-sm">Papar Pelulus</button> --}}


                        {{-- </fieldset> --}}

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Status Penghantaran E-mel Notifikasi:</label>
                            <div class="col-lg-9">
                                @if ($room->email_status == 'Y')
                                    <span class="badge badge-success">Ya</span>
                                @elseif($room->email_status == 'N')
                                    <span class="badge badge-warning">Tidak</span>
                                @elseif($room->email_status == 'U')
                                    <span class="badge badge-warning">Tidak Berkenaan</span>
                                @endif
                            </div>
                        </div>


                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class="icon-gear mr-2"></i>
                            <b><b>Set Permohonan Tempahan Bilik Melalui Sistem eTempah</b></b>
                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo2">
                                <i class="icon-circle-down2"></i>
                            </a>
                        </legend>

                        <div class="collapse show" id="demo2">
                            <p>Nama Pelulus Bilik</p>
                            <p class="mb-2">
                                <select name="supervisors[]" data-placeholder="Pilih Pelulus" multiple="multiple"
                                    class="form-control select-access-multiple-open select-access-multiple-clear" disabled
                                    data-fouc>
                                    @foreach ($room->users as $supervisor)
                                        <option value="{{ $supervisor->id }}"
                                            @if (old('supervisors', $supervisor->id) == $supervisor->id) selected @endif
                                            style="background-color: #00ff00;">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                            </p>

                            {{-- <button type="button" class="btn bg-teal-400 access-multiple-open btn-sm">Papar Pelulus</button> --}}

                        </div>
                    </fieldset>
                @endif

                <div class="text-center">
                    <a href="<?php echo url()->previous(); ?>"><button type="button" class="btn btn-secondary">Kembali <i
                                class="icon-backward2 ml-2"></i></button></a>
                    @role('approver-room|super-admin')
                        <a href="/reference/room/edit/{{ encrypt($room->id) }}"><button type="button"
                                class="btn btn-success">Kemaskini <i class="icon-pencil ml-2"></i></button></a>
                    @endrole
                </div>
            </form>
        </div>
    </div>
    <!-- /a legend -->
@endsection
