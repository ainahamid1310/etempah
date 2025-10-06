<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MITI - eTempah</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../../../../global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="../../../../global_assets/js/main/jquery.min.js"></script>
    <script src="../../../../global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="../../../../global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="assets/js/app.js"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">
        <div class="navbar-brand">
            <a href="/events"><i class="icon-calendar2 mr-3 icon-2x"></i></a>
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
                    {{-- <a href="/kami" class="navbar-nav-link"></a> --}}
                    <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                        data-target=".bd-example-modal-lg" data-id="">
                        Hubungi Kami</a>
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
            <img src="{{ asset('/images/main.jpg') }}" width="600" height="400" />
        </div>


        <div class="card bg-light col-md-6">
            <div class="content d-flex justify-content-center align-items-center">

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- <div class="card-body"> --}}
                    <div class="text-center mb-3">
                        <img src="{{ asset('/images/jata.png') }}" width="90" height="70" />
                    </div>

                    <div class="text-center"><b>KEMENTERIAN PELABURAN, PERDAGANGAN DAN INDUSTRI</b></div>

                    {{-- <div class="text-center"><b>Log Masuk Sistem</b></div> --}}
                    <br>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <div class="col-md-12">
                            <input type="text" name="no_kp" class="form-control" placeholder="No. Kad Pengenalan">
                        </div>
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>

                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control" placeholder="Kata Laluan">
                        </div>
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                    </div>



                    {{-- <div class="form-group d-flex align-items-center">
                            <a href="login_password_recover.html" class="ml-auto">Lupa Kata Laluan?</a>
                        </div> --}}
                    <div class="text-center">
                        {{-- @if (Route::has('password.request')) --}}
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Lupa Kata Laluan?') }}
                        </a>
                        {{-- @endif --}}
                        <a class="btn btn-link" href="/user_public/create">
                            {{ __('Daftar Baru') }}
                        </a>

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Log Masuk <i
                                class="icon-circle-right2 ml-2"></i></button>
                    </div>

                    {{-- </div> --}}
                    {{-- <div style="width: 80%">
                        <li>Sila rujuk Kalendar atau Menu Semakan Kekosongan Bilik sebelum membuat tempahan.</li>
                        <li>Bagi mesyuarat keesokan hari, permohonan hendaklah dibuat sebelum jam 4.00 petang.
                            Sekiranya tempahan dibuat selepas jam 4.00 petang, sila berhubung terus dengan
                            pihak Pantri (ext:4932) bagi tempahan makan dan minum.</li>
                        <li>Sebarang pertanyaan tempahan bilik, sila hubungi pegawai di sini.</li>
                        <li>Jika Bilik Latihan Aras 19 melibatkan pelawat MITI, Urusetia adalah DIWAJIBKAN untuk
                            memohon Pas Pelawat daripada Unit Keselamatan MITI selewat-lewatnya SATU HARI SEBELUM PROGRAM BERMULA.
                            Sila hubungi Unit Keselamatan melalui e-mel unitkeselamatan@miti.gov.my atau talian telefon (ext:2112 / 2123)</li>
                    </div> --}}


                    <div class="card">
                        <div class="card-header bg-warning text-white" style="height: 1cm">
                            <h6 class="card-title">Peringatan :</h6>
                        </div>

                        <div class="card-body" style="background-color: rgb(252, 243, 207 );">
                            @foreach ($umums as $index => $umum)
                                <li> {{ $umum->keterangan }} </li>
                            @endforeach
                        </div>
                    </div>


                </form>

            </div>
        </div>

        <div id="modal_theme_primary" class="modal fade bd-example-modal-lg" tabindex="-1">
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
                                        {{-- <th style="width: 5%"><b>Bil</b></th> --}}
                                        <th style="width: 25%"><b>Nama</b> </th>
                                        <th style="width: 25%">Email</th>
                                        <th style="width: 10%">No. Telefon</th>

                                    </tr>
                                </thead>
                                @foreach ($contacts as $role => $contact_list)
                                    <tr>
                                        <th colspan="3"><i
                                                class="icon-users2"></i><strong>{{ $role }}<strong>
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

    </div>
    <div class="text-center">
        © Kementerian Pelaburan, Perdagangan dan Industri 2022
    </div>
</body>

</html>
