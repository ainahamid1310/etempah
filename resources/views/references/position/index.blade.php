@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Pengurusan Data Rujukan > Jawatan</span>
    </div>
@endsection

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><b>Senarai Jawatan</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/reference/position/create"><button type="button"
                        class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah
                        Jawatan</button></a>
            </div>
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama Jawatan</th>
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 15%">Tarikh Dicipta</th>
                    <th style="width: 25%" class="text-center">Tindakan</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($positions as $position)
                    <tr>
                        <td>#</td>
                        <td>{{ $position->nama }}</td>
                        <td>{{ $position->keterangan }}</td>
                        <td>
                            @if ($position->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($position->status == 'tidak aktif')
                                <span class="badge badge-warning">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $position->created_at }}</td>

                        {{-- <td class="text-center">
                            <a href="/reference/position/edit/{{ $position->id }}"><button type="button"
                                    class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                        class="icon-pencil"></i></button></a>
                            <a href="/reference/position/destroy/{{ $position->id }}"><button type="button"
                                    class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round"
                                    id="sweet_combine_2" onclick="message({{ $position->id }})"><i
                                        class="icon-trash"></i></button></a>
                        </td> --}}

                        <td class="text-center">
                            <form method="POST" action="/reference/position/destroy/{{ encrypt($position->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <a href="/reference/position/edit/{{ encrypt($position->id) }}"><button type="button"
                                        class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                            class="icon-pencil"></i></button></a>

                                <input name="_method" type="hidden" value="DELETE">
                                <button type="button"
                                    class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round delete"
                                    id="sweet_combine_2" onclick="message({{ $position->id }})"><i
                                        class="icon-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    </div>
@endsection

@section('script')
    <script>
        $('.submit-btn').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Adakah anda pasti?',
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
