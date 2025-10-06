<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MITI - eTempah</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/global_assets/js/main/jquery.min.js"></script>
    <script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="assets/js/app.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>


    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">
        <div class="navbar-brand">
            <i class="icon-calendar2 mr-3 icon-2x"></i>
            <span>eTempah</span>
        </div>

        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">

            <ul class="navbar-nav ml-md-auto">

                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        Semakan Permohonan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        Informasi Umum
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        Hubungi Kami
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        {{-- <i class="icon-switch2"></i> --}}
                        {{-- <span class="d-md-none ml-2">Logout</span> --}}
                        {{-- @if (Route::has('login'))
                            <div class="top-right links">
                                @auth
                                    <a href="{{ url('/home') }}">Home</a>
                                @else
                                    <a href="{{ route('login') }}">Login</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif --}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

    <div class="card-group mb-sm-3">
        <div class="card shadow-0 bg-light">
            <br><br><br>
            <h1 class="text-center"><b>Sistem Tempahan Bilik dan VC</b></h1>
            <img src="{{ asset('/images/main.jpg') }}" width="700" height="440" />
        </div>

        <div class="card bg-light">
            <div class="content d-flex justify-content-center align-items-center">


                <div class="card-body">

                    <div class="text-center mb-3">
                        <img src="{{ asset('/images/jata.png') }}" width="100" height="80" />
                    </div>

                    <div class="text-center"><b>KEMENTERIAN PELABURAN, PERDAGANGAN DAN INDUSTRI</b></div>
                    <h6 class="mb-0 text-center bg-primary">Daftar Akaun Baru</h6>
                    <br>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nama Penuh') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="No. Kad Pengenalan"
                                class="col-md-4 col-form-label text-md-right">{{ __('No. Kad Pengenalan') }}</label>

                            <div class="col-md-6">
                                <input id="no_kp" type="text" class="form-control @error('no_kp') is-invalid @enderror"
                                    name="no_kp" value="{{ old('no_kp') }}" autocomplete="no_kp" autofocus>

                                @error('no_kp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Alamat E-mel') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Kata Laluan') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Ulang Kata Laluan') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bahagian"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>

                            <div class="col-md-6">
                                <select name="bahagian" data-placeholder="Pilih Bahagian/Seksyen"
                                    class="form-control select" data-fouc>
                                    <option></option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->nama }}</option>
                                    @endforeach

                                </select>

                                @error('bahagian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jawatan"
                                class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>
                            <div class="col-md-6">
                                <select name="jawatan" data-placeholder="Pilih Jawatan" class="form-control select"
                                    data-fouc>
                                    <option></option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">
                                            {{ $position->nama }}
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
                                    value="{{ old('no_extension') }}" required>

                                @error('no_extension')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_bimbit"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="no_bimbit" type="text" placeholder="Contoh : 010-2361231"
                                    class="form-control @error('no_bimbit') is-invalid @enderror" name="no_bimbit"
                                    value="{{ old('no_bimbit') }}" required autocomplete="no_bimbit">

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
                                    {{ __('Daftar') }}
                                </button>
                                <a href="/"><button type="button" class="btn btn-success">
                                        {{ __('Log Masuk') }}
                                    </button></a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <div class="text-center">
        © Kementerian Pelaburan, Perdagangan dan Industri 2022
    </div>
</body>

</html>
