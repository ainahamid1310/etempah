@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Pengurusan Data Rujukan > Bahagian</span>
    </div>
@endsection

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><b>Senarai Bahagian</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/reference/department/create"><button type="button"
                        class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah
                        Bahagian</button></a>
            </div>
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama Bahagian</th>
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 15%">Tarikh Dicipta</th>
                    <th style="width: 25%" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>#</td>
                        <td>{{ $department->nama }}</td>
                        <td>{{ $department->keterangan }}</td>
                        <td>
                            @if ($department->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($department->status == 'tidak aktif')
                                <span class="badge badge-warning">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $department->created_at }}</td>

                        <td class="text-center">
                            <form method="POST" action="/reference/department/destroy/{{ encrypt($department->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <a href="/reference/department/edit/{{ encrypt($department->id) }}"><button type="button"
                                        class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                            class="icon-pencil"></i></button></a>

                                <input name="_method" type="hidden" value="DELETE">
                                <button type="button"
                                    class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round delete"
                                    id="sweet_combine_2" onclick="message({{ $department->id }})"><i
                                        class="icon-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

        </table>
        <div class="text-md-right">
            <a href="/reference/department/create" class="list-icons-item" placeholder="test"><button type="button"
                    class="btn bg-blue btn-sm"><i class="icon-add mr-2"></i> Tambah Bahagian</button></p></a>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $('.delete').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal({
                    title: 'Adakah anda pasti?',
                    icon: "warning",
                    buttons: ["Tidak", "Ya!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
