@extends('layouts.backend_applicant')

@section('breadcrumb')
    <div class="breadcrumb">
        <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Laman Utama</a>
        <span class="breadcrumb-item active"> Aduan Pemohon</span>

    </div>
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h5>Aduan Tempahan</h5>
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
                            <td><a href="/report/show/{{ $application->id }}">{{ $application->nama_mesyuarat }}</a>
                            </td>
                            <td>{{ $application->room->nama }}</td>
                            <td>{{ date('d-m-Y', strtotime($application->tarikh_mula)) }} -
                                {{ date('d-m-Y', strtotime($application->tarikh_hingga)) }}
                                <br>({{ date('h:i A', strtotime($application->tarikh_mula)) }} -
                                {{ date('h:i A', strtotime($application->tarikh_hingga)) }})
                            </td>
                            @if (!empty($application->applicationRoom))
                                <td>{{ $application->applicationRoom->statusRoom->status_pemohon }}</td>
                            @else
                                @if ($application->applicationVc->status_vc_id == '1' || $applicationVc->status_vc_id == '2' || $applicationVc->status_vc_id == '3' || $applicationVc->status_vc_id == '12')
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

                            @if (!empty($application->applicationVc->id))
                                <td>{{ $application->applicationVC->statusVc->status_pemohon }}</td>
                            @else
                                @if ($application->status_room_id == '1' || $application->status_vc_id == '2' || $application->status_vc_id == '14')
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

                                @if (!empty($application->report))
                                    <p class="text-center"><button type="button" class="btn btn-secondary"
                                            data-popup="popover" title="Aduan telah dibuat" data-trigger="focus"
                                            data-content="Klik Nama Mesyuarat untuk melihat aduan"><i
                                                class="
                                            icon-comment-discussion"></i>
                                            Aduan</button></p>
                                @else
                                    <p class="text-center"><button type="button" class="btn btn-danger"
                                            data-toggle="modal" data-target="#modal_aduan-{{ $application->id }}"><i
                                                class="icon-comment-discussion"></i>
                                            Aduan</button></p>
                                @endif
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

                    <form action="/admin/application_room/result/{{ $application->id }}" method="post"
                        onsubmit="validateForm()">
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

    @if ($errors->any())
        <script>
            $(function() {
                id = {{ $application->id }};
                $('#modal_aduan-' + id).modal({
                    show: true
                });
            });
        </script>
    @endif

    @foreach ($applications as $application)
        <div id="modal_aduan-{{ $application->id }}" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Aduan</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="/report/create" class="form-horizontal" class="swa-confirm" data-flag="0" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger alert-styled-right alert-dismissible">
                                        <button type="button" class="close"
                                            data-dismiss="alert"><span>&times;</span><span
                                                class="sr-only">Tutup</span></button>
                                        <ul class="list-unstyled">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-3">Aduan</label>
                                <div class="col-sm-9">
                                    <textarea rows="2" cols="3" class="form-control" placeholder="Aduan" name="aduan">{{ old('aduan') }}</textarea>
                                    <input type="hidden" name="applicationId"
                                        value="{{ old('applicationId', $application->id) }}">
                                    <input type="hidden" name="appear" value="index">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-sm-3">Cadangan Penambahbaikan</label>
                                <div class="col-sm-9">
                                    <textarea rows="2" cols="3" class="form-control" placeholder="Cadangan Penambahbaikan" name="cadangan">{{ old('cadangan') }}</textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn bg-primary">Hantar</button>
                            {{-- <button type="submit" class="btn btn-light">hantar sweet <i
                                    class="icon-play3 ml-2"></i></button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
        $(".swa-confirm").on("submit", function(e) {
            e.preventDefault();
            swal({
                title: $(this).data("swa-title"),
                text: $(this).data("swa-text"),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#cc3f44",
                confirmButtonText: $(this).data("swa-btn-txt"),
                closeOnConfirm: true,
                html: false
            }, function(confirmed) {
                if (confirmed)
                    $(this).closest('form').submit();
            });
        });
    </script>
@endsection
