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
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/grade" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai
            Gred</span></a>
    <a href="/grade/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i>
        <span>Daftar Gred</span></a>
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item active">Pengurusan Data Gred</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title text-uppercase text-info-800 font-weight-bold">Senarai Gred</h6>
        </div>

        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>
                    <th>Nama Gred</th>
                    <th>Kumpulan Perkhidmatan</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades as $grade)
                    <tr>
                        <td>{{ $grade->nama }}</td>
                        <td>{{ $grade->kumpulan_perkhidmatan }}</td>
                        <td>
                            @if ($grade->status == 'aktif')
                                <span class="badge badge-success text-uppercase">{{ $grade->status }}</span>
                            @else
                                <span class="badge badge-danger text-uppercase">{{ $grade->status }}</span>
                            @endif
                        </td>
                        <td>
                            <form class="delete" action="/grade/destroy/{{ $grade->id }}" method="POST">
                                {{ csrf_field() }}
                                <a href="/grade/show/{{ Crypt::encrypt($grade->id) }}" data-toggle="tooltip"
                                    title="Papar Maklumat"><span class="btn bg-primary-600 badge-icon rounded-round"><i
                                            class="icon-display"></i></span></a>
                                <a href="/grade/edit/{{ Crypt::encrypt($grade->id) }}" data-toggle="tooltip"
                                    title="Sunting"><span class="btn bg-info-400 badge-icon rounded-circle"><i
                                            class="icon-pen"></i></span></a>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn bg-danger-600 badge-icon rounded-round submit-btn"
                                    title="Padam"><i class="icon-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

@section('script')
    <script>
        $('.submit-btn').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Adakah anda pasti index?',
                showCancelButton: true,
                confirmButtonColor: '#22bb33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    </script>
@endsection
