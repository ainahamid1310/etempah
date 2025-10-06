@extends('layouts.backend_applicant')

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
                            <label class="col-md-4 col-form-label text-md-right">Nama
                            </label>
                            <div class="col-md-4">
                                <input name="name" style="color:black" type="text" placeholder="Contoh : Ahmad bin Adam"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">No. Kad Pengenalan </label>
                            <div class="col-md-4">
                                <input name="no_kp" style="color:black" type="text" placeholder="Contoh : 900102142345"
                                    class="form-control @error('no_kp') is-invalid @enderror"
                                    value="{{ old('no_kp', $user->no_kp) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat E-mel </label>
                            <div class="col-md-4">
                                <input name="email" type="text" style="color:black"
                                    placeholder="Contoh : ahmad.adam@miti.gov.my"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}
                            </label>
                            <div class="col-md-8">
                                <select name="position" style="color:black" id="jawatan" data-placeholder="Pilih Jawatan"
                                    class="form-control" disabled>
                                    <option>Pilih Jawatan</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            @if (old('position', $user->profile->position_id) == $position->id) selected @endif>{{ $position->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }} </label>
                            <div class="col-md-8">
                                <select name="department" style="color:black" id="department"
                                    data-placeholder="Pilih Bahagian" class="form-control" disabled>
                                    <option>Pilih Bahagian</option>
                                    @if (!empty($profile))
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('department', $user->profile->department_id) == $department->id) selected @endif>{{ $department->nama }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('department', $user->profile->department_id) == $department->id) selected @endif>{{ $department->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_extension"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }} </label>

                            <div class="col-md-6">

                                <input id="no_extension" style="color:black" type="text" placeholder="Contoh : 2378"
                                    class="form-control @error('no_extension') is-invalid @enderror" name="no_extension"
                                    value="{{ old('no_extension', $user->profile->no_extension) }}"
                                    autocomplete="no_extension" disabled>


                                {{-- @error('no_extension')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }} </label>

                            <div class="col-md-6">
                                <input id="no_bimbit" style="color:black" type="text" placeholder="Contoh : 010-2361231"
                                    class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                    value="{{ old('no_bimbit', $user->profile->no_bimbit) }}" required
                                    autocomplete="no_bimbit" disabled>

                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Set Semula Katalaluan') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    placeholder="Minimum 8 aksara (Kombinasi huruf, nombor & simbol)"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                    </tr>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <div class="list-icons ml-3">
                                <a href="/user_public/edit/{{ $user->id }}"><button type="button"
                                        class="btn bg-success-800 btn-sm">
                                        Kemaskini</button></a>

                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    </div>
@endsection
