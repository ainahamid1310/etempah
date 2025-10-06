@extends('layouts.backend_applicant')
@section('js_themes')
	<script src="/global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
	<script src="/global_assets/js/demo_pages/fullcalendar_basic1.js"></script>
@endsection

@section('breadcrumb')
<div class="breadcrumb">
    <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
    <span class="breadcrumb-item active"> Bilik Mesyuarat  >  Profail Bilik Mesyuarat</span>

</div>
@endsection

@section('content')

	<!-- Content area -->
    <div class="content">

        <!-- Basic view -->
        <div class="card">

            <div class="card-body">
                {{-- <p class="mb-3">FullCalendar is a jQuery plugin that provides a full-sized, drag &amp; drop event calendar like the one below. It uses AJAX to fetch events on-the-fly and is easily configured to use your own feed format. It is visually customizable with a rich API. Example below demonstrates a default view of the calendar with a basic setup: draggable and editable events, and starting date.</p> --}}

                <div class="fullcalendar-basic"></div>
            </div>
        </div>
        <!-- /basic view -->

    </div>
    <!-- /content area -->

@endsection
