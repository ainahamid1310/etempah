@extends('layouts.backend_admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-teal">Peranan</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Peranan</label>
                        <div class="col-sm-10 col-form-label">
                            {{ $role->name }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Tetapan Akses</label>
                        <div class="col-sm-10 col-form-label">
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <h5><span class="badge badge-pill bg-teal">{{ $v->name }}</span></h5>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <a class="btn btn-sm bg-blue-800" href="/role/edit/{{ $role->id }}"><i class="icon-add mr-2"></i> Edit</a>
                    <a class="btn btn-sm bg-teal" href="/role"><i class="icon-list mr-2"></i> Senarai Peranan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
