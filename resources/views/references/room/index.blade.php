@extends('layouts.backend_admin')

@section('js_themes')

@endsection

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Bilik Mesyuarat > Profil Bilik Mesyuarat</span>
    </div>
@endsection

@section('content')


    <div class="card">
        <div class="card-header header-elements-sm-inline">
            <h5 class="card-title"><b>Profil Bilik Mesyuarat</b></h5>
            <div class="col-lg-4 text-right">
                <a href="/reference/room/create"><button type="button"
                        class="btn alpha-blue text-blue-800 border-blue-600"><i class="icon-add"></i> Tambah Profil
                        Bilik</button></a>
            </div>
        </div>

        @if (!empty($msg))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <span>Profil bilik <b>tidak boleh</b> dihapuskan kerana terdapat penyelia bilik tersebut.</span>
            </div>
        @endif

        <div class="card-body">

            <table class="table datatable-button-html5-basic">
                <thead>
                    <tr>
                        <th style="width: 33%; font-size: 0.9rem;">Nama Bilik</th>
                        <th style="width: 5%; font-size: 0.9rem;">Kapasiti (Orang)</th>
                        <th style="width: 22%; font-size: 0.9rem;">Petugas</th>
                        <th style="width: 5%; font-size: 0.9rem;">Status</th>
                        <th style="width: 5%; font-size: 0.9rem;" class="text-center">Peralatan VC</th>
                        <th style="width: 5%; font-size: 0.9rem;" class="text-center">Projektor</th>
                        <th style="width: 5%; font-size: 0.9rem;" class="text-center">Penyelia</th>
                        <th style="width: 20%; font-size: 0.9rem;" class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td style="font-size: 0.8rem;">{{ $room->nama }}</td>
                            {{-- <td style="font-size: 0.8rem;">{{ $room->aras }}</td> --}}
                            <td style="font-size: 0.8rem;">{{ $room->kapasiti }}</td>
                            <td style="font-size: 0.8rem;">{{ $room->nama_petugas }}</td>
                            <td style="font-size: 0.8rem;">
                                @if ($room->status == '1')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($room->status == '0')
                                    <span class="badge badge-warning">Tidak Aktif</span>
                                @endif
                            </td>
                            <td style="font-size: 0.9rem;">
                                <div class="text-center">
                                    @if ($room->is_equipment == 'Y')
                                        <i class="icon-checkmark2"></i>
                                    @endif
                                </div>
                            </td>
                            <td style="font-size: 0.9rem;">
                                <div class="text-center">
                                    @if ($room->is_projector == 'Y')
                                        <i class="icon-checkmark2"></i>
                                    @endif
                                </div>
                            </td>
                            <td style="font-size: 0.8rem;">
                                @foreach ($room->roomUsers as $room_user)
                                    {{-- checking sebab live ada problem nak appear username --}}
                                    @if (!empty($room_user->user->name))
                                        <a data-popup="tooltip" title="{{ $room_user->user->name }}"
                                            data-placement="right"><i class="icon-user"></i></a>
                                    @endif
                                @endforeach
                            </td>

                            <td class="text-center">
                                <form class="delete" method="POST" action="/reference/room">
                                    <a href="/reference/room/show/{{ encrypt($room->id) }}"><button type="button"
                                            class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"><i
                                                class="icon-eye"></i></button>
                                        <a href="/reference/room/edit/{{ encrypt($room->id) }}"><button type="button"
                                                class="btn btn-outline bg-success-400 text-success-800 btn-icon rounded-round"><i
                                                    class="icon-pencil"></i></button></a>
                                        <input name="_method" type="hidden" value="DELETE">
                                        {{ csrf_field() }}
                                        <button type="button"
                                            class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round"
                                            id="sweet_combine_2" onclick="message({{ $room->id }})"><i
                                                class="icon-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function message(id) {
            swal.fire({
                title: 'Adakah anda pasti?',
                text: "Maklumat akan dipadam!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    window.location.href = '/reference/room/destroy/' + id;
                }

            });

        }
    </script>
