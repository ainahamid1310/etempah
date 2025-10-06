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
                <b><i class="icon-user mr-2"></i> {{ __('Paparan Pengguna') }}</b>
            </h6>
        </div>

        <div class="card-body">
            <div class="tab-pane fade show active" id="pendaftaran">
                <br>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <tr class="form-group">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nama :</label>
                            <div class="col-md-4">
                                <input name="name" type="text" placeholder="Contoh : Ahmad bin Adam"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $user->name) }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">No. Kad Pengenalan :</label>
                            <div class="col-md-4">
                                <input name="no_kp" type="text" placeholder="Contoh : 900102142345"
                                    class="form-control @error('no_kp') is-invalid @enderror"
                                    value="{{ old('no_kp', $user->no_kp) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat E-mel :</label>
                            <div class="col-md-4">
                                <input name="email" type="text" placeholder="Contoh : ahmad.adam@miti.gov.my"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>
                            <div class="col-md-8">
                                <select name="position" id="jawatan" data-placeholder="Pilih Jawatan" class="form-control"
                                    disabled>
                                    <option>Pilih Jawatan</option>
                                    @if (!empty($profile))
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                @if (old('position', $profile->position->id) == $position->id) selected @endif>{{ $position->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>
                            <div class="col-md-8">
                                <select name="department" id="department" data-placeholder="Pilih Bahagian"
                                    class="form-control" disabled>
                                    <option>Pilih Bahagian</option>
                                    @if (!empty($profile))
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('department', $profile->department->id) == $department->id) selected @endif>{{ $department->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_extension"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>
                            <div class="col-md-6">
                                @if (!empty($profile))
                                    <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                        class="form-control @error('no_extension') is-invalid @enderror" name="no_extension"
                                        value="{{ old('no_extension', $profile->no_extension) }}" readonly>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>

                            <div class="col-md-6">
                                @if (!empty($profile))
                                    <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                        class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                        value="{{ old('no_bimbit', $profile->no_bimbit) }}" readonly
                                        autocomplete="no_bimbit">
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Minimum 8 aksara (Kombinasi huruf, nombor & simbol)" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" readonly>
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label text-md-right">Peringkat Pengguna</label>
                            <div class="col-sm-6 col-form-label">
                                @if ($user->is_admin == 1)
                                    <label class="badge badge-warning badge-pill" style="font-size: 12px;">Pentadbir</label>
                                @else
                                    <label class="badge badge-danger badge-pill" style="font-size: 12px;">Pengguna</label>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="role" class="col-sm-4 col-form-label text-md-right">Peranan</label>
                            <div class="col-sm-6 col-form-label">
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-primary badge-pill"
                                            style="font-size: 12px;">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label text-md-right">Status</label>
                            <div class="col-sm-6 col-form-label">
                                @if ($user->status == 1)
                                    <label class="badge badge-success badge-pill" style="font-size: 12px;">Aktif</label>
                                @else
                                    <label class="badge badge-danger badge-pill" style="font-size: 12px;">Tidak
                                        Aktif</label>
                                @endif
                            </div>
                        </div>
                    </tr>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <div class="list-icons ml-3">
                                <button class="btn btn-sm bg-secondary" onclick="history.back()" type="button">
                                    Kembali</button>
                                <a class="btn bg-blue-800 btn-sm" href="/user/edit/{{ encrypt($user->id) }}"><i
                                        class="icon-add mr-2"></i> Kemaskini</a>
                                {{-- <a class="btn bg-teal btn-sm" href="/user"><i class="icon-list mr-2"></i> Senarai
                                    Pengguna</a> --}}
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
