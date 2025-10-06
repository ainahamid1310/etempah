@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active">Profail Saya</span>
    </div>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="container">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>{{ __('Profail Saya') }}</b></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-highlight nav-justified mb-0">
                            <li class="nav-item"><a href="#pendaftaran" class="nav-link active" data-toggle="tab"><i
                                        class="icon-user mr-2"></i>Pendaftaran Pengguna</a></li>
                            <li class="nav-item"><a href="#profail" class="nav-link" data-toggle="tab"><i
                                        class="icon-vcard mr-2"></i>Maklumat Perincian</a></li>
                            <li class="nav-item"><a href="#set_katalaluan" class="nav-link" data-toggle="tab"><i
                                        class="icon-key mr-2"></i>Set Semula Katalaluan</a></li>

                        </ul>

                        <div class="tab-content card card-body border-top-0 rounded-0 rounded-bottom mb-0">
                            <div class="tab-pane fade show active" id="pendaftaran">
                                <br>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <tr class="form-group">
                                        <div>
                                            <label for="name"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Nama Penuh') }}</label>
                                            <td><span>Siti Noor Aina Abdul Hamid</span></td>
                                        </div>
                                        <div>
                                            <label for="no_kp"
                                                class="col-md-4 col-form-label text-md-right">{{ __('No.Kad Pengenalan') }}</label>
                                            <td><span>801013146114</span></td>
                                        </div>
                                        <div>
                                            <label for="emel"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Alamat E-mel') }}</label>
                                            <td><span>nooraina@miti.gov.my</span></td>
                                        </div>
                                        <div>
                                            <label for="status"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                                            <td><span class="badge badge-success">Aktif</span></td>
                                        </div>
                                    </tr>


                                </form>

                            </div>

                            <div class="tab-pane fade" id="profail">
                                <br><br>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="nama"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>

                                        <div class="col-md-6">
                                            <input id="jawatan" type="text"
                                                class="form-control @error('jawatan') is-invalid @enderror" name="jawatan"
                                                value="{{ old('jawatan') }}" required autocomplete="jawatan" autofocus>

                                            @error('jawatan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bahagian"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen/Unit') }}</label>

                                        <div class="col-md-6">
                                            <input id="bahagian" type="text"
                                                class="form-control @error('bahagian') is-invalid @enderror" name="bahagian"
                                                value="{{ old('bahagian') }}" required autocomplete="bahagian" autofocus>

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
                                            <input id="no_sambungan" type="text"
                                                class="form-control @error('no_sambungan') is-invalid @enderror"
                                                name="no_sambungan" value="{{ old('no_sambungan') }}" required
                                                autocomplete="no_sambungan">

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
                                            <input id="no_bimbit" type="text"
                                                class="form-control @error('no_bimbit') is-invalid @enderror"
                                                name="no_bimbit" value="{{ old('no_bimbit') }}" required
                                                autocomplete="no_bimbit">

                                            @error('no_bimbit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Kemaskini') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="set_katalaluan">
                                <br><br>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="katalaluan_lama"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan Lama') }}</label>

                                        <div class="col-md-6">
                                            <input id="jawatan" type="text"
                                                class="form-control @error('katalaluan_lama') is-invalid @enderror"
                                                name="katalaluan_lama" value="{{ old('katalaluan_lama') }}" required
                                                autocomplete="katalaluan_lama" autofocus>

                                            @error('katalaluan_lama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="katalaluan_baru"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan Baru') }}</label>

                                        <div class="col-md-6">
                                            <input id="katalaluan_baru" type="text"
                                                class="form-control @error('katalaluan_baru') is-invalid @enderror"
                                                name="katalaluan_baru" value="{{ old('katalaluan_baru') }}" required
                                                autocomplete="katalaluan_baru" autofocus>

                                            @error('katalaluan_baru')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ulang_katalaluan_baru"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Ulang Katalaluan Baru') }}</label>

                                        <div class="col-md-6">
                                            <input id="ulang_katalaluan_baru" type="text"
                                                class="form-control @error('ulang_katalaluan_baru') is-invalid @enderror"
                                                name="ulang_katalaluan_baru" value="{{ old('ulang_katalaluan_baru') }}"
                                                required autocomplete="ulang_katalaluan_baru" autofocus>

                                            @error('ulang_katalaluan_baru')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Kemaskini') }}
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
