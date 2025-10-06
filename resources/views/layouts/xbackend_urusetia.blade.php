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
    @yield('css')

	<!-- Core JS files -->
	<script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

    <!-- Theme JS files -->
    @yield('js_themes')
    <!-- /theme JS files -->

	<!-- Theme JS files -->
    <script src="/global_assets/js/plugins/buttons/spin.min.js"></script>
	<script src="/global_assets/js/plugins/buttons/ladda.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_select2.js"></script>
    <script src="/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/switch.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
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
	<script src="/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="/global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>
	<!-- /theme JS files -->

	<!-- /theme JS files -->
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
                    <label>Paparan:</label>
                    <select id="dynamic_select" class="form-control select-fixed-single select" data-container-css-class="select-sm bg-primary-700" data-fouc>
                       @if(Auth::user()->is_admin == '2')
                            <option value="/home/select/2">Pentadbir Sistem</option>
                            <option value="/home/select/1" selected>Urusetia Bilik</option>
                        @elseif(Auth::user()->is_admin == '1')
                            <option value="/home/select/1">Urusetia Bilik</option>
                        @endif
                        <option value="/home/select/0">Pengguna</option>
                    </select>
                </div>
            </span>

			<span class="badge bg-success-400 ml-md-auto mr-md-3">Active</span>

			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-bubbles5"></i>
						<span class="d-md-none ml-2">Messages</span>
						<span class="badge badge-pill badge-mark bg-orange-400 border-orange-400 ml-auto ml-md-0"></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Messages</span>
							<a href="#" class="text-default"><i class="icon-compose"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3 position-relative">
										<img src="/global_assets/images/placeholders/placeholder.jpg" width="36" height="36" class="rounded-circle" alt="">
									</div>

									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">James Alexander</span>
												<span class="text-muted float-right font-size-sm">04:58</span>
											</a>
										</div>

										<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
									</div>
								</li>


							</ul>
						</div>

						<div class="dropdown-content-footer justify-content-center p-0">
							<a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
						</div>
					</div>
				</li>

				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<img src="/global_assets/images/placeholders/placeholder.jpg" class="rounded-circle mr-2" height="34" alt="">
						<span>{{ Auth::user()->name }}</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="/profile/show/{{ Auth::user()->id }}" class="dropdown-item"><i class="icon-user-plus"></i> Profail Saya</a>
						<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
						<div class="dropdown-divider"></div>
						<a href="/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
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
				{{-- <div class="breadcrumb">
					<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
					<span class="breadcrumb-item active">Dashboard</span>
				</div> --}}

				{{-- <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a> --}}
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
                @include('layouts.partials.sidebar_urusetia')
            <!-- /sidebar content -->

		</div>
		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">

			<!-- Content area -->
			{{-- <div class="content">


				<!-- content -->
				<div class="row">
					<div class="col-xl-12">

						<div class="card">
							<div class="card-header header-elements-sm-inline">
								<h6 class="card-title">Laman Utama</h6>
							</div>

							<div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">

							</div>

							<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th>Bil.</th>
											<th>Tujuan</th>
											<th>Lokasi</th>
											<th>Pengerusi</th>
											<th>Pemohon</th>
											<th>Masa</th>
											<th>Jenis Tempahan</th>
										</tr>
									</thead>
									<tbody>
										<tr class="table-active table-border-double">
											<td colspan="7">Tempahan Hari Ini</td>

										</tr>
										<tr>
											<td><span>1</span></td>
											<td><span>Mesyuarat Pengerusan BPM</span></td>
											<td><span>Bilik Comcec</span></td>
                                            <td><span>Pengarah BPM</span></td>
                                            <td><span>Mabel Dominic Madai</span></td>
                                            <td><span>10.30 am - 12.30 noon</span></td>
                                            <td><span><i class="icon-display4 mr-3 icon-2x"></i><i class="icon-users4"></i></span></td>


									</tbody>
								</table>
							</div>
						</div>


					</div>


				</div>
				<!-- /content -->

			</div> --}}
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
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
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
        $(function(){
        // bind change event to select
        $('#dynamic_select').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
        });
    </script>
</body>
</html>
