@extends('layouts.backend_admin')

@section('js_themes')
<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('breadcrumb')
<div class="breadcrumb">
    {{-- <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a> --}}
    <a href="/contact" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Hubungi Kami</a>
    <span class="breadcrumb-item active"> Kemaskini</span>
</div>
@endsection

@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Kemaskini Hubungi Kami</h5>
        {{-- <div class="header-elements">
            <div class="list-icons ml-3">
                <a href="/reference/contact/create" class="list-icons-item" placeholder="test"><i class="icon-googleplus5 mr-1"></i>Tambah</a>
                <a href="#" class="list-icons-item"><i class="icon-list mr-1"></i>Senarai</a>
            </div>
        </div> --}}
    </div>

    <form method="post" enctype="multipart/form-data">
    @csrf
        <table class="table datatable-basic table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 23%">Nama Bahagian</th>
                    <th style="width: 25%">Keterangan</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 15%">Tarikh Dicipta</th>
                    <th style="width: 25%" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td><input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $contact->nama) }}" required></td>
                    <td><textarea name="keterangan" cols="30" rows="2" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $contact->keterangan) }}</textarea></td>

                    <td>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="aktif" @if (old('status', $contact->status) == 'aktif') selected @endif>Aktif</option>
                            <option value="tidak aktif" @if (old('status', $contact->status) == 'tidak aktif') selected @endif>Tidak Aktif</option>
                        </select>
                    </td>
                    <td>{{ $contact->created_at}}</td>
                    <td class="text-center">
                        <a href="/reference/contact/edit/{{ $contact->id }}"><button class="submit" style="border: 0;"><span class="badge badge-success">Simpan</span></button></a>
                        <a href=""><span class="badge badge-warning">Hapus</span></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <div class="list-icons ml-3">
                    {{-- <button type="submit" class="btn bg-blue-800 btn-sm"><i class="icon-add mr-2"></i> Simpan</button> --}}
                    <a class="btn bg-teal btn-sm" href="/user"><i class="icon-list mr-2"></i> Senarai Pengguna</a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
