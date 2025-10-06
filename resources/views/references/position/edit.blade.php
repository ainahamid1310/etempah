@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/reference/position" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Pengurusan Data Rujukan >
            Jawatan</a>
        <span class="breadcrumb-item active"> Edit</span>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Senarai Jawatan</h5>
        </div>

        <form method="post" enctype="multipart/form-data">
            @csrf
            <table class="table datatable-basic table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 23%">Nama Jawatan</th>
                        <th style="width: 25%">Keterangan</th>
                        <th style="width: 12%">Status</th>
                        <th style="width: 15%">Tarikh Dicipta</th>
                        <th style="width: 25%" class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>#</td>
                        <td><input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $position->nama) }}" required></td>
                        <td>
                            <textarea name="keterangan" cols="30" rows="2"
                                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $position->keterangan) }}</textarea>
                        </td>

                        <td>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="aktif" @if (old('status', $position->status) == 'aktif') selected @endif>Aktif</option>
                                <option value="tidak aktif" @if (old('status', $position->status) == 'tidak aktif') selected @endif>Tidak Aktif
                                </option>
                            </select>
                        </td>
                        <td>{{ $position->created_at }}</td>


                        <td class="text-center">
                            <a href="/reference/department/edit/{{ encrypt($position->id) }}"><button class="submit"
                                    style="border: 0;"><span class="badge badge-success">Simpan</span></button></a>
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <div>
                        <a class="btn bg-teal btn-sm" href="/reference/position"><i class="icon-list mr-2"></i> Senarai
                            Jawatan</a>
                    </div>
                </div>
            </div>
            <br>
        </form>
    </div>
    </div>



    </div>
@endsection
