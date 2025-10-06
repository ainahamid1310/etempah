@extends('layouts.backend_applicant')
@section('js_themes')
    <script src="/global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
    <script src="/global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
    <script src="/global_assets/js/demo_pages/fullcalendar_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Bilik Mesyuarat > Profail Bilik Mesyuarat</span>

    </div>
@endsection

@section('content')
    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Container -->
                <div class="flex-fill">

                    <!-- Error title -->
                    <div class="text-center mb-3">
                        <h1 class="error-title">403</h1>
                        <h5>Anda tiada capaian di sini.</h5>
                    </div>
                    <!-- /error title -->

                </div>
                <!-- /container -->

            </div>
            <!-- /content area -->


            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                        data-target="#navbar-footer">
                        <i class="icon-unfold mr-2"></i>
                        Footer
                    </button>
                </div>


            </div>
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
@endsection
