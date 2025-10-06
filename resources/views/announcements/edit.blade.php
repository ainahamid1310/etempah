@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        @role('approver-room')
            <a href="/announcement?i=room" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Informasi Umum</a>
        @endrole
        @role('approver-vc')
            <a href="/announcement?i=vc" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Informasi Umum</a>
        @endrole
        <span class="breadcrumb-item active"> Kemaskini</span>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Kemaskini Informasi Umum</h5>
        </div>

        <form method="post" enctype="multipart/form-data">
            @csrf
            <table class="table datatable-basic table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 23%">Nama Informasi Umum</th>
                        <th style="width: 25%">Keterangan</th>
                        <th style="width: 12%">Status</th>
                        <th style="width: 12%">Kategori</th>
                        {{-- <th style="width: 15%">Tarikh Dicipta</th> --}}
                        <th style="width: 25%" class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#</td>
                        <td><input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $announcement->nama) }}" required></td>
                        <td>
                            <textarea name="keterangan" cols="30" rows="2"
                                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $announcement->keterangan) }}</textarea>
                        </td>

                        <td>
                            <select name="status" class="form-control select-search @error('status') is-invalid @enderror">
                                <option value="aktif" @if (old('status', $announcement->status) == 'aktif') selected @endif>Aktif</option>
                                <option value="tidak aktif" @if (old('status', $announcement->status) == 'tidak aktif') selected @endif>Tidak Aktif
                                </option>
                            </select>
                        </td>

                        <td>
                            <select name="kategori"
                                class="form-control select-search @error('Kategori') is-invalid @enderror">
                                @role('super-admin|approver-room')
                                    <option value="Bilik" @if (old('kategori', $announcement->kategori) == 'Bilik') selected @endif>Bilik</option>
                                @endrole
                                @role('super-admin|approver-vc')
                                    <option value="VC" @if (old('kategori', $announcement->kategori) == 'VC') selected @endif>VC
                                    </option>
                                @endrole
                            </select>
                        </td>

                        <td class="text-center">
                            <a href="/announcement/edit/{{ encrypt($announcement->id) }}"><button class="submit"
                                    style="border: 0;"><span class="badge badge-success">Simpan</span></button></a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
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
            <hr>
        </form>
    </div>
@endsection
