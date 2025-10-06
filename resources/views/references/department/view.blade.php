@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/reference/department" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Pengurusan Data Rujukan >
            Bahagian</a>
        <span class="breadcrumb-item active"> Papar</span>

    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Senarai Bahagian</h5>
            <div class="header-elements">
                <div class="list-icons ml-3">
                    <a href="/reference/department/create" class="list-icons-item" placeholder="test"><i
                            class="icon-googleplus5 mr-1"></i>Tambah</a>
                    <a href="#" class="list-icons-item"><i class="icon-list mr-1"></i>Senarai</a>
                </div>
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
                        <a href="/reference/department/edit/{{ encrypt($department->id) }}"><span
                                class="badge badge-primary">Edit</span></a>



                    </td>
                </tr>

            <tbody>


            </tbody>
        </table>
    </div>
    </div>
@endsection
