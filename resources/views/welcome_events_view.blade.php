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
    <link href="../../../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../../../assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="../../../../assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="../../../../assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="../../../../assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <script src="../../../../global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
    <script src="../../../../assets/js/fullcalendar_basichome.js"></script>

    <!-- Core JS files -->
    <script src="../../../../global_assets/js/main/jquery.min.js"></script>
    <script src="../../../../global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="../../../../global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="../../../../global_assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="../../../../assets/js/app.js"></script>
    <!-- /theme JS files -->



</head>


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
                    <a href="/" class="navbar-nav-link" id="kalendar"><i class="icon-home mr-2"></i>
                        Utama</a>
                </li>

                <li class="nav-item">
                    <a href="/events" class="navbar-nav-link" id="kalendar"><i class="icon-calendar2 mr-2"></i>
                        Kalendar</a>
                </li>

                <li class="nav-item">
                    <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                        data-target="#contactModal"><i class="icon-phone2 mr-2"></i>
                        Hubungi Kami</a>
                </li>
                @if (Auth::check())
                @else
                    <li class="nav-item">
                        <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                            data-target="#loginModal">
                            <i class="icon-unlocked2 mr-2"></i>Log Masuk</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

    <div class="card-group mb-sm-3">

        <div class="col-md-12">
            <div class="card-header header-elements-sm-inline">
                <h5 class="card-title"><b>Senarai Program / Mesyuarat pada
                        {{ Carbon\Carbon::parse($tempah)->format('d-m-Y') }}</b></h5>
                {{-- {{ $tempah }}</b></h5> --}}
            </div>

            <table class="table table-bordered table-hover" style="font-size:12.7px; font-family:arial">
                <thead>
                    <tr class="bg-primary">
                        <th style="width: 5%">Bil</th>
                        <th style="width: 5%">ID</th>
                        <th style="width: 23%">Program / Mesyuarat</th>
                        <th style="width: 15%">Pengerusi</th>
                        <th style="width: 20%">Nama Bilik</th>
                        <th style="width: 20%">
                            <center>Tarikh</center>
                        </th>
                        <th style="width: 20%">
                            <center>Masa</center>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->id }}</td>
                            <td>

                                @if (Auth::check())
                                    @if ($val == 'null')
                                        @role('biz-point|pmsb|user')
                                            {{ $booking->nama_mesyuarat }}
                                            @elserole('approver-vc')
                                            <a
                                                href="/admin/application_vc/show/{{ encrypt($booking->id) }}">{{ $booking->nama_mesyuarat }}</a>
                                        @else
                                            <a
                                                href="/admin/application_room/show/{{ encrypt($booking->id) }}">{{ $booking->nama_mesyuarat }}</a>
                                        @endrole
                                    @elseif ($val == 1)
                                        @role('biz-point|pmsb|user')
                                            {{ $booking->nama_mesyuarat }}
                                            @elserole('approver-vc')
                                            <a
                                                href="/admin/application_vc/show/{{ encrypt($booking->id) }}">{{ $booking->nama_mesyuarat }}</a>
                                        @else
                                            <a
                                                href="/admin/application_room/show/{{ encrypt($booking->id) }}">{{ $booking->nama_mesyuarat }}</a>
                                        @endrole
                                    @elseif ($val == 0)
                                        {{ $booking->nama_mesyuarat }}
                                    @endif
                                @else
                                    {{ $booking->nama_mesyuarat }}
                                @endif
                            </td>
                            <td>
                                @if ($booking->nama_pengerusi != null)
                                    {{ $booking->nama_pengerusi }}
                                @else
                                    {{ $booking->kategori_pengerusi }}
                                @endif
                            </td>
                            <td>{{ $booking->nama_bilik }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($booking->tarikh_mula)->format('d-m-Y') }} -
                                {{ Carbon\Carbon::parse($booking->tarikh_hingga)->format('d-m-Y') }}</td>
                            <td> {{ Carbon\Carbon::parse($booking->masa_mula)->format('g:i A') }} -
                                {{ Carbon\Carbon::parse($booking->masa_hingga)->format('g:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            &nbsp;
            <div>
                <button class="btn bg-success" onclick="history.back()" type="button">
                    Kembali</button>
            </div>

        </div>

        @if ($errors->any())
            <script>
                $(function() {
                    $('#loginModal').modal({
                        show: true
                    });
                });
            </script>
        @endif

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
                                            placeholder="Kata Laluan">
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
        <!-- /login form modal -->

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
        <!-- /Contact form modal -->

    </div>



    <div class="text-center">
        © Kementerian Pelaburan, Perdagangan dan Industri 2022
    </div>
</body>

</html>
