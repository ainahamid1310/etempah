@extends('layouts.backend_admin')

@section('js_themes')
    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('js_extensions')
    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <a href="/contact" class="breadcrumb-item"></i> Hubungi Kami</a>
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
                        <th style="width: 20%">Nama</th>
                        <th style="width: 15%">Email</th>
                        <th style="width: 15%">No Telefon </th>
                        <th style="width: 15%">Peranan</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 15%" class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#</td>
                        <td><input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $contact->nama) }}" required></td>

                        <td><input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $contact->email) }}" required></td>

                        <td><input name="no_telefon_office" type="text"
                                class="form-control @error('no_telefon_office') is-invalid @enderror"
                                value="{{ old('no_telefon_office', $contact->no_telefon_office) }}" required></td>

                        <td>
                            <select name="role" class="form-control select-search @error('role') is-invalid @enderror">
                                @role('super-admin|approver-room')
                                    <option value="Pentadbir Bilik" @if (old('role', $contact->role) == 'Pentadbir Bilik') selected @endif>Pentadbir
                                        Bilik
                                    </option>

                                    <option value="Teknikal Sistem" @if (old('role', $contact->role) == 'Teknikal Sistem') selected @endif>Teknikal
                                        Sistem
                                    </option>
                                    <option value="PMSB" @if (old('role', $contact->role) == 'PMSB') selected @endif>PMSB
                                    </option>
                                    <option value="BizPoint" @if (old('role', $contact->role) == 'BizPoint') selected @endif>BizPoint
                                    </option>
                                @endrole
                                @role('super-admin|approver-vc')
                                    <option value="Pentadbir VC" @if (old('role', $contact->role) == 'Pentadbir VC') selected @endif>Pentadbir VC
                                    </option>
                                @endrole


                            </select>
                        </td>

                        <td>
                            <select name="status" class="form-control select-search @error('status') is-invalid @enderror">
                                <option value="aktif" @if (old('status', $contact->status) == 'aktif') selected @endif>Aktif</option>
                                <option value="tidak aktif" @if (old('status', $contact->status) == 'tidak aktif') selected @endif>Tidak Aktif
                                </option>
                            </select>
                        </td>

                        {{-- <td>{{ $contact->created_at }}</td> --}}
                        <td class="text-center">
                            <a href="/contact/edit/{{ encrypt($contact->id) }}"><button class="submit"
                                    style="border: 0;"><span class="badge badge-success">Simpan</span></button></a>


                            {{-- <form method="POST" action="{{ route('contact.delete', $contact->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input name="_method" type="hidden" value="DELETE">
                                <span class="badge badge-warning show_confirm">Hapus</span>
                            </form> --}}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <div class="list-icons ml-3">
                        {{-- <button type="submit" class="btn bg-blue-800 btn-sm"><i class="icon-add mr-2"></i> Simpan</button> --}}
                        <a class="btn bg-teal btn-sm" href="/contact"><i class="icon-list mr-2"></i> Senarai Hubungi
                            Kami</a>
                    </div>

                </div>
            </div>
            <br>
        </form>
    </div>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Adakah Anda Pasti?`,
                    text: "Maklumat Akan Dipadam!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
