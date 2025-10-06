@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active">Paparan Profil Saya</span>
    </div>
@endsection

@section('content')

    <div class="content-wrapper">

        <!-- Content area -->
        <div class="container">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>{{ __('Paparan Profil Saya') }}</b></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-highlight nav-justified mb-0">
                            {{-- <li class="{{ empty($tabName) || $tabName == 'hardware' ? 'active' : '' }}"><a href="#hardware" data-toggle="tab"><strong>Hardware(s)</strong></a></li> --}}
                            <li class="nav-item"><a href="#pendaftaran" class="nav-link active" data-toggle="tab"><i
                                        class="icon-user mr-2"></i>Pendaftaran Pengguna</a></li>
                            {{-- <li class="nav-item"><a href="#profail" class="nav-link" data-toggle="tab"><i
                                        class="icon-vcard mr-2"></i>Maklumat Perincian</a></li> --}}
                            <li class="nav-item"><a href="#set_katalaluan" class="nav-link" data-toggle="tab"><i
                                        class="icon-key mr-2"></i>Set Semula Kata laluan</a></li>
                        </ul>

                        <div class="tab-content card card-body border-top-0 rounded-0 rounded-bottom mb-0">
                            <div class="tab-pane fade show active" id="pendaftaran">
                                <br>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <tr class="form-group">

                                        <div class="form-group row">
                                            <label for="name"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Nama Penuh') }}</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $user->name }}" readonly>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_kp"
                                                class="col-md-4 col-form-label text-md-right">{{ __('No.Kad Pengenalan') }}</label>

                                            <div class="col-md-6">
                                                <input id="no_kp" type="text"
                                                    class="form-control @error('no_kp') is-invalid @enderror" name="no_kp"
                                                    value="{{ $user->no_kp }}" readonly>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="emel"
                                                class="col-md-4 col-form-label text-md-right">{{ __('E-mel') }}</label>

                                            <div class="col-md-6">
                                                <input id="emel" type="text"
                                                    class="form-control @error('emel') is-invalid @enderror" name="emel"
                                                    value="{{ $user->email }}" readonly>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jawatan"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>

                                            <div class="col-md-6">
                                                <select name="jawatan" data-placeholder="Pilih Jawatan"
                                                    class="form-control form-control-select2" disabled data-fouc>
                                                    <option></option>
                                                    @if (!empty($user->profile))
                                                        @foreach ($positions as $position)
                                                            <option value="{{ $position->id }}"
                                                                @if (old('jawatan', $user->profile->position_id) == $position->id) selected @endif>
                                                                {{ $position->nama }}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($positions as $position)
                                                            <option value="{{ $position->id }}"
                                                                @if (old('jawatan') == $position->id) selected @endif>
                                                                {{ $position->nama }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bahagian"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>

                                            <div class="col-md-6">
                                                <select name="bahagian" data-placeholder="Pilih Bahagian"
                                                    class="form-control form-control-select2" disabled data-fouc>
                                                    <option></option>
                                                    @if (!empty($user->profile))
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}"
                                                                @if (old('department', $user->profile->department_id) == $department->id) selected @endif>
                                                                {{ $department->nama }}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}"
                                                                @if (old('department') == $department->id) selected @endif>
                                                                {{ $department->nama }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>


                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_sambungan"
                                                class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>

                                            <div class="col-md-6">
                                                <input id="no_sambungan" type="text"
                                                    class="form-control @error('no_sambungan') is-invalid @enderror"
                                                    name="no_sambungan"
                                                    value="@if (!empty($user->profile)) {{ $user->profile->no_extension }} @endif"
                                                    autocomplete="no_sambungan" readonly>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_bimbit"
                                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>

                                            <div class="col-md-6">
                                                <input id="no_bimbit" type="text"
                                                    class="form-control @error('no_bimbit') is-invalid @enderror"
                                                    name="no_bimbit"
                                                    value="@if (!empty($user->profile)) {{ $user->profile->no_bimbit }} @endif"
                                                    readonly>

                                                @error('no_bimbit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <label for="status"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                                            <td><span class="badge badge-success">Aktif</span></td>
                                        </div>
                                        <div class="text-center">
                                            <a href="/profile/edit/{{ encrypt($user->id) }}?layout=applicant"><button
                                                    type="button" class="btn btn-success btn-sm">Kemaskini</button></a>
                                        </div>
                                    </tr>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="profail">
                                <br><br>
                                {{-- @if (!empty($user->profile)) --}}
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="jawatan"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>

                                        <div class="col-md-6">
                                            <select name="jawatan" data-placeholder="Pilih Jawatan"
                                                class="form-control form-control-select2" disabled data-fouc>
                                                <option></option>
                                                @if (!empty($user->profile))
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}"
                                                            @if (old('jawatan', $user->profile->position_id) == $position->id) selected @endif>
                                                            {{ $position->nama }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}"
                                                            @if (old('jawatan') == $position->id) selected @endif>
                                                            {{ $position->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bahagian"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>

                                        <div class="col-md-6">
                                            <select name="bahagian" data-placeholder="Pilih Bahagian"
                                                class="form-control form-control-select2" disabled data-fouc>
                                                <option></option>
                                                @if (!empty($user->profile))
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (old('department', $user->profile->department_id) == $department->id) selected @endif>
                                                            {{ $department->nama }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (old('department') == $department->id) selected @endif>
                                                            {{ $department->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>


                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="no_sambungan"
                                            class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>

                                        <div class="col-md-6">
                                            <input id="no_sambungan" type="text"
                                                class="form-control @error('no_sambungan') is-invalid @enderror"
                                                name="no_sambungan"
                                                value="@if (!empty($user->profile)) {{ $user->profile->no_extension }} @endif"
                                                autocomplete="no_sambungan" readonly>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="no_bimbit"
                                            class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>

                                        <div class="col-md-6">
                                            <input id="no_bimbit" type="text"
                                                class="form-control @error('no_bimbit') is-invalid @enderror"
                                                name="no_bimbit"
                                                value="@if (!empty($user->profile)) {{ $user->profile->no_bimbit }} @endif"
                                                readonly>

                                            @error('no_bimbit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <a href="/profile/edit/{{ $user->id }}"><button name="viewTab"
                                                value="profail" type="button"
                                                class="btn btn-success btn-sm">Kemaskini</button></a>
                                    </div>
                                </form>
                                {{-- @endif --}}
                            </div>

                            <div class="tab-pane fade" id="profail">
                                <br><br>
                                <form method="POST" action="/profile/edit/{{ Auth::user()->id }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="jawatan"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>

                                        <div class="col-md-6">
                                            <select name="jawatan" data-placeholder="Pilih Jawatan"
                                                class="form-control select-search" data-fouc>
                                                <option></option>
                                                @if (!empty($user->profile))
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}"
                                                            @if (old('jawatan', $user->profile->position_id) == $position->id) selected @endif>
                                                            {{ $position->nama }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}"
                                                            @if (old('jawatan') == $position->id) selected @endif>
                                                            {{ $position->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            @error('jawatan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bahagian"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>

                                        <div class="col-md-6">
                                            <select name="bahagian" data-placeholder="Pilih Bahagian"
                                                class="form-control select-search" data-fouc>
                                                <option></option>
                                                @if (!empty($user->profile))
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (old('department', $user->profile->department_id) == $department->id) selected @endif>
                                                            {{ $department->nama }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (old('department') == $department->id) selected @endif>
                                                            {{ $department->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            @error('bahagian')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="no_sambungan"
                                            class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>

                                        <div class="col-md-6">
                                            @if (!empty($user->profile))
                                                <input id="no_sambungan" type="text"
                                                    class="form-control @error('no_sambungan') is-invalid @enderror"
                                                    name="no_sambungan"
                                                    value="{{ old('no_sambungan', $user->profile->no_extension) }}"
                                                    required>
                                            @else
                                                <input id="no_sambungan" type="text"
                                                    class="form-control @error('no_sambungan') is-invalid @enderror"
                                                    name="no_sambungan" value="{{ old('no_sambungan') }}" required>
                                            @endif
                                            @error('no_sambungan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="no_bimbit"
                                            class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>

                                        <div class="col-md-6">
                                            @if (!empty($user->profile))
                                                <input id="no_bimbit" type="text"
                                                    class="form-control @error('no_bimbit') is-invalid @enderror"
                                                    name="no_bimbit"
                                                    value="{{ old('no_bimbit', $user->profile->no_bimbit) }}" required
                                                    autocomplete="no_bimbit">
                                            @else
                                                <input id="no_bimbit" type="text"
                                                    class="form-control @error('no_bimbit') is-invalid @enderror"
                                                    name="no_bimbit" value="{{ old('no_bimbit') }}" required
                                                    autocomplete="no_bimbit">
                                            @endif
                                            @error('no_bimbit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" name="button" value="profile"
                                            class="btn btn-success btn-sm">Simpan profile</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="set_katalaluan">
                                <br><br>
                                <form method="POST" enctype="multipart/form-data"
                                    action="/user/reset_password/{{ Auth::user()->id }}?layout=applicant">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="password_old"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Kata laluan Lama') }}</label>

                                        <div class="col-md-6">
                                            <input id="password_old" type="password"
                                                class="form-control @error('password_old') is-invalid @enderror"
                                                name="password_old" value="{{ old('password_old') }}"
                                                autocomplete="password_old" autofocus>

                                            @error('password_old')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Kata laluan Baru') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" value="{{ old('password') }}"
                                                placeholder="12 aksara (kombinasi huruf, nombor dan simbol)">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password_confirm"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Ulang Kata laluan Baru') }}</label>

                                        <div class="col-md-6">
                                            <input id="password_confirm" type="password"
                                                class="form-control @error('password-confirm') is-invalid @enderror"
                                                name="password_confirm" value="{{ old('password_confirm') }}"
                                                autocomplete="password_confirm" autofocus>

                                            @error('password_confirm')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Set Semula') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- /content area -->

    </div>
@endsection
