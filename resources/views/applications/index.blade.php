@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Rekod Tempahan</span>

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
                        <th style="width: 4%">Batch ID</th>
                        <th style="width: 4%">ID</th>
                        <th style="width: 22%">Nama Mesyuarat</th>
                        <th style="width: 18%">Nama Bilik</th>
                        <th style="width: 26%" class="text-center">Tarikh (Masa)</th>
                        <th style="width: 8%">Status Bilik</th>
                        <th style="width: 8%">Status VC</th>
                        <th style="width: 10%" class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($applications as $groupId => $groupedApplications)
                    @php
                        $application = $groupedApplications->first();
                    @endphp
                        <tr>
                            <td>#{{ $groupId }}</td>
                            <td>{{ $application->id }}</td>
                            <td><a
                                    href="/application/show/{{ encrypt($application->id) }}">{{ $application->nama_mesyuarat }}</a>
                            </td>
                            <td>{{ $application->room->nama }}</td>
                            <td>
                                <ul style="padding-left: 15px; margin:0;">
                                    @foreach ($groupedApplications as $app)
                                        <li>
                                            {{ date('d-m-Y', strtotime($app->tarikh_mula)) }} - {{ date('d-m-Y', strtotime($app->tarikh_hingga)) }}
                                            <br>
                                            <small><b>({{ date('h:i A', strtotime($app->tarikh_mula)) }} - {{ date('h:i A', strtotime($app->tarikh_hingga)) }})</b></small>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            @if (!empty($application->applicationRoom))
                                <td>{{ $application->applicationRoom->statusRoom->status_pemohon }}</td>
                            @else
                                @if (!empty($application->applicationVc))
                                    @if ($application->applicationVc->status_vc_id == '1' ||
                                        $application->applicationVc->status_vc_id == '2' ||
                                        $application->applicationVc->status_vc_id == '3' ||
                                        $application->applicationVc->status_vc_id == '12')
                                        <td class="text-center">-
                                        </td>
                                    @else
                                        <td><span style="width: 10%;"><span class="badge badge-secondary">Tiada</span></td>
                                    @endif
                                @endif
                            @endif

                            @if (!empty($application->applicationVc))
                                <td>{{ $application->applicationVC->statusVc->status_pemohon }}</td>
                            @else
                                @if ($application->applicationRoom->status_room_id == '1' ||
                                    $application->applicationRoom->status_room_id == '2' ||
                                    $application->applicationRoom->status_room_id == '14')
                                    <td>
                                        @if (empty($application->applicationVc) && $application->tarikh_hingga >= Carbon\Carbon::now())
                                            <a href="/application/create_vc/{{ $application->batch_id }}"><span
                                                    style="width: 10%;"><span class="badge badge-success">Mohon
                                                        VC</span></a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @else
                                    <td><span style="width: 10%;"><span class="badge badge-secondary">Tiada</span></td>
                                @endif
                            @endif

                            <td>
                                {{-- Button --}}
                                @if ($tag == '1')
                                    <a href="/application/recreate/{{ encrypt($application->batch_id) }}"><button type="button"
                                            class="btn btn-outline bg-primary text-primary btn-icon rounded-round"
                                            data-toggle="tooltip" title='Salin'><i
                                                class="icon-stack-plus"></i></button></a>

                                    @if (!empty($application->applicationRoom))
                                        @if (!empty($application->applicationVc))
                                            {{-- ROOM & VC --}}

                                            @if ($application->applicationRoom->status_room_id == '1' ||
                                                $application->applicationRoom->status_room_id == '2' ||
                                                $application->applicationRoom->status_room_id == '14')
                                                @if ($application->applicationVc->status_vc_id == '1' ||
                                                    $application->applicationVc->status_vc_id == '2' ||
                                                    $application->applicationVc->status_vc_id == '3' ||
                                                    $application->applicationVc->status_vc_id == '9' ||
                                                    $application->applicationVc->status_vc_id == '12')
                                                    <a
                                                        href="/application/show/{{ encrypt($application->id) }}/?act=cancel_room_vc"><button
                                                            type="button"
                                                            class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                            data-toggle="tooltip" title='Batal Bilik/VC'><i
                                                                class="icon-cancel-circle2"></i></button></a>
                                                @else
                                                    <a
                                                        href="/application/show/{{ encrypt($application->id) }}/?act=cancel_vc"><button
                                                            type="button"
                                                            class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                            data-toggle="tooltip" title='Batal Bilik'><i
                                                                class="icon-cancel-circle2"></i></button></a>
                                                @endif
                                            @else
                                                @if ($application->applicationVc->status_vc_id == '2')
                                                    <a
                                                        href="/application/show/{{ encrypt($application->id) }}/?act=cancel_vc"><button
                                                            type="button"
                                                            class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                            data-toggle="tooltip" title='Batal VC'><i
                                                                class="icon-cancel-circle2"></i></button></a>
                                                @endif
                                            @endif
                                        @else
                                            {{-- ROOM --}}
                                            @if ($application->applicationRoom->status_room_id == '1')
                                                <a
                                                    href="/application/show/{{ encrypt($application->id) }}/?act=cancel_room"><button
                                                        type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal Bilik'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @elseif($application->applicationRoom->status_room_id == '2')
                                                <a
                                                    href="/application/show/{{ encrypt($application->id) }}/?act=cancel_room"><button
                                                        type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal Bilik'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @elseif($application->applicationRoom->status_room_id == '14')
                                                <a href="/application/show/{{ encrypt($application->id) }}/?act=cancel_vc"><button
                                                        type="button"
                                                        class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                        data-toggle="tooltip" title='Batal Bilik'><i
                                                            class="icon-cancel-circle2"></i></button></a>
                                            @endif
                                        @endif
                                    @elseif(!empty($application->applicationVc))
                                        {{-- VC --}}
                                        @if ($application->applicationVc->status_vc_id == '1' ||
                                            $application->applicationVc->status_vc_id == '2' ||
                                            $application->applicationVc->status_vc_id == '3')
                                            <a href="/application/show/{{ encrypt($application->id) }}/?act=cancel_vc"><button
                                                    type="button"
                                                    class="btn btn-outline bg-danger-400 text-danger-800 btn-icon rounded-round"
                                                    data-toggle="tooltip" title='Batal VC'><i
                                                        class="icon-cancel-circle2"></i></button></a>
                                        @endif
                                    @endif
                                @elseif($tag == '2')
                                    <a href="/application/recreate/{{ encrypt($application->id) }}"><button type="button"
                                            class="btn btn-outline bg-primary text-primary btn-icon rounded-round"
                                            data-toggle="tooltip" title='Salin'><i
                                                class="icon-stack-plus"></i></button></a>
                                @endif
                            </td>
                        </tr>
                @endforeach
                
                </tbody>
            </table>

        </div>
    </div>

@endsection
