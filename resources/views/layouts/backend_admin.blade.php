<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem eTempah (Bilik & VC)</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets_material/css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    @yield('js_themes')
    <!-- /theme JS files -->   
    
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="/assets/js/app.js"></script>
    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
    <script src="/global_assets/js/plugins/buttons/spin.min.js"></script>
    <script src="/global_assets/js/plugins/buttons/ladda.min.js"></script>
    <script src="/global_assets/js/plugins/forms/inputs/duallistbox/duallistbox.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>
    <script src="/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/switch.min.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="/global_assets/js/demo_pages/components_collapsible.js"></script>
    <script src="/global_assets/js/plugins/forms/wizards/steps.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_wizard.js"></script>
    <script src="/global_assets/js/plugins/forms/validation/validate.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_inputs.js"></script>
    <script src="/global_assets/js/demo_pages/components_buttons.js"></script>
    <script src="/global_assets/js/plugins/extensions/cookie.js"></script>
    <script src="/global_assets/js/plugins/forms/inputs/inputmask.js"></script>
    <script src="/global_assets/js/demo_pages/components_popups.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_advanced.js"></script>
    <script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="/global_assets/js/demo_pages/extra_sweetalert.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
    <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_sorting.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script src="/global_assets/js/demo_pages/form_multiselect.js"></script>
    <script src="/global_assets/js/demo_pages/form_dual_listboxes.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- /theme JS files -->
<style>
    #time-fields {
    display: block;
    margin-top: 20px;
}

#time-fields div {
    margin-bottom: 10px;
}

</style>
    @yield('js_extensions')

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-dark bg-blue-800 navbar-expand-md">

        <div class="text-white wmin-200">
            eTempah
        </div>

        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                        <i class="icon-paragraph-justify3"></i>
                    </a>
                </li>
            </ul>

            <span>
                <div class="text-center">
                    <label>Paparan :</label>
                    <select name="dynamic_select" id="dynamic_select" class="form-control select-fixed-single select"
                        data-container-css-class="select-sm bg-primary-700" data-fouc>
                        @if (Auth::user()->is_admin == '1')
                            @if (Auth::user()->hasRole('pmsb'))
                                <option value="1" selected>Pengguna PMSB</option>
                            @elseif(Auth::user()->hasRole('biz-point'))
                                <option value="1" selected>Pengguna Biz-Point</option>
                            @else
                                <option value="1" selected>Pentadbir</option>
                                <option value="0">Pengguna</option>
                            @endif
                        @else
                            <option value="0">Pengguna</option>
                        @endif
                    </select>
                </div>
            </span>

            @if (Auth::user()->status == 1)
                <span class="badge bg-success-400 ml-md-auto mr-md-3">Aktif</span>
            @else
                <span class="badge bg-warning-400 ml-md-auto mr-md-3">Tidak Aktif</span>
            @endif

            <ul class="navbar-nav">
                <li class="nav-item dropdown">

                </li>

                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle"
                        data-toggle="dropdown">
                        <span>{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="/profile/show/{{ encrypt(Auth::user()->id) }}?layout=admin" class="dropdown-item"><i
                                class="icon-user-plus"></i> Profil Saya</a>

                        {{-- <div class="dropdown-divider"></div> --}}
                        {{-- <a href="/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a> --}}
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

    <!-- Page header -->
    <div class="page-header">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                @yield('breadcrumb')
            </div>

        </div>


    </div>
    <!-- /page header -->


    <!-- Page content -->
    <div class="page-content pt-0">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-light sidebar-main sidebar-expand-md align-self-start">

            <!-- Sidebar mobile toggler -->
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a>
                <span class="font-weight-semibold">Main sidebar</span>
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
            </div>
            <!-- /sidebar mobile toggler -->

            <!-- Sidebar content -->
            @include('layouts.partials.sidebar_admin')
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->


        <!-- Main content -->

        <div class="content-wrapper">

            @include('layouts.partials.notification')
            @yield('content')

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
                {{--&copy; {{ \Carbon\Carbon::now()->year }} <a href="#">eTempah</a> by

                <a href="http://www.miti.gov.my/">MITI</a> --}}
		&copy;2022-2023 MITI Malaysia
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
                if (value) { // require a URL

                    window.location = '/home?val=' + value; // redirect
                }
                return false;
            });
        });
    </script>
</body>

</html>
