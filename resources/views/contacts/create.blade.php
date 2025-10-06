@extends('layouts.backend_admin')

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/contact" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai
            Hubungi Kami</span></a>
    <a href="/contact/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i>
        <span>Daftar Hubungi Kami</span></a>
@endsection

@section('breadcrumb')
    <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
    <a href="/contact" class="breadcrumb-item">Hubungi Kami</a>
    <span class="breadcrumb-item active">Daftar Hubungi Kami</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Daftar Maklumat Hubungi Kami</legend>
        </div>

        <div class="card-body" style="width: 80%; margin-left:-2%">
            <form method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Nama<span class="text-danger">*</span> :</label>
                    <div class="col-md-8">
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">E-mel<span class="text-danger">*</span>
                        :</label>
                    <div class="col-md-8">
                        <input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">No. Telefon <span class="text-danger">*</span>
                        :</label>
                    <div class="col-md-8">
                        <input name="no_telefon_office" type="text"
                            class="form-control @error('no_telefon_office') is-invalid @enderror"
                            value="{{ old('no_telefon_office') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Peranan<span class="text-danger">*</span>
                        :</label>
                    <div class="col-md-8 is-invalid">
                        <select name="peranan" data-placeholder="Pilih Peranan"
                            class="form-control select-search @error('peranan') is-invalid @enderror">
                            <option></option>
                            @role('super-admin|approver-room')
                                <option value="Pentadbir Bilik" @if (old('peranan') == '1') selected @endif>Pentadbir
                                    Bilik
                                </option>

                                <option value="Teknikal Sistem" @if (old('peranan') == '3') selected @endif>Teknikal
                                    Sistem
                                </option>
                                <option value="PMSB" @if (old('peranan') == '4') selected @endif>PMSB
                                </option>
                                <option value="BizPoint" @if (old('peranan') == '5') selected @endif>BizPoint
                                </option>
                            @endrole
                            @role('super-admin|approver-vc')
                                <option value="Pentadbir VC" @if (old('peranan') == '2') selected @endif>Pentadbir VC
                                </option>
                            @endrole

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Status<span class="text-danger">*</span>
                        :</label>
                    <div class="col-md-8">
                        <select name="status" data-placeholder="Pilih Status"
                            class="form-control select-search @error('status') is-invalid @enderror">
                            <option></option>
                            <option value="aktif" @if (old('status') == 'aktif') selected @endif>Aktif</option>
                            <option value="tidak aktif" @if (old('status') == 'tidak aktif') selected @endif>Tidak Aktif
                            </option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-md-10 text-center">
                        <a href="/contact" class="btn btn-secondary btn-sm"> Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm"> Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
