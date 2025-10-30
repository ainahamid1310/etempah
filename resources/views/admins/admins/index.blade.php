@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Pengurusan Pentadbir Bilik</span>
    </div>
@endsection

@section('content')

    <div class="card">

        <div class="card-header header-elements-sm-inline">
            <h5 class="card-title"><b>Senarai Pentadbir</b></h5>
            <div class="col-lg-4 text-right">
                {{-- <a href="/admin/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Pentadbir</button></a> --}}
            </div>
        </div>

        <table class="table datatable-basic table-hover" style="font-size:13px; font-family:arial">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama Pentadbir</th>
                    <th style="width: 23%">No.Kad Pengenalan</th>
                    <th style="width: 10%">E-mel</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 27%" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>#</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->no_kp }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->status == '1')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($user->status == '0')
                                <span class="badge badge-warning">Tidak Aktif</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="/admin/show/{{ encrypt($user->id) }}"><button type="button"
                                    class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                        class="icon-cogs"></i></button>
                               
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-md-right">
            {{-- <a href="/user/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Pentadbir</button></a> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function message(id) {
            swal.fire({
                title: 'Adakah anda pasti?',
                text: "Maklumat akan dipadam!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    window.location.href = '/user/destroy/' + id;
                }

            });

        }
    </script>
