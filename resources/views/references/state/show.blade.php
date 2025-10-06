@extends('layouts.admin')

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/state" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai
            Negeri</span></a>
    <a href="/state/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i>
        <span>Daftar Negeri</span></a>
@endsection

@section('breadcrumb')
    <a href="/status" class="breadcrumb-item">Pengurusan Data Negeri</a>
    <span class="breadcrumb-item active">Maklumat Negeri</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Maklumat Negeri</legend>
        </div>

        <div class="card-body">
            <div class="table-responsive center" style="width: 70%; margin-left: auto; margin-right: auto;">

                <table class="table text-nowrap">
                    <tr>
                        <th style="width: 40%">Nama Negeri</th>
                        <td>{{ $state->nama }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $state->keterangan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $state->status }}</td>
                    </tr>
                </table>

            </div>

            <hr>

            <div class="form-group row">
                <div class="col-md-10 text-md-right">
                    <form class="delete" action="/state/destroy/{{ $state->id }}" method="POST">
                        <a href="/state" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a>
                        <a href="/state/edit/{{ Crypt::encrypt($state->id) }}"><span class="btn bg-primary"><i
                                    class="icon-pencil mr-2"></i> Sunting</span>
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <button type="submit" class="btn bg-danger submit-btn" title="Padam"><i
                                    class="icon-trash mr-2"></i> Padam</button>
                    </form>
                </div>
            </div>

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
