@extends('layouts.admin')

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('title')
    <i class="icon-database-menu mr-2"></i> <span class="font-weight-semibold">Pengurusan Data</span>
@endsection

@section('top_button')
    <a href="/grade" class="btn btn-link btn-float text-default"><i class="icon-list2 text-primary"></i> <span>Senarai
            Gred</span></a>
    <a href="/grade/create" class="btn btn-link btn-float text-default"><i class="icon-plus-circle2 text-primary"></i>
        <span>Daftar Gred</span></a>
@endsection

@section('breadcrumb')
    <a href="/grade" class="breadcrumb-item">Pengurusan Data Gred</a>
    <span class="breadcrumb-item active">Maklumat Gred</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="text-uppercase text-info-800 font-weight-bold">Maklumat Gred</legend>
        </div>

        <div class="card-body">
            <div class="table-responsive center" style="width: 70%; margin-left: auto; margin-right: auto;">

                <table class="table text-nowrap">
                    <tr>
                        <th style="width: 40%">Gred</th>
                        <td>{{ $grade->nama }}</td>
                    </tr>
                    <tr>
                        <th>Kumpulan Perkhidmatan</th>
                        <td>{{ $grade->kumpulan_perkhidmatan }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $grade->keterangan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $grade->status }}</td>
                    </tr>
                </table>
            </div>

            <hr>

            <div class="form-group row">
                <div class="col-md-10 text-md-right">
                    <form class="delete" action="/grade/destroy/{{ $grade->id }}" method="POST">
                        {{ csrf_field() }}
                        <a href="/grade" class="btn btn-light"><i class="icon-backward2 mr-2"></i> Kembali</a>
                        <a href="/grade/edit/{{ Crypt::encrypt($grade->id) }}"><span class="btn bg-primary"><i
                                    class="icon-pencil mr-2"></i> Sunting</span>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn bg-danger submit-btn"><i class="icon-trash mr-2"></i>
                                Padam</button>
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
