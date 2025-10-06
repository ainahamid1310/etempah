@extends('layouts.backend_admin')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> </span>
    </div>
@endsection

@section('css')
    <!-- <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> -->
   
@endsection

@section('js_themes')
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
@endsection

@section('content')
    <div class="content">
        <div class="card">

            <div class="card-header">
                <h5>{{ $tajuk }}</h5>
            </div>
            <div class="card-body">

                <!-- <table id="example" class="display" style="width:100%"> -->
                <table style="width:100%" class="table table-bordered table-hover datatable-highlight">

                    <thead>
                        <tr class="bg-primary">
                            <th style="width:5%" class="text-center">ID</th>
                            <th style="width:20%" class="text-center">Nama Mesyuarat</th>
                            <th style="width:20%" class="text-center">Nama Bilik</th>
                            <th style="width:10%" class="text-center">Pengerusi</th>
                            <th style="width:25%" class="text-center">Tarikh <br>Mula-Tamat</th>                            
                            <th style="width:8%" class="text-center">Status</th>
                            <th style="width:12%" class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    @foreach ($batches as $batch_id => $apps)
                        @php
                            $first = $apps->first(); // ambil 1 rekod pertama untuk info umum
                            $nama_pengerusi = $first->kategori_pengerusi == 0 ? $first->nama_pengerusi : $first->kategori_pengerusi;
                            $status = $first->applicationRoom->status_room_id ?? null;
                            $statusClass = ($status == '3') ? 'text-danger text-center' : 'text-center';
                        @endphp

                        <tr>
                            <td class="{{ $statusClass }}">#{{ $batch_id }}</td>
                            <td class="{{ $statusClass }}">
                                <a href="/admin/application_room/show/{{ encrypt($first->id) }}">{{ $first->nama_mesyuarat }}</a>
                            </td>
                            <td class="{{ $statusClass }}">{{ $first->room->nama }}</td>
                            <td class="{{ $statusClass }}">{{ $nama_pengerusi }}</td>                          
                            <td class="{{ $statusClass }}">
                                @foreach($apps as $app)
                                    &bull; {{ date('d-m-Y', strtotime($app->tarikh_mula)) }} - {{ date('d-m-Y', strtotime($app->tarikh_hingga)) }}
                                    <br>
                                    <small><b>
                                        ({{ date('h:i A', strtotime($app->tarikh_mula)) }} - {{ date('h:i A', strtotime($app->tarikh_hingga)) }})
                                    </b></small>
                                    <br>
                                @endforeach
                            </td>
                            <td class="{{ $status == '3' ? 'text-danger text-center' : 'text-primary text-center' }}">
                                {{ $first->applicationRoom->statusRoom->status_pentadbiran ?? '-' }}
                            </td>

                            <td class="text-center"> 
                                @if (in_array($status, ['1','2','14'])) 
                                    <a href="/admin/application_room/show/{{ encrypt($first->id) }}"> 
                                        <button type="button" class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round" data-toggle="tooltip" title='Kelulusan/Pembatalan'>
                                        <i class="icon-stack-check"></i>
                                        </button> 
                                </a> 
                                @elseif($status == '3') 
                                    <a href="/admin/application_room/show/{{ encrypt($first->id) }}"> 
                                        <button type="button" class="btn btn-outline bg-primary-400 text-primary-800 btn-icon rounded-round" data-toggle="tooltip" title='Kelulusan/Pembatalan'><i class="icon-stack-check"></i>
                                        </button> 
                                </a> 
                                @endif @if ($status == '1')                            
                                    <a href="/admin/application_room/edit/{{ encrypt($first->batch_id) }}"> 
                                        <button type="button" class="btn btn-outline bg-success-400 text-success-800 btn-icon rounded-round" data-toggle="tooltip" title='Lulus Dengan Pindaan'><i class="icon-pencil"></i>
                                        </button> 
                                    </a> 
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('#example').dataTable({
            "ordering": false
        });
    </script>
@endsection
