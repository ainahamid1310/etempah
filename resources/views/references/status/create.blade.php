@extends('layouts.admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/switch.min.js"></script>
@endsection

@section('js_extensions')
    <script src="/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
@endsection

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/status" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Status</span></a>
    <a href="/status/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Status</span></a>
@endsection

@section('breadcrumb')
    <a href="/status" class="breadcrumb-item">Pengurusan Data Status</a>
    <span class="breadcrumb-item active">Daftar Status</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Daftar Maklumat Status</legend>
        </div>

        <div class="card-body" style="width: 80%; margin-left: auto; margin-right: auto;">
            <form method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Status Pentadbiran<span class="text-danger">*</span> :</label>
                    <div class="col-md-4">
                        <input name="status_pentadbiran" type="text" class="form-control" value="{{ old('status_pentadbiran') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Status Pemohon<span class="text-danger">*</span> :</label>
                    <div class="col-md-4">
                        <input name="status_pemohon" type="text" class="form-control" value="{{ old('status_pemohon') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Jenis Pelantikan :</label>
                    <div class="col-md-4">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" name="cos" class="form-check-input" @if (old('cos') == '1') checked @endif value="1">
                                CoS
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" name="psh" class="form-check-input" @if (old('psh') == '1') checked @endif value="1">
                                PSH
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" name="pli" class="form-check-input" @if (old('pli') == '1') checked @endif value="1">
                                PLI
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Keterangan :</label>
                    <div class="col-md-4">
                        <textarea name="keterangan" id="" cols="30" rows="10" class="form-control">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-md-10 text-md-right">
                        <a href="/status" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk mr-2"></i> Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
