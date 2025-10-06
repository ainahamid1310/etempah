@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Pengurusan Pengguna</span>
    </div>
@endsection

@section('content')

    <div class="card">
        {{-- <div class="card-header header-elements-inline">
        <h5 class="card-title">Senarai Pengguna</h5>
        <div class="header-elements">
            <div class="list-icons ml-3">
                <a href="/user/create" class="list-icons-item" placeholder="test"><button type="button" class="btn bg-blue btn-sm"><i class="icon-add mr-2"></i> Tambah Pengguna</button></p></a>
            </div>
        </div>
    </div> --}}
        <div class="card-header header-elements-sm-inline">
            <h5 class="card-title"><b>Senarai Pengguna</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/user/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i
                            class="icon-add"></i> Tambah Pengguna</button></a>
            </div>
        </div>

        <table class="table datatable-basic table-hover" style="font-size:13px; font-family:arial">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama Pengguna</th>
                    <th style="width: 23%">No.Kad Pengenalan</th>
                    <th style="width: 10%">E-mel</th>
                    <th style="width: 10%">Status</th>
                    {{-- <th style="width: 15%">Tarikh Dicipta</th> --}}
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
                            <form class="delete" method="POST" action="/user">
                                <a href="/user/show/{{ encrypt($user->id) }}"><button type="button"
                                        class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                            class="icon-eye"></i></button>
                                    <a href="/user/edit/{{ encrypt($user->id) }}"><button type="button"
                                            class="btn btn-outline bg-success-400 text-success-800 btn-icon rounded-round"><i
                                                class="icon-pencil"></i></button></a>
                                    <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    {{-- <button type="submit" class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round" data-toggle="tooltip" title='Hapus' id="sweet_combine_2" onclick="message({{ $user->id }})"><i class="icon-trash"></i></button> --}}
                                    <button type="button"
                                        class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round"
                                        id="sweet_combine_2" onclick="message({{ $user->id }})"><i
                                            class="icon-trash"></i></button>

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-md-right">
            <a href="/user/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i
                        class="icon-add"></i> Tambah Pengguna</button></a>
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
                confirmButtonText: 'YA',
                cancelButtonText: 'TIDAK',
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
