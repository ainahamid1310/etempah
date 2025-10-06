@extends('layouts.admin')

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/role" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Peranan</span></a>
    <a href="/role/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Peranan</span></a>
@endsection

@section('breadcrumb')
    <a href="/role" class="breadcrumb-item">Pengurusan Data Peranan</a>
    <span class="breadcrumb-item active">Sunting Peranan</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Sunting Maklumat Peranan</legend>
        </div>

        <div class="card-body" style="width: 80%; margin-left: auto; margin-right: auto;">
            <form method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Nama Peranan<span class="text-danger">*</span> :</label>
                    <div class="col-md-6">
                        <input name="name" type="text" class="form-control" value="{{ old('name',$role->name) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Keterangan :</label>
                    <div class="col-md-6">
                        <input name="description" type="text" class="form-control" value="{{ old('description',$role->description) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Guard<span class="text-danger">*</span> :</label>
                    <div class="col-md-3">
                        <select name="guard_name" class="form-control" required>
                            <option value="web" @if (old('guard_name',$role->guard_name) == 'web') selected @endif>web</option>
                            <option value="api" @if (old('guard_name',$role->guard_name) == 'api') selected @endif>api</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Status<span class="text-danger">*</span> :</label>
                    <div class="col-md-3">
                        <select name="status" class="form-control" required>
                            <option value="1" @if (old('status',$role->status) == '1') selected @endif>Aktif</option>
                            <option value="0" @if (old('status',$role->status) == '0') selected @endif>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-md-10 text-md-right">
                        <a href="/role" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a>
                        @if($role->id !=  1)
                            <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk mr-2"></i> Simpan</button>
                        @endif
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection

@section('script')

@endsection
