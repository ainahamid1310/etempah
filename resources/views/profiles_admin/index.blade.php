@extends('layouts.backend_admin')

@section('content')

<div class="content-wrapper">

    <!-- Content area -->
    <div class="content">
        <!-- content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Laman Utama</h6>
                    </div>

                    <div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">

                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Bil.</th>
                                    <th>Tujuan</th>
                                    <th>Lokasi</th>
                                    <th>Pengerusi</th>
                                    <th>Pemohon</th>
                                    <th>Masa</th>
                                    <th>Jenis Tempahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-active table-border-double">
                                    <td colspan="7">Tempahan Hari Ini</td>

                                </tr>
                                <tr>
                                    <td><span>1</span></td>
                                    <td><span>Mesyuarat Pengerusan BPM</span></td>
                                    <td><span>Bilik Comcec</span></td>
                                    <td><span>Pengarah BPM</span></td>
                                    <td><span>Mabel Dominic Madai</span></td>
                                    <td><span>10.30 am - 12.30 noon</span></td>
                                    <td><span><i class="icon-display4 mr-3 icon-2x"></i><i class="icon-users4"></i></span></td>


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
