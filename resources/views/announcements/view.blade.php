@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/announcement" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Informasi Umum</a>
        <span class="breadcrumb-item active"> Papar</span>

    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Senarai Informasi Umum</h5>
            <div class="header-elements">
                <div class="list-icons ml-3">
                    @role('approver-room')
                        <a class="btn bg-teal btn-sm" href="/announcement?i=room"><i class="icon-list mr-2"></i> Senarai
                            Informasi
                            Umum</a>
                    @endrole
                    @role('approver-vc')
                        <a class="btn bg-teal btn-sm" href="/announcement?i=vc"><i class="icon-list mr-2"></i> Senarai
                            Informasi
                            Umum</a>
                    @endrole
                </div>
            </div>
        </div>

        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Nama Informasi Umum</th>
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 10%">Kategori</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 25%" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>#</td>
                    <td>{{ $announcement->nama }}</td>
                    <td>{{ $announcement->keterangan }}</td>

                    <td>
                        @if ($announcement->kategori == 'Bilik')
                            <span class="badge badge-success">Bilik</span>
                        @elseif($announcement->kategori == 'VC')
                            <span class="badge badge-primary">VC</span>
                        @endif
                    </td>

                    <td>
                        @if ($announcement->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($announcement->status == 'tidak aktif')
                            <span class="badge badge-warning">Tidak Aktif</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="/announcement/edit/{{ encrypt($announcement->id) }}"><span
                                class="badge badge-primary">Edit</span></a>
                        {{-- <a href=""><span class="badge badge-warning">Hapus</span></a> --}}
                    </td>
                </tr>

            <tbody>

            </tbody>
        </table>
    </div>
    </div>
@endsection
