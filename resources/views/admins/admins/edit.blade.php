@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/admin" class="breadcrumb-item"> Pengurusan Pentadbir</a>
        <span class="breadcrumb-item active">Papar Pentadbir</span>
    </div>
@endsection

@section('content')

    <div class="card">

        <div class="card-body">
            <!-- Collapsible group -->
            <div class="mb-3 pt-2">
                <h6 class="mb-0 font-weight-semibold">
                    <b>{{ __('Paparan Pentadbir') }}</b>
                </h6>
                <span class="text-muted d-block">Kemaskini bilik mengikut pelulus</span>
            </div>

            <div>
                <div class="card mb-0 rounded-bottom-0">
                    <div class="card-header">
                        <h6 class="card-title">
                            <a style="color: blue" data-toggle="collapse" class="text-default"
                                href="#collapsible-item-group1"><i class="icon-user-tie mr-2"></i> Paparan Pentadbir :
                                <b>{{ $user->name }}</b></a>
                        </h6>
                    </div>

                    <div id="collapsible-item-group1" class="collapse">
                        <div class="card-body">

                            <div class="tab-pane fade show active" id="pendaftaran">
                                <br>
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
                                            <input name="email" type="text"
                                                placeholder="Contoh : ahmad.adam@miti.gov.my"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="position"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>
                                        <div class="col-md-8">
                                            <select name="position" id="jawatan" data-placeholder="Pilih Jawatan"
                                                class="form-control" disabled>
                                                <option>Pilih Jawatan</option>
                                                @if (!empty($user->profile))
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}"
                                                            @if (old('position', $user->profile->position->id) == $position->id) selected @endif>
                                                            {{ $position->nama }}</option>
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
                                                @if (!empty($user->profile))
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            @if (old('department', $user->profile->department->id) == $department->id) selected @endif>
                                                            {{ $department->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="no_extension"
                                            class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>
                                        <div class="col-md-6">
                                            @if (!empty($user->profile))
                                                <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                                    class="form-control @error('no_extension') is-invalid @enderror"
                                                    name="no_extension"
                                                    value="{{ old('no_extension', $user->profile->no_extension) }}"
                                                    readonly>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="no_bimbit"
                                            class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>

                                        <div class="col-md-6">
                                            @if (!empty($user->profile))
                                                <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                                    class="form-control @error('no_bimbit') is-invalid @enderror"
                                                    name="no_bimbit"
                                                    value="{{ old('no_bimbit', $user->profile->no_bimbit) }}" readonly
                                                    autocomplete="no_bimbit">
                                            @endif
                                        </div>
                                    </div>

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
                                                <label class="badge badge-success badge-pill"
                                                    style="font-size: 12px;">Aktif</label>
                                            @else
                                                <label class="badge badge-danger badge-pill"
                                                    style="font-size: 12px;">Tidak Aktif</label>
                                            @endif
                                        </div>
                                    </div>
                                </tr>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="card mb-0 rounded-0 border-y-0">
                    <div class="card-header">
                        <h6 class="card-title">
                            <a style="color: blue" class="collapsed text-default" data-toggle="collapse"
                                href="#collapsible-item-group2"><i class="icon-pencil5 mr-2"></i> Tugasan Bilik</a>
                        </h6>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="collapsible-item-group2" class="collapse show active">
                            <div class="card-body">
                                <p class="mb-2">

                                    <select name="rooms[]" data-placeholder="Pilih Bilik" multiple="multiple"
                                        class="form-control select-access-multiple-open select-access-multiple-clear"
                                        data-fouc>
                                        {{-- <select name="supervisors[]" data-placeholder="Pilih Pelulus" multiple="multiple" class="form-control select-access-multiple-open select-access-multiple-clear" data-fouc> --}}
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                @if (old('rooms', in_array($room->id, $supervisorsRooms)) == $room->id) selected @endif>
                                                {{ $room->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn bg-pink-400 access-multiple-clear btn-sm">Padam
                                        Semua</button>
                                    <button type="button" class="btn bg-teal-400 access-multiple-open btn-sm">Pilih
                                        Bilik</button>
                                </p>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="<?php echo url()->previous(); ?>"><button type="button" class="btn btn-secondary">Kembali <i
                                        class="icon-backward2 ml-2"></i></button></a>
                            <button type="submit" class="btn btn-success">Simpan <i
                                    class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>

                {{-- <div class="card rounded-top-0">
                <div class="card-header">
                    <h6 class="card-title">
                        <a class="collapsed text-default" data-toggle="collapse" href="#collapsible-item-group3">Collapsible Item #3</a>
                    </h6>
                </div>

                <div id="collapsible-item-group3" class="collapse">
                    <div class="card-body">
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it.
                    </div>
                </div>
            </div> --}}
            </div>
            <!-- /collapsible group -->

        </div>
    </div>

@endsection
