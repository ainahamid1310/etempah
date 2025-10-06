@extends('layouts.backend_admin')

@section('js_themes')
<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
<div class="breadcrumb">
    <a href="/contact" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Hubungi Kami</a>
    {{-- <span class="breadcrumb-item active"> Bilik Mesyuarat  >  Profail Bilik Mesyuarat</span> --}}
</div>
@endsection

@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><b>Senarai Hubungi Kami</b></h5>
        <div class="col-lg-4 text-right">
            <a href="/contact/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Hubungi Kami</button></a>
        </div>
    </div>

    <table class="table datatable-basic table-hover">
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 25%">Nama Hubungi Kami</th>
                <th style="width: 25%">Keterangan</th>
                <th style="width: 10%">Status</th>
                <th style="width: 15%">Tarikh Dicipta</th>
                <th style="width: 25%" class="text-center">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>#</td>
                <td>{{ $contact->nama }}</td>
                <td>{{ $contact->keterangan }}</td>
                <td>
                    @if ($contact->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @elseif($contact->status == 'tidak aktif')
                        <span class="badge badge-warning">Tidak Aktif</span>
                    @endif
                </td>
                <td>{{ $contact->created_at}}</td>

                <td class="text-center">
                    <a href="/reference/contact/edit/{{ $contact->id }}"><button type="button" class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i class="icon-eye"></i></button></a>
                    <button type="button" class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round" id="sweet_combine_2" onclick="message({{ $contact->id }})"><i class="icon-trash"></i></button>
                </td>

                {{-- <td class="text-center">
                    <a href="/reference/contact/edit/{{ $contact->id }}"><span class="badge bg-blue-800"><i class="icon-pencil"></i></span></a>
                    <a href="#" onclick="message({{ $contact->id }})"><span class="badge badge-warning"><i class="icon-trash"></i></span></a>
                </td> --}}

                {{-- <td class="text-center">
                    <a href="/user/show/{{ $user->id }}"><button type="button" class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i class="icon-eye"></i></button>
                    <a href="/user/edit/{{ $user->id }}"><button type="button" class="btn btn-outline bg-success-400 text-success-800 btn-icon rounded-round"><i class="icon-pencil"></i></button></a>
                    <button type="button" class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round" id="sweet_combine_2" onclick="message({{ $user->id }})"><i class="icon-trash"></i></button>
                </td> --}}
            </tr>
            @endforeach

            <tbody>
                {{-- <tr>
                    <td>Marth</td>
                    <td><a href="#">Enright</a></td>
                    <td>Traffic Court Referee</td>
                    <td>22 Jun 1972</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                    <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                    <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr> --}}

        </tbody>
    </table>
    <div class="text-md-right">
        <a href="/contact/create"><button type="button" class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Hubungi Kami</button></a>
    </div>
<hr>
</div>
@endsection
