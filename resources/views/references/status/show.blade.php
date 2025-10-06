@extends('layouts.admin')

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/status" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Status</span></a>
    {{-- <a href="/status/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Status</span></a> --}}
@endsection

@section('breadcrumb')
    <a href="/status" class="breadcrumb-item">Pengurusan Data Status</a>
    <span class="breadcrumb-item active">Maklumat Status</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Maklumat Status</legend>
        </div>

        <div class="card-body">
            <div class="table-responsive center" style="width: 70%; margin-left: auto; margin-right: auto;">

                <table class="table text-nowrap">
                    <tr>
                        <th style="width: 40%">Status Pentadbiran</th>
                        <td>{{ $status->status_pentadbiran }}</td>
                    </tr>
                    <tr>
                        <th>Status Pemohon</th>
                        <td>{{ $status->status_pentadbiran }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pelantikan</th>
                        <td>
                            @if($status->cos == 1)
                                <span class="badge badge-primary">CoS</span>
                            @endif
                            @if($status->psh == 1)
                                <span class="badge badge-primary">PSH</span>
                            @endif
                            @if($status->pli == 1)
                                <span class="badge badge-primary">PLI</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $status->keterangan }}</td>
                    </tr>
                </table>

            </div>

            <hr>

            <div class="form-group row">
                <div class="col-md-10 text-md-right">
                    <a href="/status" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a>
                    {{-- <a href="/status/edit/{{ $status->id }}"><span class="btn bg-primary"><i class="icon-pencil mr-2"></i> Kemaskini</span> --}}
                </div>
            </div>

        </div>
    </div>
@endsection

