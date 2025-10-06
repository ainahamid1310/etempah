@extends('layouts.backend_admin')

<style>
    form label {
        font-weight: bold
    }
</style>


@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home/select/1" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/reference/room" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Pengurusan Bilik > Profil Bilik
            Mesyuarat</a>
        <span class="breadcrumb-item active"> Tambah Profil Bilik</span>
    </div>
@endsection

@section('content')

    <body onload="onLoadFunction()">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Tambah Profil Bilik</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
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
                                    <input type="text" name="nama_bilik" value="{{ old('nama_bilik') }}"
                                        class="form-control" placeholder="Contoh : Bilik Dahlia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama Bilik Panjang:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="nama_bilik_panjang" value="{{ old('nama_bilik_panjang') }}"
                                        class="form-control" placeholder="Contoh : Bilik Mesyuarat Dahlia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama Petugas:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="nama_petugas" value="{{ old('nama_petugas') }}"
                                        class="form-control" placeholder="Contoh : Ahmad bin Osman">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">No. Telefon Petugas:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="no_tel_petugas" value="{{ old('no_tel_petugas') }}"
                                        class="form-control" placeholder="Contoh : 017-2003008">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Bahagian:</label>
                                <div class="col-lg-9">
                                    <select name="department" value="{{ old('department') }}"
                                        data-placeholder="Pilih Bahagian" class="form-control select-search" data-fouc>
                                        <option value="">Pilih Bahagian</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('department') == $department->id) selected @endif>{{ $department->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Aras:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="aras" value="{{ old('aras') }}" class="form-control"
                                        placeholder="Contoh : 19">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Kapasiti:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="kapasiti" value="{{ old('kapasiti') }}" class="form-control"
                                        placeholder="Contoh : 25"> Orang
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Peralatan VC:</label>
                                <div class="col-lg-9">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="is_equipment" value="Y"
                                                class="form-input-styled" @if (old('is_equipment') == 'Y') checked @endif>
                                            Ada
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="is_equipment" value="N"
                                                class="form-input-styled" @if (old('is_equipment') == 'N') checked @endif>
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
                                            <input type="radio" name="is_projector" value="Y"
                                                class="form-input-styled" @if (old('is_projector') == 'Y') checked @endif>
                                            Ada
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="is_projector" value="N"
                                                class="form-input-styled" @if (old('is_projector') == 'N') checked @endif>
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
                                            <input type="radio" name="is_upload" value="Y"
                                                class="form-input-styled" @if (old('is_upload') == 'Y') checked @endif>
                                            Ya
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="is_upload" value="N"
                                                class="form-input-styled" @if (old('is_upload') == 'N') checked @endif>
                                            Tidak
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Keterangan:</label>
                                <div class="col-lg-9">
                                    <textarea name="keterangan" rows="2" cols="2" class="form-control"
                                        placeholder="Masukkan keterangan tambahan">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Status:</label>
                                <div class="col-lg-9">
                                    <select name="status" data-placeholder="Pilih Status"
                                        class="form-control select-search" data-fouc>
                                        <option value="">Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Permohonan Tempahan Bilik Melalui Sistem
                                    eTempah :</label>
                                <div class="col-lg-9">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="is_auto" id="is_auto" value="Y"
                                                class="form-input-styled" @if (old('is_auto') == 'Y') checked @endif
                                                onclick="showPenyelia()">
                                            Ya
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="is_auto" id="is_auto" value="N"
                                                class="form-input-styled" @if (old('is_auto') == 'N') checked @endif
                                                onclick="showPenyelia()">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>

                    <fieldset id="show_penyelia_selection" style="display:none">

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Permohonan Sajian :</label>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_pantry" value="Y" class="form-input-styled"
                                            @if (old('is_pantry') == 'Y') checked @endif>
                                        Ya
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="is_pantry" value="N" class="form-input-styled"
                                            @if (old('is_pantry') == 'N') checked @endif>
                                        Tidak
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Bahagian Pemohon Bilik :</label>
                            <select name="departments[]" class="form-control listbox" multiple="multiple" data-fouc>

                                @foreach ($departments as $department)
                                    @if (old('departments'))
                                        <option value="{{ $department->id }}"
                                            {{ in_array($department->id, old('departments')) ? 'selected' : '' }}>
                                            {{ $department->nama }}</option>
                                    @else
                                        <option value="{{ $department->id }}"
                                            {{ old('departments') == $department->id ? 'selected' : '' }}>
                                            {{ $department->nama }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Status Penghantaran E-mel Notifikasi:</label>
                            <div class="col-lg-9">
                                <select name="email_status" data-placeholder="Pilih Status E-mel"
                                    class="form-control select-search" data-fouc>
                                    <option value="">Pilih Status Penghantaran E-mel Notifikasi</option>
                                    <option value="Y" @if (old('email_status') == 'Y') selected @endif>Ya</option>
                                    <option value="N" @if (old('email_status') == 'N') selected @endif>Tidak
                                    </option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class="icon-gear mr-2"></i>
                            <b>Set Permohonan Tempahan Bilik Melalui Sistem eTempah</b>
                        </legend>

                        <div class="collapse show" id="demo2">
                            <p><b>Nama Pelulus Bilik</b></p>
                            <p class="mb-2">
                                <select name="supervisors[]" data-placeholder="Pilih Pelulus" multiple="multiple"
                                    class="form-control select-access-multiple-open select-access-multiple-clear"
                                    data-fouc>
                                    @foreach ($supervisors as $supervisor)
                                        @if (old('supervisors'))
                                            <option value="{{ $supervisor->id }}"
                                                {{ in_array($supervisor->id, old('supervisors')) ? 'selected' : '' }}>
                                                {{ $supervisor->name }}</option>
                                        @else
                                            <option value="{{ $supervisor->id }}"
                                                {{ old('supervisors') == $supervisor->id ? 'selected' : '' }}>
                                                {{ $supervisor->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </p>

                            <button type="button" class="btn bg-pink-400 access-multiple-clear btn-sm">Padam
                                Semua</button>
                            <button type="button" class="btn bg-teal-400 access-multiple-open btn-sm">Pilih
                                Pelulus</button>

                        </div>

                    </fieldset>

                    <div class="text-center">
                        <a href="<?php echo url()->previous(); ?>"><button type="button" class="btn btn-secondary">Kembali <i
                                    class="icon-backward2 ml-2"></i></button></a>
                        <button type="submit" class="btn btn-primary">Simpan <i
                                class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection

@section('script')
    <script>
        function onLoadFunction() {
            showPenyelia()
        }

        function showPenyelia() {
            var is_auto = document.getElementById('is_auto');

            if (is_auto.checked == true) {
                document.getElementById('show_penyelia_selection').style.display = 'block';
            } else {
                document.getElementById('show_penyelia_selection').style.display = 'none';
            }
        }
    </script>
@endsection
