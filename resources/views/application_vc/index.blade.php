@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Rekod Pemohon</span>

    </div>
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h5>
                @if ($tag == '1')
                    Rekod Tempahan
                @elseif($tag == '2')
                    Sejarah Tempahan
                @endif
            </h5>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-hover datatable-highlight">

                <thead>
                    <tr>
                        <th style="width: 26%">Nama Mesyuarat</th>
                        <th style="width: 18%">Nama Bilik</th>
                        {{-- <th style="width: 14%">Pengerusi</th> --}}
                        <th style="width: 18%">Tarikh (Masa)</th>
                        <th style="width: 9%">Status Bilik</th>
                        <th style="width: 9%">Status VC</th>
                        <th style="width: 20%" class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($applications as $application)
                        <tr>
                            <td><a
                                    href="/application/show/{{ $application->id }}">{{ $application->nama_mesyuarat }}</a>
                            </td>
                            <td>{{ $application->room->nama }}</td>
                            {{-- <td>{{ $application->nama_pengerusi }}</td> --}}
                            <td>{{ date('d-m-Y', strtotime($application->tarikh_mula)) }} -
                                {{ date('d-m-Y', strtotime($application->tarikh_hingga)) }}
                                <br>({{ date('h:i A', strtotime($application->tarikh_mula)) }} -
                                {{ date('h:i A', strtotime($application->tarikh_hingga)) }})
                            </td>
                            @if (!empty($application->applicationRoom))
                                <td>{{ $application->applicationRoom->statusRoom->status_pemohon }}</td>
                            @else
                                @if (!empty($application->applicationVc))
                                    @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2' || $application->applicationVc->status_vc_id == '3' || $application->applicationVc->status_vc_id == '12')
                                        <td>
                                            @if (empty($application->applicationRoom))
                                                <a href="/application/edit/{{ $application->id }}"><span
                                                        style="width: 10%;"><span class="badge badge-success">Mohon
                                                            Bilik</span></a>
                                            @endif
                                        </td>
                                    @else
                                        <td><span style="width: 10%;"><span class="badge badge-secondary">Tiada</span></td>
                                    @endif
                                @endif
                            @endif

                            @if (!empty($application->applicationVc))
                                <td>{{ $application->applicationVC->statusVc->status_pemohon }}</td>
                            @else
                                @if ($application->applicationRoom->status_room_id == '1' || $application->applicationRoom->status_vc_id == '2' || $application->applicationRoom->status_vc_id == '14')
                                    <td>
                                        @if (empty($application->applicationVc))
                                            <a href="/application/edit/{{ $application->id }}"><span
                                                    style="width: 10%;"><span class="badge badge-success">Mohon
                                                        VC</span></a>
                                        @endif
                                    </td>
                                @else
                                    <td><span style="width: 10%;"><span class="badge badge-secondary">Tiada</span></td>
                                @endif
                            @endif

                            <td>
                                {{-- Button --}}
                                <a href="/application/recreate/{{ $application->id }}"><button type="button"
                                        class="btn btn-outline bg-primary text-primary btn-icon rounded-round"
                                        data-toggle="tooltip" title='Salin'><i class="icon-stack-plus"></i></button></a>

                                @if (!empty($application->applicationRoom))
                                    @if (!empty($application->applicationVc))
                                        {{-- ROOM & VC --}}

                                        @if ($application->applicationRoom->status_room_id == '1' || $application->applicationRoom->status_room_id == '2' || $application->applicationRoom->status_room_id == '14')
                                            @if ($application->applicationRoom->status_room_id == '1')
                                                <a href="/application/edit/{{ $application->id }}"><button type="button"
                                                        class="btn btn-outline bg-info-400 text-info-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Kemaskini Room/VC'><i
                                                            class="icon-pencil"></i></button></a>
                                            @endif

                                            @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2' || $application->applicationVc->status_vc_id == '3' || $application->applicationVc->status_vc_id == '9' || $application->applicationVc->status_vc_id == '12')
                                                <a href="/application/show/{{ $application->application_id }}"><button
                                                        type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal Bilik/VC'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @else
                                                <a href="/application/show/{{ $application->application_id }}"><button
                                                        type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal Bilik'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @endif
                                        @else
                                            @if ($application->applicationVc->status_vc_id == '2')
                                                <a href="/application/show/{{ $application->id }}"><button type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal VC'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @endif
                                        @endif
                                    @else
                                        {{-- ROOM --}}
                                        @if ($application->applicationRoom->status_room_id == '1')
                                            <a href="/application/edit/{{ $application->id }}"><button type="button"
                                                    class="btn btn-outline bg-info-400 text-info-800 btn-icon rounded-round"
                                                    data-toggle="tooltip" title='Kemaskini Room'><i
                                                        class="icon-pencil"></i></button></a>
                                            <a href="/application/show/{{ $application->id }}"><button type="button"
                                                    class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                    data-toggle="tooltip" title='Batal Bilik'><i
                                                        class="icon-cancel-circle2"></i></button></a>
                                        @elseif($application->applicationRoom->status_room_id == '2')
                                            <a href="/application/show/{{ $application->id }}"><button type="button"
                                                    class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                    data-toggle="tooltip" title='Batal Bilik'><i
                                                        class="icon-cancel-circle2"></i></button></a>
                                        @endif
                                    @endif

                                    {{-- @if ($application->applicationRoom->status_room_id == '1')
                                        @if (!empty($application->applicationVc))
                                            @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2')
                                                <a href="/application/show/{{ $application->application_id }}"><button type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal Bilik/VC'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @endif
                                        @else
                                            <a href="/application/show/{{ $application->application_id }}"><button type="button"
                                                    class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                    data-toggle="tooltip" title='Batal Bilik'><i
                                                        class="icon-cancel-circle2"></i></button></a>
                                        @endif
                                    @endif --}}
                                @elseif(!empty($application->applicationVc))
                                    {{-- VC --}}
                                    @if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2' || $application->applicationVc->status_vc_id == '3')
                                        <a href="/application/edit/{{ $application->id }}"><button type="button"
                                                class="btn btn-outline bg-info-400 text-info-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Kemaskini (VC)'><i
                                                    class="icon-pencil"></i></button></a>

                                        <a href="/application/show/{{ $application->id }}"><button type="button"
                                                class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Batal VC'><i
                                                    class="icon-cancel-circle2"></i></button></a>

                                        {{-- @elseif($application->applicationVc->status_vc_id == '3')
                                        <a href="/application/show/{{ $application->application_id }}"><button type="button"
                                                class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Batal VC'><i
                                                    class="icon-cancel-circle2"></i></button></a> --}}
                                    @endif
                                @endif

                                {{-- <a href="/application/recreate/{{ $application->application_id }}"><button type="button"
                                        class="btn btn-outline bg-primary text-primary btn-icon rounded-round"
                                        data-toggle="tooltip" title='Salin'><i class="icon-stack-plus"></i></button></a> --}}

                                {{-- Permohonan Pembatalan --}}
                                {{-- @if (!empty($application->applicationRoom))
                                    @if ($application->applicationRoom->status_room_id == '2' || $application->applicationRoom->status_room_id == '14')
                                        <a href="/application/show/{{ $application->application_id }}"><button type="button"
                                                class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Permohonan Pembatalan'><i
                                                    class="icon-cancel-circle2"></i></button></a>
                                    @elseif($application->applicationRoom->status_room_id == '3')
                                        @if (!empty($application->applicationVc))
                                            @if ($application->applicationVc->status_vc_id == '3')
                                                <a href="/application/show/{{ $application->application_id }}"><button type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal VC'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @endif
                                        @endif --}}
                                {{-- @else
                                    @if ($application->applicationVc->status_vc_id == '3' || $application->applicationRoom->status_room_id == '12')
                                        <a href="/application/show/{{ $application->application_id }}"><button type="button"
                                                class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Permohonan Pembatalan'><i
                                                    class="icon-cancel-circle2"></i></button></a>
                                    @endif --}}
                                {{-- @endif
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @foreach ($applications as $application)
        <div id="modalBatal_room_vc" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title">Pembatalan</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="/admin/application_room/result/{{ $application->id }}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group row">
                                <div class="col-lg-10">

                                    <div class="form-group">
                                        <label class="font-weight-semibold">Pilihan</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="option_cancel[]" value="room"
                                                    class="form-check-input">
                                                Bilik
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="option_cancel[]" value="vc"
                                                    class="form-check-input">
                                                VC
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="button" value="7" class="btn bg-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
