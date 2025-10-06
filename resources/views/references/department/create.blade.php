@extends('layouts.backend_admin')

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/department" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Bahagian</span></a>
    <a href="/department/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Bahagian</span></a>
@endsection

@section('breadcrumb')
    <a href="/status" class="breadcrumb-item">Pengurusan Data Bahagian</a>
    <span class="breadcrumb-item active">Daftar Bahagian</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Daftar Maklumat Bahagian</legend>
        </div>

        <div class="card-body" style="width: 80%; margin-left:-2%">
            <form method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Nama Bahagian<span class="text-danger">*</span> :</label>
                    <div class="col-md-8">
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Keterangan :</label>
                    <div class="col-md-8">
                        <textarea name="keterangan" cols="30" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Status<span class="text-danger">*</span> :</label>
                    <div class="col-md-8">
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="aktif" @if (old('status') == 'aktif') selected @endif>Aktif</option>
                            <option value="tidak aktif" @if (old('status') == 'tidak aktif') selected @endif>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-md-10 text-center">
                        {{-- <a href="/department" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a> --}}
                        <button type="submit" class="btn btn-primary btn-sm"> Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
