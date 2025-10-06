@extends('layouts.backend_admin')

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Informasi Umum</span>
@endsection

@section('top_button')
    <a href="/announcement" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai
            Informasi Umum</span></a>
    <a href="/announcement/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i>
        <span>Tambah Informasi Umum</span></a>
@endsection

@section('breadcrumb')
    @role('approver-room')
        <a href="/announcement?i=room" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Informasi Umum</a>
    @endrole
    @role('approver-vc')
        <a href="/announcement?i=vc" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Informasi Umum</a>
    @endrole
    <span class="breadcrumb-item active">Tambah Informasi Umum</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Tambah Informasi Umum</legend>
        </div>

        <div class="card-body" style="width: 80%; margin-left:-2%">
            <form method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Nama Informasi<span class="text-danger">*</span>
                        :</label>
                    <div class="col-md-8">
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Keterangan :</label>
                    <div class="col-md-8">
                        <textarea name="keterangan" cols="30" rows="3"
                            class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Kategori<span class="text-danger">*</span>
                        :</label>
                    <div class="col-md-8">
                        <select name="kategori" class="form-control select-search @error('kategori') is-invalid @enderror">
                            @role('super-admin|approver-room')
                                <option value="Bilik" @if (old('kategori') == 'Bilik') selected @endif>Bilik</option>
                            @endrole
                            @role('super-admin|approver-vc')
                                <option value="VC" @if (old('kategori') == 'VC') selected @endif>VC</option>
                            @endrole
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Status<span class="text-danger">*</span> :</label>
                    <div class="col-md-8">
                        <select name="status" class="form-control select-search @error('status') is-invalid @enderror">
                            <option value="aktif" @if (old('status') == 'aktif') selected @endif>Aktif</option>
                            <option value="tidak aktif" @if (old('status') == 'tidak aktif') selected @endif>Tidak Aktif
                            </option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-md-10 text-center">
                        <button type="submit" class="btn btn-primary btn-sm"> Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
