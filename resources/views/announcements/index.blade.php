@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <span class="breadcrumb-item active"> Informasi Umum</span>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><b>Senarai Informasi Umum</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/announcement/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i
                            class="icon-add"></i> Tambah Informasi Umum</button></a>
            </div>
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama Informasi Umum</th>
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 10%">Kategori</th>
                    <th style="width: 15%">Tarikh Dicipta</th>
                    <th style="width: 25%" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>#</td>
                        <td>{{ $announcement->nama }}</td>
                        <td>{{ $announcement->keterangan }}</td>
                        <td>
                            @if ($announcement->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($announcement->status == 'tidak aktif')
                                <span class="badge badge-warning">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if ($announcement->kategori == 'Bilik')
                                <span class="badge badge-primary">Bilik</span>
                            @elseif($announcement->kategori == 'VC')
                                <span class="badge badge-success">VC</span>
                            @endif
                        </td>
                        <td>{{ $announcement->created_at }}</td>

                        <td class="text-center">
                            {{-- <a href="/announcement/edit/{{ $announcement->id }}"><button type="button"
                                    class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                        class="icon-eye"></i></button></a> --}}
                            {{-- <button type="button" class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round"
                                id="sweet_combine_2" onclick="message({{ $announcement->id }})"><i
                                    class="icon-trash"></i></button> --}}

                            <form method="POST" action="{{ route('announcement.delete', $announcement->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <a href="/announcement/edit/{{ encrypt($announcement->id) }}"><button type="button"
                                        class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                            class="icon-pencil"></i></button></a>

                                <input name="_method" type="hidden" value="DELETE">
                                <button type="button"
                                    class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round show_confirm"
                                    id="sweet_combine_2" onclick="message({{ $announcement->id }})"><i
                                        class="icon-trash"></i></button>
                            </form>

                        </td>

                    </tr>
                @endforeach

            <tbody>

            </tbody>
        </table>
        <div class="text-md-right">
            <a href="/announcement/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i
                        class="icon-add"></i> Tambah Informasi Umum</button></a>
        </div>
        <hr>
    </div>

    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Adakah Anda Pasti?`,
                    text: "Maklumat Akan Dipadam!",
                    icon: "warning",
                    buttons: true,
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
