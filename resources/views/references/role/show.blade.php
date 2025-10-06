@extends('layouts.admin')

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/role" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai Peranan</span></a>
    <a href="/role/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i> <span>Daftar Peranan</span></a>
@endsection

@section('breadcrumb')
    <a href="/role" class="breadcrumb-item">Pengurusan Data Peranan</a>
    <span class="breadcrumb-item active">Maklumat Peranan</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Maklumat Peranan</legend>
        </div>

        <div class="card-body">
            <div class="table-responsive center" style="width: 70%; margin-left: auto; margin-right: auto;">
                <table class="table text-nowrap">
                    <tr>
                        <th style="width: 40%">Nama Peranan</th>
                        <td>{{ $role->name }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $role->description }}</td>
                    </tr>
                    <tr>
                        <th>Guard</th>
                        <td>{{ $role->guard_name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ ($role->status == 1) ? 'Aktif' : 'Tidak Aktif' }}</td>
                    </tr>
                </table>
            </div>

            <hr>

            <div class="form-group row">
                <div class="col-md-10 text-md-right">
                    <form class="delete" action="/role/destroy/{{ $role->id }}" method="POST">
                        <a href="/role" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a>
                        @if($role->id !=  1)
                            <a href="/role/edit/{{ $role->id }}"><span class="btn bg-primary"><i class="icon-pencil mr-2"></i> Sunting</span>
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <button type="submit" class="btn bg-danger"><i class="icon-trash mr-2"></i> Padam</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".delete").on("submit", function(){
            return confirm("Adakah anda pasti?");
        });
    </script>
@endsection

