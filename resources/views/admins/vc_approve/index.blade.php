@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Pengurusan Tempahan VC</span>

    </div>
@endsection

@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
@endsection

@section('js_themes')
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->

    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/global_assets/js/demo_pages/datatables_basic.js"></script>
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h5>{{ $tajuk }}</h5>
        </div>
        <div class="card-body">

            <table style="width:100%" class="table table-bordered table-hover datatable-highlight">
                <thead>
                    <tr class="bg-primary">
                        <th style="width: 5%">Batch ID</th>
                        <th style="width: 22%">Nama Mesyuarat</th>
                        <th style="width: 15%">Nama Bilik</th>
                        <th style="width: 10%">Pengerusi</th>
                        <th style="width:23%" class="text-center">Tarikh <br>Mula-Tamat</th>
                        <!-- <th style="width: 10%">Masa</th> -->
                        <th style="width: 10%">status</th>
                        @if ($status == '1')
                            <th style="width: 15%" class="text-center">Tindakan</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                      
                        <tr>
                            <td>#{{ $application->batch_id }}</td>
                            <td><a
                                    href="/admin/application_vc/show/{{ encrypt($application->id) }}">{{ $application->nama_mesyuarat }}</a>
                            </td>
                            <td>{{ $application->room->nama }}</td>
                            <td>{{ $application->nama_pengerusi }}</td>
                            <td>{{ date('d-m-Y', strtotime($application->tarikh_mula)) }} -
                                {{ date('d-m-Y', strtotime($application->tarikh_hingga)) }} <br>
                                <small><b>
                                    ({{ date('h:i A', strtotime($application->tarikh_mula)) }} - 
                                    {{ date('h:i A', strtotime($application->tarikh_hingga)) }})
                                </small></b>
                            </td>
                            <!-- <td>{{ date('h:i A', strtotime($application->tarikh_mula)) }} -
                                {{ date('h:i A', strtotime($application->tarikh_hingga)) }}
                            </td> -->
                            <td @if ($application->applicationVC->status_vc_id == '1') class="text-secondary" @endif>
                                {{ $application->applicationVC->statusVc->status_pentadbiran }}
                            </td>
                            @if ($status == '1')
                                <td class="text-center">
                                    @if ($application->applicationVc->status_vc_id != '1')
                                        <a href="/admin/application_vc/show/{{ encrypt($application->id) }}">
                                            <button type="button"
                                                class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Kelulusan/Pembatalan'><i
                                                    class="icon-stack-check"></i>
                                            </button>
                                        </a>

                                        {{-- <a href="/admin/application_vc/edit/{{ encrypt($application->id) }}">
                                            <button type="button"
                                                class="btn btn-outline bg-success-400 text-success-800 btn-icon rounded-round"
                                                data-toggle="tooltip" title='Lulus Dengan Pindaan'><i
                                                    class="icon-pencil"></i>
                                            </button>
                                        </a> --}}

                                        {{-- <button type="button"
                                            class="btn btn-outline bg-pink-400 text-pink-800 btn-icon rounded-round"
                                            id="sweet_combine_2" onclick="message({{ $application->applicationVc->id }})"
                                            data-toggle="tooltip" title='Hapus'><i class="icon-trash"></i>
                                        </button> --}}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endif
                        </tr>
                    
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>

    <script>
        $('#example').dataTable({
            "ordering": false
        });
    </script>
@endsection
