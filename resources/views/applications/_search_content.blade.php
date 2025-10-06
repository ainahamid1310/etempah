@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Carian Tempahan</span>

    </div>
@endsection

@section('css')
    {{-- <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> --}}
@endsection

@section('js_themes')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> --}}
@endsection


@section('content')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header header-elements-inline bg-light">
                <h5 class="card-title">Carian Tempahan</h5>
            </div>
            <form>

                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Nama Mesyuarat: </label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="nama_mesyuarat"
                                        value="{{ $mesyuarat }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">ID Permohonan: </label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="id_permohonan"
                                        value="{{ $id_permohonan }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Bilik: </label>
                                <div class="col-md-8">
                                    <select class="form-control select-search select-clear" name="nama_bilik"
                                        data-placeholder="Pilih Bilik" data-fouc>
                                        <option></option>

                                        @foreach ($rooms as $room)
                                            @if ($bilik == $room->id)
                                                <option value="{{ $room->id }}" selected>
                                                    {{ $room->nama }}
                                                </option>
                                            @else
                                                <option value="{{ $room->id }}"> {{ $room->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh Mula: </label>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="date_start">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-lg-right">Tarikh Tamat: </label>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="date_end">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-success" name="cari" value="cari">Semak </button>
                        @if ($cari)
                            @if ($layout_role == 'pengguna')
                                <a href="/application/applicant/create"> <button type="button" class="btn bg-info">Mohon
                                        Tempahan
                                    </button></a>
                            @endif
                        @endif
                    </div>

                </div>
            </form>

            <div class="content">
                <div class="card">
                    @if ($cari)                       
			            <table class="table table-bordered table-hover datatable-highlight" style="width:100%"> 
                            <thead>
                                <tr style="text-align:center">
                                    <th style="width: 5%">Bil.</th>
                                    <th style="width: 5%">ID Batch</th>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 15%">Nama Mesyuarat</th>
                                    <th style="width: 15%">Bilik</th>
                                    <th style="width: 20%">Tarikh / Masa</th>
                                    <th style="width: 10%">Nama Pemohon</th>
                                    <th style="width: 10%">Bahagian</th>
                                    <th style="width: 10%">Tarikh Mohon</th>
                                    @role('super-admin|admin-room|approver-room|approver-vc')
                                    <th style="width: 5%">Status</th>
                                    @endrole

                                </tr>
                            </thead>
                            <tbody>
                                @if ($carian)
                                    <?php
                                    $x = 1;
                                    ?>

                                    @foreach ($carian as $carian_application)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>#{{ $carian_application->batch_id }}</td>
                                            <td>{{ $carian_application->id }}</td>
                                            <td>

                                                @if ($layout_role == 'pengguna')
                                                    <a href="/application/show/{{ encrypt($carian_application->id) }}">{{ $carian_application->nama_mesyuarat }}
                                                    </a>
                                                @elseif($layout_role == 'admin_room')
                                                    <a
                                                        href="/admin/application_room/show/{{ encrypt($carian_application->application_id) }}">{{ $carian_application->nama_mesyuarat }}
                                                    </a>
                                                @elseif($layout_role == 'admin_vc')
                                                    <a
                                                        href="/admin/application_vc/show/{{ encrypt($carian_application->application_id) }}">{{ $carian_application->nama_mesyuarat }}
                                                    </a>
                                                @endif

                                            </td>
                                            <td>
                                                @role('user')
                                                @if(isset($carian_application->room))
                                                    {{ $carian_application->room->nama }}
                                                @endif

                                                @else
                                                    {{-- {{ $carian_application->application->room->nama }} --}}
                                                    {{ isset($carian_application->application->room) ? $carian_application->application->room->nama : '-' }}

                                                @endrole

                                            </td>
                                            <td> {{ \Carbon\Carbon::parse($carian_application->tarikh_mula)->format('d-m-Y') }}
                                                ({{ \Carbon\Carbon::parse($carian_application->tarikh_mula)->format('g:i A') }})
                                                -<br>
                                                {{ \Carbon\Carbon::parse($carian_application->tarikh_hingga)->format('d-m-Y') }}
                                                ({{ \Carbon\Carbon::parse($carian_application->tarikh_hingga)->format('g:i A') }})
                                            </td>
                                            <td>
                                                @role('user')
                                                     {{ $carian_application->user->name }}

                                                @else
                                                    {{ $carian_application->application->user->name }}

                                                @endrole
                                            </td>
                                            <td>
                                                @role('user')
                                                @if(isset($carian_application->room))
                                                    {{ $carian_application->user->profile->department->nama }}
                                                @endif


                                                @else
                                                {{ isset($carian_application->application->room) ? $carian_application->application->room->nama : '-' }}
                                                    {{-- {{ $carian_application->application->user->profile->department->nama }} --}}
                                                @endrole
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($carian_application->created_at)->format('d-m-Y g:i A') }}
                                            </td>
                                            @role('super-admin|admin-room|approver-room|approver-vc')
                                                <td>
                                                    @role('approver-room')
                                                        {{ $carian_application->statusRoom->status_pentadbiran }}
                                                    @elserole('approver-vc')
                                                        {{ $carian_application->statusVc->status_pentadbiran }}
                                                    @elserole('user')
                                                        {{ $carian_application->status_vc_id }}{{ $carian_application->status_room_id }}
                                                    @elserole('super-admin')
                                                        @if($layout_role == 'admin_room')
                                                            {{ $carian_application->statusRoom->status_pentadbiran }}
                                                        @elseif($layout_role == 'admin_vc')
                                                            {{ $carian_application->statusVc->status_pentadbiran }}
                                                        @endif
                                                    @endrole
                                                </td>
                                            @endrole

                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                                @if ($carian and count($carian) == 0)
                                    <tr>
                                        <td colspan="7" style="text-align: center; font-weight:bold">Tiada Rekod
                                            Dijumpai</td>
                                    <tr>
                                @endif
                    
                            </tbody>

                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <script>
        $('#example').dataTable({
            "ordering": false
        });
    </script>
@endsection
