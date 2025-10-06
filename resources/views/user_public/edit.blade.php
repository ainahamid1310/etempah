@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        @role('super-admin')
            <a href="/user" class="breadcrumb-item"> Pengurusan Pengguna</a>
        @endrole
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
                            <label class="col-md-4 col-form-label text-md-right">Nama <span class="text-danger">*</span>
                                :</label>
                            <div class="col-md-4">
                                <input name="name" type="text" placeholder="Contoh : Ahmad bin Adam"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $user->name) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">No. Kad Pengenalan <span
                                    class="text-danger">*</span> :</label>
                            <div class="col-md-4">
                                <input name="no_kp" type="text" placeholder="Contoh : 900102142345"
                                    class="form-control @error('no_kp') is-invalid @enderror"
                                    value="{{ old('no_kp', $user->no_kp) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat E-mel <span
                                    class="text-danger">*</span> :</label>
                            <div class="col-md-4">
                                <input name="email" type="text" placeholder="Contoh : ahmad.adam@miti.gov.my"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="position" id="jawatan" data-placeholder="Pilih Jawatan"
                                    class="form-control">
                                    <option>Pilih Jawatan</option>

                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            @if (old('position', $user->profile->position->id) == $position->id) selected @endif>{{ $position->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="department" id="department" data-placeholder="Pilih Bahagian"
                                    class="form-control">
                                    <option>Pilih Bahagian</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            @if (old('department', $user->profile->department->id) == $department->id) selected @endif>{{ $department->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_extension"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                    class="form-control @error('no_extension') is-invalid @enderror" name="no_extension"
                                    value="{{ old('no_extension', $user->profile->no_extension) }}">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">

                                <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                    class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                    value="{{ old('no_bimbit', $user->profile->no_bimbit) }}" autocomplete="no_bimbit">
                            </div>
                        </div>

                    </tr>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <div class="list-icons ml-3">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- Contact form modal -->
    <div id="contactModal" class="modal fade bd-example-modal-lg" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title">Hubungi Kami</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="card card-table table-responsive shadow-0 mb-0">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 25%"><b>Nama</b> </th>
                                    <th style="width: 25%">Email</th>
                                    <th style="width: 10%">No. Telefon</th>

                                </tr>
                            </thead>
                            @foreach ($contacts as $role => $contact_list)
                                <tr>
                                    <th colspan="3"><i class="icon-users2"></i><strong>{{ $role }}<strong>
                                    </th>
                                </tr>
                                @foreach ($contact_list as $contact)
                                    <tr>
                                        <td>{{ $contact->nama }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->no_telefon_office }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-primary" data-dismiss="modal">Tutup</button>

                </div>
            </div>
        </div>
    </div>
    <!-- /Contact form modal -->
@endsection
