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
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Hubungi Kami</span>


    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><b>Senarai Hubungi Kami</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/contact/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i
                            class="icon-add"></i> Tambah Hubungi Kami</button></a>
            </div>
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama</th>
                    <th style="width: 25%">No Telefon</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 15%">Kategori</th>
                    <th style="width: 25%" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>#</td>
                        <td>{{ $contact->nama }}</td>
                        <td>{{ $contact->no_telefon_office }}</td>
                        <td>
                            @if ($contact->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($contact->status == 'tidak aktif')
                                <span class="badge badge-warning">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if ($contact->role == 'Pentadbir Bilik')
                                <span class="badge badge-primary">Pentadbir Bilik</span>
                            @elseif($contact->role == 'Pentadbir VC')
                                <span class="badge badge-success">Pentadbir VC</span>
                            @elseif($contact->role == 'Teknikal Sistem')
                                <span class="badge badge-success">Teknikal Sistem</span>
                            @elseif($contact->role == 'PMSB')
                                <span class="badge badge-secondary">PMSB</span>
                            @elseif($contact->role == 'BizPoint')
                                <span class="badge badge-secondary">BizPoint</span>
                            @endif

                        </td>

                        <td class="text-center">
                            <form method="POST" action="{{ route('contact.delete', $contact->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <a href="/contact/edit/{{ encrypt($contact->id) }}"><button type="button"
                                        class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                            class="icon-pencil"></i></button></a>

                                <input name="_method" type="hidden" value="DELETE">
                                <button type="button"
                                    class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round show_confirm"
                                    id="sweet_combine_2" onclick="message({{ $contact->id }})"><i
                                        class="icon-trash"></i></button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            <tbody>

            </tbody>
        </table>

        <hr>
    </div>

    <script type="text/javascript">
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
