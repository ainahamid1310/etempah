@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/user" class="breadcrumb-item"> Pengurusan Pengguna</a>
        <span class="breadcrumb-item active">Papar Pengguna</span>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header bg-light">
            <h6 class="card-title">
                <b><i class="icon-user mr-2"></i> {{ __('Kemaskini Pengguna') }}</b>
            </h6>
        </div>
        <div class="card-body">

            <div class="tab-pane fade show active" id="pendaftaran">
                <br>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <tr class="form-group">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nama <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-4">
                                <input name="nama" type="text" placeholder="Contoh : Ahmad bin Adam"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">No. Kad Pengenalan <span
                                    class="text-danger"></span> </label>
                            <div class="col-md-4">
                                <input name="no_kp" type="text" placeholder="Contoh : 900102142345"
                                    class="form-control" value="{{ $user->no_kp }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat E-mel <span
                                    class="text-danger">*</span> </label>
                            <div class="col-md-4">
                                <input name="email" type="text" placeholder="Contoh : ahmad.adam@miti.gov.my"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }} <span
                                    class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <select name="position" id="jawatan" data-placeholder="Pilih Jawatan"
                                    class="form-control select-search">
                                    <option></option>
                                    @if (!empty($profile))
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                @if (old('position', $profile->position_id) == $position->id) selected @endif>{{ $position->nama }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                @if (old('position') == $position->id) selected @endif>{{ $position->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="department" id="department" data-placeholder="Pilih Bahagian"
                                    class="form-control select-search">
                                    @if (!empty($profile))
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('department', $profile->department_id) == $department->id) selected @endif>{{ $department->nama }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('department') == $department->id) selected @endif>{{ $department->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_extension"
                                class="col-md-4 col-form-label text-md-right">{{ __('No. Sambungan') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                @if (!empty($profile))
                                    <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                        class="form-control @error('no_extension') is-invalid @enderror" name="no_extension"
                                        value="{{ old('no_extension', $profile->no_extension) }}" required
                                        autocomplete="no_extension">
                                @else
                                    <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                        class="form-control @error('no_extension') is-invalid @enderror" name="no_extension"
                                        value="{{ old('no_extension') }}" required autocomplete="no_extension">
                                @endif

                                @error('no_extension')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit"
                                class="col-md-4 col-form-label text-md-right">{{ __('No. Telefon Bimbit') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                @if (!empty($profile))
                                    <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                        class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                        value="{{ old('no_bimbit', $profile->no_bimbit) }}" required
                                        autocomplete="no_bimbit">
                                @else
                                    <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                        class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                        value="{{ old('no_bimbit') }}" required autocomplete="no_bimbit">
                                @endif

                                @error('no_bimbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Set Semula Katalaluan') }}</label>

                            <div class="col-md-6">
                                <input id="reset_password" type="password"
                                    placeholder="12 aksara (huruf, nombor atau simbol)"
                                    class="form-control @error('reset_password') is-invalid @enderror"
                                    name="reset_password" value="{{ old('reset_password') }}">

                                @error('reset_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select name="status" data-placeholder="Pilih Status" class="form-control select" data-fouc>
                                        <option></option>
                                        <option value="0" @if ($user->is_admin == 0) selected @endif>Pengguna</option>
                                        <option value="1" @if ($user->is_admin == 1) selected @endif>Pentadbir</option>
                                    </select>
                                </div>
                            </div> --}}

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Peranan') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    @foreach ($roles as $role)
                                        <input type="radio" name="role" class="form-check-input"
                                            value="{{ $role->id }}"
                                            @if ($user->roles->contains($role->id)) checked=checked @endif>
                                        <label class="form-check-label" for="role">{{ $role->name }}</label>
                                        <br />
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select name="status" data-placeholder="Pilih Status" class="form-control select"
                                    data-fouc>
                                    <option></option>
                                    <option value="1" @if ($user->status == '1') selected @endif>Aktif
                                    </option>
                                    <option value="0" @if ($user->status == '0') selected @endif>Tidak Aktif
                                    </option>
                                </select>
                            </div>
                        </div>
                    </tr>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <div class="list-icons ml-3">
                                <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                                    Kembali</button>
                                <button type="submit" class="btn bg-blue-800 btn-sm"><i class="icon-add mr-2"></i>
                                    Simpan</button>
                                {{-- <a class="btn bg-teal btn-sm" href="/user"><i class="icon-list mr-2"></i> Senarai
                                    Pengguna</a> --}}
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    </div>

@endsection
