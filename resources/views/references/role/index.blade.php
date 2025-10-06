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
    <a href="/role" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Peranan</span></a>
    <a href="/role/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Peranan</span></a>
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item active">Pengurusan Data Peranan</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title text-uppercase text-info-800 font-weight-bold">Senarai Semua Peranan</h5>
        </div>

        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>
                    <th>Nama Peranan</th>
                    <th>Keterangan</th>
                    <th>Guard</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>
                        @if ($role->status == 1)
                            <span class="badge badge-success text-uppercase">Aktif</span>
                        @else
                            <span class="badge badge-danger text-uppercase">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="/role/show/{{ $role->id }}" data-toggle="tooltip" title="Papar Maklumat"><span class="btn bg-primary-600 badge-icon rounded-round"><i class="icon-display"></i></span></a>
                        <a href="/role/edit/{{ $role->id }}" data-toggle="tooltip" title="Sunting"><span class="btn bg-info-400 badge-icon rounded-circle"><i class="icon-pen"></i></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
