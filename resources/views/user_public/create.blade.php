<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MITI - eTempah</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/global_assets/js/main/jquery.min.js"></script>
    <script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>
    <!-- /theme JS files -->

</head>
<style>
    input,
    .password::-webkit-input-placeholder {
        font-size: 9.2px;

    }
</style>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">

        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">

            <ul class="navbar-nav ml-md-auto">

                <li class="nav-item">
                    <a href="/events" class="navbar-nav-link" id="kalendar"><i class="icon-calendar2 mr-2"></i>
                        Kalendar</a>
                </li>

                <li class="nav-item">
                    <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                        data-target="#contactModal">
                        Hubungi Kami</a>
                </li>

                <li class="nav-item">
                    <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                        data-target="#loginModal">
                        <i class="icon-unlocked2 mr-2"></i>Log Masuk</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

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
                    @if (Session::has('successMessage'))
                        <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Tutup</span></button>
                            <strong>Berjaya, </strong> {{ session('successMessage') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama Penuh') }}
                                <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="nama" type="text"
                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                    value="{{ old('nama') }}" autocomplete="name" autofocus>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="No. Kad Pengenalan"
                                class="col-md-4 col-form-label text-md-right">{{ __('No. Kad Pengenalan') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="no_kp" type="text"
                                    class="form-control @error('no_kp') is-invalid @enderror" name="no_kp"
                                    value="{{ old('no_kp') }}" autocomplete="no_kp" autofocus>

                                @error('no_kp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Alamat E-mel') }}
                                <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Kata Laluan') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control password @error('password') is-invalid @enderror"
                                    name="password" autocomplete="new-password"
                                    placeholder="12 aksara (kombinasi huruf besar,huruf kecil, nombor dan simbol)">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rpassword"
                                class="col-md-4 col-form-label text-md-right">{{ __('Ulang Kata Laluan') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="rpassword" type="password" class="form-control" name="rpassword"
                                    autocomplete="rpassword">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <select name="department" data-placeholder="Pilih Bahagian/Seksyen"
                                    class="form-control select-search" data-fouc>
                                    <option></option>

                                    @foreach ($departments as $department)
                                        <option {{ old('department') == $department->id ? 'selected' : '' }}
                                            value="{{ $department->id }}">{{ $department->nama }}</option>
                                    @endforeach

                                </select>

                                @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="position" data-placeholder="Pilih Jawatan"
                                    class="form-control select-search" data-fouc>
                                    <option></option>
                                    @foreach ($positions as $position)
                                        <option {{ old('position') == $position->id ? 'selected' : '' }}
                                            value="{{ $position->id }}">{{ $position->nama }}</option>
                                    @endforeach
                                </select>

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_extension"
                                class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }} <span
                                    class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="no_extension" type="text" placeholder="Contoh : 2378"
                                    class="form-control @error('no_extension') is-invalid @enderror"
                                    name="no_extension" value="{{ old('no_extension') }}">

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
                                    value="{{ old('no_bimbit') }}" autocomplete="no_bimbit">

                                @error('no_bimbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="status" value="0">

                        <div class="form-group text-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Daftar') }}
                                </button>
                                {{-- <a href="/">{{ __('Log Masuk') }}</a> --}}
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Login form modal -->
                <div id="loginModal" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="text-center">
                                <img src="{{ asset('/images/jata.png') }}" width="90" height="70" />
                            </div>
                            <div class="content d-flex justify-content-center align-items-center">

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="text-center"><b>KEMENTERIAN PERDAGANGAN ANTARABANGSA DAN
                                                INDUSTRI</b></div>
                                        <br>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="form-group form-group-feedback form-group-feedback-left">
                                            <div class="col-md-12">
                                                <input type="text" name="no_kp" class="form-control"
                                                    value="{{ old('no_kp') }}" placeholder="No. Kad Pengenalan">
                                            </div>
                                            <div class="form-control-feedback">
                                                <i class="icon-user text-muted"></i>
                                            </div>

                                        </div>

                                        <div class="form-group form-group-feedback form-group-feedback-left">
                                            <div class="col-md-12">
                                                <input type="password" id="password_login" name="password"
                                                    class="form-control" placeholder="Kata Laluan"
                                                    autocomplete="off">
                                            </div>
                                            <div class="form-control-feedback">
                                                <i class="icon-lock2 text-muted"></i>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-feedback form-group-feedback-left">
                                            <div class="col-md-12">
                                                <input type="checkbox" onclick="showPassword()"> &nbsp;Show Password
                                            </div>
                                        </div>

                                        <div class="text-center">

                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Lupa Kata Laluan?') }}
                                            </a>

                                            <a class="btn btn-link" href="/user_public/create">
                                                {{ __('Daftar Baru') }}
                                            </a>

                                        </div>
                                        {{-- <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Log Masuk <i
                                            class="icon-circle-right2 ml-2"></i></button>
                                </div> --}}

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-block">Log Masuk <i
                                                class="icon-circle-right2 ml-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Login form modal -->
            </div>
        </div>

    </div>
    <div class="text-center">
        © Kementerian Pelaburan, Perdagangan dan Industri 2022
    </div>
</body>

</html>
<script>
    function showPassword() {

        var x = document.getElementById("password_login");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
