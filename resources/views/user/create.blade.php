@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/user" class="breadcrumb-item"> Pengurusan Pengguna</a>
        <span class="breadcrumb-item active">Tambah Pengguna</span>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-light">
            <h6 class="card-title">
                <b><i class="icon-user mr-2"></i> {{ __('Daftar Pengguna') }}</b>
            </h6>
        </div>
        <div class="card-body">
            <div class="tab-pane fade show active" id="pendaftaran">
                <br>

                <form method="POST" enctype="multipart/form-data">
                    @csrf

                    <tr class="form-group">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nama
                            </label>
                            <div class="col-md-4">
                                <input name="nama" type="text" placeholder="Contoh : Ahmad bin Adam"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">No. Kad Pengenalan </label>
                            <div class="col-md-4">
                                <input name="no_kp" type="text" placeholder="Contoh : 900102142345"
                                    class="form-control @error('no_kp') is-invalid @enderror" value="{{ old('no_kp') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat E-mel</label>
                            <div class="col-md-4">
                                <input name="email" type="text" placeholder="Contoh : ahmad.adam@miti.gov.my"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}
                            </label>
                            <div class="col-md-8">
                                <select name="position" id="jawatan" data-placeholder="Pilih Jawatan"
                                    class="form-control select-search">
                                    <option></option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            @if (old('position') == $position->id) selected @endif>{{ $position->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }} </label>
                            <div class="col-md-8">
                                <select name="department" id="department" data-placeholder="Pilih Bahagian"
                                    class="form-control select-search">
                                    <option></option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            @if (old('department') == $department->id) selected @endif>{{ $department->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_extension"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }} </label>

                            <div class="col-md-6">
                                <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                    class="form-control @error('no_extension') is-invalid @enderror" name="no_extension"
                                    value="{{ old('no_extension') }}">

                                @error('no_extension')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }} </label>

                            <div class="col-md-6">
                                <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                    class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                    value="{{ old('no_bimbit') }}" autocomplete="no_bimbit">

                                @error('no_bimbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan') }}
                            </label>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="12 aksara (huruf, nombor atau simbol)"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Ulang Katalaluan') }}
                            </label>

                            <div class="col-md-6">
                                <input id="rpassword" type="password" placeholder=""
                                    class="form-control @error('rpassword') is-invalid @enderror" name="rpassword"
                                    value="{{ old('rpassword') }}" autocomplete="rpassword">

                                @error('rpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Peranan') }}
                            </label>
                            <div class="col-lg-4">
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" value="{{ $role->name }}" name="role"
                                                class="form-check-input-styled-custom" data-fouc>
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}
                            </label>
                            <div class="col-lg-4">
                                <select name="status" data-placeholder="Pilih Status" class="form-control select"
                                    data-fouc>
                                    <option></option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </tr>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
