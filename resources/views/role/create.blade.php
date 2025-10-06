@extends('layouts.backend_admin')

{{--
@section('page_header')
    <h2 class="h3 mb-4 text-gray-800">Pengurusan Data</h2>
@endsection --}}

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-teal">Daftar Peranan</h5>
                </div>
                    <form method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Peranan *</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Peranan" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">Tetapan Akses *</div>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    @foreach($permissions as $permission)
                                        <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $permission->id }}">
                                        <label class="form-check-label" for="permission">{{ $permission->name }}</label>
                                        <br/>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <button type="submit" class="btn btn-sm bg-blue-800"><i class="icon-add mr-2"></i> Simpan</button>
                        <a class="btn btn-sm bg-teal" href="/role"><i class="icon-list mr-2"></i> Senarai Peranan</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
