@extends('layouts.admin')

@section('js_themes')
    {{-- Datatable --}}
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
@endsection

@section('js_extensions')
    {{-- Datatable --}}
    <script src="/global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>
@endsection

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/status" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Status</span></a>
    {{-- <a href="/status/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Status</span></a> --}}
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item active">Pengurusan Data Status</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title text-uppercase text-info-800 font-weight-bold">Senarai Status</h6>
        </div>

        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status Pentadbiran</th>
                    <th>Status Pemohon</th>
                    <th>CoS</th>
                    <th>PSH</th>
                    <th>PLI</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->status_pentadbiran }}</td>
                    <td>{{ $status->status_pemohon }}</td>
                    <td>
                        @if ($status->cos == '1')
                            <span><i class="icon-checkmark4"></i></span>
                        @endif
                    </td>
                    <td>
                        @if ($status->psh == '1')
                            <span><i class="icon-checkmark4"></i></span>
                        @endif
                    </td>
                    <td>
                        @if ($status->pli == '1')
                            <span><i class="icon-checkmark4"></i></span>
                        @endif
                    </td>
                    <td>
                        <a href="/status/show/{{ $status->id }}" data-toggle="tooltip" title="Papar Maklumat"><span class="btn bg-primary-600 badge-icon rounded-round"><i class="icon-display"></i></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
