<!DOCTYPE html>
<html lang="ms">

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

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* Popup rasmi MITI */
    .swal2-popup.announcement-popup {
        width: 50em !important;
        padding: 2em !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.05rem;
        text-align: center;
    }

    /* Tajuk */
    .swal2-title.announcement-title {
        font-size: 1.8rem !important;
        font-weight: 700;
        color: #003366; /* biru MITI */
    }

    /* Isi teks */
    .swal2-html-container {
        font-size: 1.05rem;
        line-height: 1.6;
    }

    /* Butang “Faham” */
    .swal2-confirm.announcement-button {
        background-color: #003366 !important;
        color: #fff !important;
        border-radius: 8px !important;
        padding: 10px 25px !important;
        font-weight: 600;
    }

    /* Logo MITI */
    .swal2-header img.miti-logo {
        width: 80px;
        margin-bottom: 10px;
    }

/* Buang pseudo-element tambahan */
.swal2-icon::before,
.swal2-icon::after,
.swal2-icon i::before,
.swal2-icon i::after {
    content: none !important;
}

/* Bulatan saiz sederhana */
.swal2-icon.swal2-info {
    width: 3.1em !important;
    height: 3.1em !important;
    border: 0.15em solid #3fc3ee !important;
    border-radius: 50% !important;
    color: #3fc3ee !important;
    background: #fff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* kecilkan ikon “i” SVG asal SweetAlert2 */
.swal2-icon.swal2-info svg {
    width: 10% !important;   /* asalnya 80–90% */
    height: 10% !important;
}

/* Buang ikon FontAwesome tambahan kalau ada */
.swal2-icon.swal2-info i,
.swal2-icon.swal2-info .fa,
.swal2-icon.swal2-info .fas {
    display: none !important;
}

    </style>

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-static">
        {{-- <div class="navbar-brand">
            <a href="/events"><i class="icon-calendar2 mr-3 icon-2x"></i></a>
            <span>eTempah</span>
        </div> --}}

        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">

            <ul class="navbar-nav ml-md-auto">

                <li class="nav-item">
                    <a href="{{ asset('/manual/Manual.pdf') }}" class="navbar-nav-link" target="_blank"><i
                            class="icon-book3"></i>
                        &nbsp; Manual Pengguna</a>
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

                <li class="nav-item">
                    <a href="/" class="navbar-nav-link" id="mymodal" data-toggle="modal"
                        data-target="#loginModal">
                        <i class="icon-unlocked2 mr-2"></i>Log Masuk</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

    <div class="card-group mb-sm-3 row align-items-center">

        <div class="card bg-light col-md-6">

            <div class="card">
                <div class="card-header bg-warning text-white" style="height: 1cm">
                    <h5 class="card-title">Peringatan Bilik</h5>
                </div>
                <div class="card-body" style="background-color: rgb(252, 243, 207 );">
                    <ul style="font-family:Verdana, Geneva, Tahoma, sans-serif">
                        {{-- @foreach ($room_announcements as $room_announcement)
                            <li>{{ $room_announcement->keterangan }} </li>
                        @endforeach --}}
                        Pautan Peringatan berkaitan bilik
                        <li>Pautan <a href="{{ asset('references/panduan.pdf') }}" target="_blank">Garis Panduan
                                Penggunaan Fasiliti MITI (Dewan Perdana / Bilik Seminar & Ruang Bangunan).</a>
                        </li>
                        <li>Pautan <a href="{{ asset('references/popup.pdf') }}" target="_blank">Proses dan
                                Tanggungjawab Penganjur
                                Program (Pemohon) Bagi
                                Penggunaan Fasiliti.</a></li>
                        <li>Pautan <a href="{{ asset('references/ptw_pmsb.pdf') }}" target="_blank">Borang <i>Permit To
                                    Work</i>. </a>
                        </li>
                        <li>Pautan <a href="{{ asset('references/do_adhoc.pdf') }}" target="_blank">Borang Permohonan Pantri Dalaman.
                                    </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-white" style="height: 1cm">
                    <h5 class="card-title">Peringatan VC</h5>
                </div>
                <div class="card-body" style="background-color: rgb(252, 243, 207 );">
                    <ul style="font-family:Verdana, Geneva, Tahoma, sans-serif">
                        {{-- @foreach ($vc_announcements as $vc_announcement)
                            <li>{{ $vc_announcement->keterangan }} </li>
                        @endforeach --}}
                        Pautan Peringatan berkaitan VC
                        <li>Pautan <a href="{{ asset('references/peringatan_vc.pdf') }}" target="_blank">Garis Panduan
                                Urusetia VC.</a>
                        </li>
                        <li>Pautan <a href="{{ asset('references/GARIS_PANDUAN_DAN_ETIKA_PENGGUNAAN_VC.pdf') }}"
                                target="_blank">Garis Panduan dan Etika
                                penggunaan VC.</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow-0 bg-light">
            @if (Session::has('successMessage'))
                <div class="alert alert-info alert-styled-left alert-dismissible">
                    <span class="font-weight-semibold">Pendaftaran telah Berjaya. Sila log masuk menggunakan No. Kad
                        Pengenalan dan Kata Laluan yang telah didaftarkan.
                </div>
            @endif
            <h1 class="text-center"><b>Sistem Tempahan Bilik dan VC</b></h1>
            <img src="{{ asset('/images/main.jpg') }}" width="600" height="380"
                style="object-position: center top;" />
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

                                <div class="text-center"><b>KEMENTERIAN PELABURAN PERDAGANGAN DAN
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
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Kata Laluan" autocomplete="off">
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
                                {{-- @foreach ($contacts as $role => $contact_list)
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
                                @endforeach --}}
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
        &copy;2022-2025 MITI Malaysia
    </div>
</body>

</html>

<script>
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        title: 'Makluman!',
        html: `
            <p>Sistem sedang dalam proses <b>naik taraf dan penambahbaikan</b> untuk meningkatkan prestasi dan keselamatan sistem.</p>
            <p>Gangguan sementara mungkin berlaku antara <b>20–22 Oktober 2025</b>. Kami memohon maaf atas sebarang kesulitan yang timbul.</p>
            <p>Terima kasih atas kerjasama anda.</p>
        `,
        icon: 'info',
        confirmButtonText: 'Tutup',
        allowOutsideClick: false,
        customClass: {
            popup: 'announcement-popup',
            title: 'announcement-title',
            confirmButton: 'announcement-button'
        }
    });
});



</script>
