@extends('layouts.backend_admin')

@section('breadcrumb')
<div class="breadcrumb">
    <a href="/home/select/1" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
    <a href="/reference/room" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Pengurusan Bilik > Profail Pentadbir Bilik</a>
    <span class="breadcrumb-item active"> Tambah Pentadbir Bilik</span>
</div>
@endsection

@section('content')

<!-- Advanced legend -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Tambah Pentadbir Bilik</h5>
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
                        <i class="icon-reading mr-2"></i>
                        <b>Maklumat Pentadbir</b>
                        <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </legend>

                    <tr class="form-group">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nama <span class="text-danger">*</span> </label>
                            <div class="col-md-4">
                                <input name="name" type="text" placeholder="Contoh : Ahmad bin Adam" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">No. Kad Pengenalan<span class="text-danger">*</span> </label>
                            <div class="col-md-4">
                                <input name="no_kp" type="text" placeholder="Contoh : 900102142345" class="form-control @error('no_kp') is-invalid @enderror" value="{{ old('no_kp') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat E-mel<span class="text-danger">*</span> </label>
                            <div class="col-md-4">
                                <input name="email" type="text" placeholder="Contoh : ahmad.adam@miti.gov.my" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="position" id="jawatan" data-placeholder="Pilih Jawatan" class="form-control">
                                    <option>Pilih Jawatan</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}" @if(old('position') == $position->id) selected @endif>{{ $position->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="department" id="department" data-placeholder="Pilih Bahagian" class="form-control">
                                    <option>Pilih Bahagian</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @if(old('department') == $department->id) selected @endif>{{ $department->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="no_extension" class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }} <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="no_extension" type="text" placeholder="Contoh : 2378" class="form-control @error('no_extension') is-invalid @enderror" name="no_extension" value="{{ old('no_extension') }}" required>

                                @error('no_extension')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit" class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }} <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231" class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit" value="{{ old('no_bimbit') }}" required autocomplete="no_bimbit">

                                @error('no_bimbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan') }} <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Minimum 8 aksara (Kombinasi huruf, nombor & simbol)" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Peranan') }} <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="{{ $role->name}}" name="role" class="form-check-input-styled-custom" data-fouc>
                                            {{ $role->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }} <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select name="status" data-placeholder="Pilih Status" class="form-control select" data-fouc>
                                    <option></option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        </tr>
                        {{-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div> --}}
                </fieldset>

                <fieldset>
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-file-text2 mr-2"></i>
                        <b>Senarai Bilik</b>
                        <a class="float-right text-default" data-toggle="collapse" data-target="#demo2">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </legend>

                    <div class="collapse show" id="demo2">
                        {{-- <p>Nama Pelulus Bilik</p> --}}
                        <p class="mb-2">
                            <select name="rooms[]" data-placeholder="Pilih Pelulus" multiple="multiple" class="form-control select-access-multiple-open select-access-multiple-clear" data-fouc>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @if(old('rooms') == $room->id) selected @endif>{{ $room->nama }}</option>
                                @endforeach
                            </select>
                        </p>

						<button type="button" class="btn bg-pink-400 access-multiple-clear btn-sm">Padam Semua</button>
                        <button type="button" class="btn bg-teal-400 access-multiple-open btn-sm">Pilih Bilik</button>

                    </div>
                </fieldset>

                <div class="text-center">
                    <a href="<?php echo url()->previous(); ?>"><button type="button" class="btn btn-secondary">Kembali <i class="icon-backward2 ml-2"></i></button></a>
                    <button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /a legend -->
@endsection
