@extends('layouts.backend_applicant')

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

        </div>

        <div class="card-body">

            <table class="table datatable-button-html5-basic">
                <thead class="bg-blue-600">
                    <tr>
                        <th style="width: 35%; font-size: 0.9rem;">Nama Bilik</th>
                        <th style="width: 7%; font-size: 0.9rem;">Aras</th>
                        <th style="width: 5%; font-size: 0.9rem;">Kapasiti (Orang)</th>
                        <th style="width: 20%; font-size: 0.9rem;">Petugas</th>
                        <th style="width: 5%; font-size: 0.9rem;">Status</th>
                        <th style="width: 5%; font-size: 0.9rem;" class="text-center">Peralatan VC</th>
                        <th style="width: 5%; font-size: 0.9rem;" class="text-center">Projektor</th>
                        <th style="width: 5%; font-size: 0.9rem;" class="text-center">Pelulus</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td style="font-size: 0.8rem;"><a
                                    href="/reference/room_applicant/show/{{ encrypt($room->id) }}">{{ $room->nama }}</a></td>
                            <td style="font-size: 0.8rem;">{{ $room->aras }}</td>
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
                                    @if (!empty($room_user->user->name))
                                        <a data-popup="tooltip" title="{{ $room_user->user->name }}"
                                            data-placement="right"><i class="icon-user"></i></a>
                                    @endif
                                @endforeach

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
