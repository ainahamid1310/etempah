@extends('layouts.backend_admin')

@section('js_themes')
<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

{{-- @section('page_header')
    <h1 class="h3 mb-4 text-gray-800">Pengurusan Data</h1>
@endsection --}}

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header header-elements-sm-inline">
            <h5 class="m-0 font-weight-bold text-teal" class="card-title"><b>Senarai Peranan</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/role/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Peranan</button></a>
            </div>
        </div>
        <div class="card-body">
            <table class="table datatable-columns">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Peranan</th>
                        <th class="text-center">Tindakan</th>
                        <th class="never"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td></td>
                            <td>{{ $role->name }}</td>
                            <td class="text-center">
                                <a href="/role/show/{{ $role->id }}"><button type="button" class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i class="icon-eye"></i></button>
                                <a href="/role/edit/{{ $role->id }}"><button type="button" class="btn btn-outline bg-success-400 text-success-800 btn-icon rounded-round"><i class="icon-pencil"></i></button></a>
                                <button type="button" class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round" id="sweet_combine_2" onclick="message({{ $role->id }})"><i class="icon-trash"></i></button>
                            </td>
                            <td></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <div class="text-md-right">
                <a href="/role/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Peranan</button></a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Page level plugins --}}
    <script src="/vendor/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    {{-- Page level custom scripts --}}
    <script src="/js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        function confirmation(event){
            event.preventDefault();
            swal({
                title: 'Adakah anda pasti?',
                text: 'Maklumat akan dipadam!',
                icon: "warning",
                buttons: ["Batal", "Ya!"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('delete-role').submit();
                }
            });
        }
    </script>
@endsection
