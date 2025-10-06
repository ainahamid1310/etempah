@extends('layouts.backend_urusetia')

@section('css')

@endsection

@section('js_themes')
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script src="/global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
	<script src="/global_assets/js/demo_pages/fullcalendar_basic.js"></script>
    {{-- <script src="/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script> --}}
	{{-- <script src="/global_assets/js/demo_charts/d3/bars/bars_advanced_simple_interaction.js"></script> --}}
    <script src="/global_assets/js/demo_charts/echarts/light/pies/pie_basic.js"></script>
	<script src="/global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>

	<script src="/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="/global_assets/js/plugins/visualization/c3/c3.min.js"></script>
	<script src="/global_assets/js/demo_charts/c3/c3_bars_pies.js"></script>
@endsection

@section('breadcrumb')
<div class="breadcrumb">
    <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
    <span class="breadcrumb-item active"> Bilik Mesyuarat  >  Profail Bilik Mesyuarat</span>

</div>
@endsection

@section('content')



<div class="card">

    <div class="text-center">
        <div class="card-header bg-light header-elements-inline">
            <h5 class="card-title">Tempahan 2021</h5>
            <div class="header-elements">
                <div class="list-icons">
                    {{-- <a class="list-icons-item" data-action="collapse"></a> --}}
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        {{-- <div class="card-body">

            <button type="button" class="btn btn-success btn-float"><i class="icon-folder-open mr-3 icon-3x"></i>28
                <span class="mb-3">JUMLAH</span>
            </button>

            <button type="button" class="btn btn-secondary btn-float"><i class="icon-files-empty mr-3 icon-3x"></i>20
                <span class="mb-3">BARU</span>
            </button>

            <button type="button" class="btn btn-warning btn-float"><i class="icon-hour-glass2 mr-3 icon-3x"></i>4
                <span class="mb-3">DALAM PROSES</span>
            </button>

            <button type="button" class="btn btn-primary btn-float"><i class="icon-database mr-3 icon-3x"></i>4
                <span class="mb-3">SELESAI</span>
            </button>

        </div> --}}

        {{-- <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Baru</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Lulus</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">21</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ditolak</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">11</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-minus-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Batal</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">36</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}

     <!-- Quick stats boxes -->
    <div class="row">


       <div class="col-lg-3">

            <div class="card border-y-2 border-top-green-300 border-bottom-green-600 rounded-0 alpha-success">
                <div class="card-body">
                    <div class="d-flex">
                        <h2 class="font-weight-semibold mb-0">250</h2>
                        <div class="list-icons ml-auto">
                            <i class="icon-folder-open"></i>
                        </div>
                    </div>

                    <div>
                        Jumlah Permohonan
                        {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                    </div>
                </div>

                <div class="chart" id="today-revenue"></div>
            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-y-2 border-top-pink-300 border-bottom-pink-600 rounded-0 alpha-danger">
                <div class="card-body">
                    <div class="d-flex">
                        <h2 class="font-weight-semibold mb-0">45</h2>
                        <div class="list-icons ml-auto">
                            <i class="icon-files-empty"></i>
                        </div>
                    </div>

                    <div>
                        Permohonan Baru
                        {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                    </div>
                </div>

                <div class="chart" id="today-revenue"></div>
            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-y-2 border-top-blue-300 border-bottom-blue-600 rounded-0 alpha-primary">
                <div class="card-body">
                    <div class="d-flex">
                        <h2 class="font-weight-semibold mb-0">30</h2>
                        <div class="list-icons ml-auto">
                            <i class="icon-hour-glass2"></i>
                        </div>
                    </div>

                    <div>
                        Dalam Proses
                        {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                    </div>
                </div>

                <div class="chart" id="today-revenue"></div>
            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-y-3 border-top-orange-300 border-bottom-orange-600 rounded-0 alpha-orange">
                <div class="card-body">
                    <div class="d-flex">
                        <h2 class="font-weight-semibold mb-0">30</h2>
                        <div class="list-icons ml-auto">
                            <i class="icon-database"></i>
                        </div>
                    </div>

                    <div>
                        Selesai
                        {{-- <div class="font-size-sm opacity-75">Tempahan Bilik</div> --}}
                    </div>
                </div>

                <div class="chart" id="today-revenue"></div>
            </div>

        </div>



    </div>
    <!-- /quick stats boxes -->



    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <!-- Simple interaction -->
        <div class="card">
            <div class="card-header header-elements-inline alpha-success">
                <h5 class="card-title">5 Tempahan Bilik Tertinggi</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart" id="c3-bar-chart"></div>
                </div>
            </div>
        </div>
        <!-- /simple interaction -->
    </div>

    <div class="col-md-6">
        <!-- Basic pie -->
        <div class="card">
            <div class="card-header header-elements-inline alpha-success">
                <h5 class="card-title">Statistik Kelulusan Pemohon</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="pie_basic"></div>

                </div>

            </div>
            {{-- <input type="text" name="" id="dalam_proses_id" value="{{ $dalam_proses }}"> --}}
        </div>
        <!-- /basic pie -->
    </div>

</div>

<div class="card">

    <!-- Hover rows -->
				<div class="card">
					<div class="card-header header-elements-inline alpha-success">
						<h5 class="card-title">Tempahan Hari ini</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					{{-- <div class="card-body">
						The <code>DataTables</code> is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table. DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function. Searching, ordering, paging etc goodness will be immediately added to the table, as shown in this example. <strong>Datatables support all available table styling.</strong>
					</div> --}}

					<table class="table datatable-basic table-hover">
						<thead>
							<tr>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Job Title</th>
								<th>DOB</th>
								<th>Status</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Marth</td>
								<td><a href="#">Enright</a></td>
								<td>Traffic Court Referee</td>
								<td>22 Jun 1972</td>
								<td><span class="badge badge-success">Active</span></td>
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
												<a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
												<a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Jackelyn</td>
								<td>Weible</td>
								<td><a href="#">Airline Transport Pilot</a></td>
								<td>3 Oct 1981</td>
								<td><span class="badge badge-secondary">Inactive</span></td>
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
												<a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
												<a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
											</div>
										</div>
									</div>
								</td>
							</tr>



						</tbody>
					</table>
				</div>
				<!-- /hover rows -->


</div>

@endsection

@section('script')

@endsection
