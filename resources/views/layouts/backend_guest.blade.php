<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem eTempah (Bilik & VC)</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->  
 <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    @yield('js_themes')
    <!-- /theme JS files -->

    @yield('js_extensions')

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">
        <span class="text-center">
            <h2>Sistem eTempah</h2>
        </span>

        {{-- <a href="/events"><i class="icon-calendar2 mr-3 icon-2x"></i></a>
            <span>eTempah</span> --}}


        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">

            <ul class="navbar-nav ml-md-auto">



                <li class="nav-item">
                    <a href="/" class="navbar-nav-link" id="mymodal"><i class="icon-home mr-2"></i>
                        Utama</a>
                </li>

                {{-- <li class="nav-item">
                    <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                        data-target="#loginModal">
                        <i class="icon-unlocked2 mr-2"></i>Log Masuk</a>
                </li>

                <li class="nav-item">
                    <a href="/events" class="navbar-nav-link" id="kalendar"><i class="icon-calendar2 mr-2"></i>
                        Kalendar</a>
                </li> --}}

            </ul>
        </div>
    </div>
    <!-- /main navbar -->

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
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Kata Laluan" autocomplete="off">
                                </div>
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
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

                        </div>

                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button> --}}
                            <button type="submit" class="btn btn-primary btn-block">Log Masuk <i
                                    class="icon-circle-right2 ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Login form modal -->



    <!-- Page content -->
    <div class="page-content pt-0">


        <!-- Main content -->
        <div class="content-wrapper">

            @include('layouts.partials.notification')
            @yield('content')
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Footer -->

    <div class="navbar navbar-expand-lg navbar-light">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                data-target="#navbar-footer">
                <i class="icon-unfold mr-2"></i>
                Footer
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-footer">
            <span class="navbar-text">
                &copy; {{ \Carbon\Carbon::now()->year }} <a href="#">eTempah</a> by

                <a href="http://www.miti.gov.my/">MITI</a>
            </span>
        </div>
    </div>
    <!-- /footer -->

    @yield('script')

    <script>
        $(function() {
            // bind change event to select
            $('#dynamic_select').on('change', function() {
                var value = $(this).val(); // get selected value

                if (value) {
                    window.location = '/home?val=' + value; // redirect
                }
                return false;
            });
        });
    </script>
</body>

</html>
