@extends('layouts.backend_applicant')

@section('content')

<div class="content-wrapper">

    <!-- Content area -->
    <div class="content">
        <!-- content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Maklumat Carian</h6>
                    </div>

                    <div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">

                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Bil.</th>
                                    <th>Nama Mesyuarat</th>
                                    <th>Nama Bilik</th>
                                    <th>Pengerusi</th>
                                    {{-- <th>Pemohon</th> --}}
                                    <th>Tarikh/Masa</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr class="table-active table-border-double">
                                    <td colspan="7">Tempahan Hari Ini</td>

                                </tr> --}}
                                <tr>
                                    <td><span>1</span></td>
                                    <td><span>Mesyuarat Pengerusan BPM</span></td>
                                    <td><span>Bilik Comcec</span></td>
                                    <td><span>Pengarah BPM</span></td>
                                    {{-- <td><span>Mabel Dominic Madai</span></td> --}}
                                    <td>
                                        <p>10/01/2021</p>
                                        <span class="text-muted">10.30 am - 12.30 noon</span>
                                    </td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-info btn-sm"></i> Mohon VC</button> --}}
                                        <button type="button" class="btn btn-success btn-sm"></i> Pinda</button>
                                        <button type="button" class="btn btn-warning btn-sm"></i> Batal</button>
                                    </td>
                                    {{-- <td><span><i class="icon-display4 mr-3 icon-2x"></i><i class="icon-users4"></i></span></td> --}}


                            </tbody>
                        </table>
                    </div>
                </div>


            </div>


        </div>
        <!-- /content -->

    </div>
    <!-- /content area -->

</div>
@endsection
