<fieldset>

    <div class="card-group-control card-group-control-left">

        <div class="card card bg-light">


            <div id="collapsible-control-group1" class="collapse show">

                <div class="card-header bg-white d-flex justify-content-between">
                    <span>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon</a></span>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <div class="form-check form-check-inline form-check-right">
                            <label class="form-check-label">
                                <span class="text-default">Maklumat Urusetia</span>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nama"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                                <div class="col-md-8">
                                    <input id="nama_urusetia" type="text" class="form-control " name="nama_urusetia"
                                        value="{{ $application->applicationRoom->nama_urusetia }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-mel') }}</label>
                                <div class="col-md-8">
                                    <input id="email_urusetia" type="text" class="form-control" name="email_urusetia"
                                        value="{{ $application->applicationRoom->emel_urusetia }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="jawatan_urusetia"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Jawatan') }}</label>
                                <div class="col-md-8">
                                    <input id="jawatan_urusetia" type="text" class="form-control"
                                        name="jawatan_urusetia"
                                        value="{{ $application->applicationRoom->position->nama }}" readonly>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bahagian_urusetia"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>
                                <div class="col-md-8">
                                    <input id="bahagian_urusetia" type="text" class="form-control"
                                        name="bahagian_urusetia"
                                        value="{{ $application->applicationRoom->department->nama }}" readonly>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_sambungan_urusetia"
                                    class="col-md-4 col-form-label text-md-right">{{ __('No.Sambungan') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no_sambungan_urusetia"
                                        value="{{ $application->applicationRoom->no_extension_urusetia }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_bimbit_urusetia"
                                    class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no_bimbit_urusetia"
                                        value="{{ $application->applicationRoom->no_telefon_bimbit_urusetia }}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="card card bg-light">
        <div class="card-header bg-white d-flex justify-content-between">
            <span class="text-default">Maklumat Mesyuarat</span>
        </div>

        <?php
        if ($application->applicationRoom->kategori_mesyuarat == '1') {
            $kategori_mesyuarat = 'Mesyuarat Pengurusan Tertinggi';
        } elseif ($application->applicationRoom->kategori_mesyuarat == '2') {
            $kategori_mesyuarat = 'Mesyuarat Lain-lain';
        }
        ?>

        <div class="card-body">
            <div class="form-group row">
                <label for="kategori_mesyuarat"
                    class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="kategori_mesyuarat"
                        @if ($application->applicationRoom->kategori_mesyuarat == '1') value="Mesyuarat Pengurusan Tertinggi"
                    @elseif($application->applicationRoom->kategori_mesyuarat == '2')
                        value="Mesyuarat Lain-lain" @endif
                        readonly>

                </div>
            </div>

            <div class="form-group row">
                <label for="penganjur" class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="penganjur"
                        value="{{ $application->applicationRoom->penganjur }}" readonly>

                </div>
            </div>

            <div id="div_nama_penganjur" style="display: none">
                <div class="form-group row">
                    <label for="nama_penganjur"
                        class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="nama_penganjur"
                            value="{{ $application->applicationRoom->nama_penganjur }}" readonly>
                    </div>
                </div>
            </div>

            @if (!empty($application->applicationRoom->surat))
                <div class="form-group row">
                    <label for="surat_emel"
                        class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                    <div class="col-md-9">
                        <a href="{{ asset($application->applicationRoom->surat) }}" target="_blank"><i
                                class="icon-attachment mr-3"></i></a>
                    </div>
                </div>
            @endif

            <div class="form-group row">
                <label for="sajian" class="col-md-3 col-form-label text-md-right">{{ __('Sajian') }}</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="sajian"
                        value="{{ $application->applicationRoom->sajian }}" readonly>

                </div>
            </div>

            @if ($application->applicationRoom->sajian == 'Katerer Luar')
                <div class="form-group row">
                    <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                    <div class="col-md-2">
                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input"
                                @if ($application->applicationRoom->minum_pagi == '1') checked @endif>
                            <label class="custom-control-label position-static" for="minum_pagi">Minum
                                Pagi</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input"
                                @if ($application->applicationRoom->makan_tengahari == '1') checked @endif>
                            <label class="custom-control-label position-static" for="makan_tengahari">Makan
                                Tengahari</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input"
                                @if ($application->applicationRoom->minum_petang == '1') checked @endif>
                            <label class="custom-control-label position-static" for="minum_petang">Minum
                                Petang</label>
                        </div>
                    </div>
                </div>
            @endif

            @if ($application->applicationRoom->sajian == 'Pantri Dalaman')
                <div class="form-group row">
                    <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                    <div class="col-md-2">
                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="minum_pagi"
                                @if ($application->applicationRoom->minum_pagi == '1') checked @endif disabled>
                            <label class="custom-control-label position-static" for="minum_pagi">Minum
                                Pagi</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="minum_petang"
                                @if ($application->applicationRoom->minum_petang == '1') checked @endif disabled>
                            <label class="custom-control-label position-static" for="minum_petang">Minum
                                Petang</label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group row">
                <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                <div class="col-md-9">
                    <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room">{{ $application->applicationRoom->catatan }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="status_room" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                <div class="col-md-9">
                    @if ($application->applicationRoom->status_room_id == '1')
                        <span
                            class="badge badge-primary">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                    @elseif($application->applicationRoom->status_room_id == '2')
                        <span
                            class="badge badge-success">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                    @elseif($application->applicationRoom->status_room_id == '4')
                        <span
                            class="badge badge-danger">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                    @else
                        <span
                            class="badge badge-secondary">{{ $application->applicationRoom->statusRoom->status_pentadbiran }}</span>
                    @endif
                    {{-- <input type="text" class="form-control" name="status_room" value="{{ $application->applicationRoom->statusRoom->status_pentadbiran }}" readonly> --}}
                </div>
            </div>

        </div>
    </div>

</fieldset>

<!-- Basic modal -->
<div id="modal_default" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

            </div>

            <div class="modal-body">
                <h6 class="font-weight-semibold">Maklumat Pemohon</h6>
                {{-- Papar Maklumat Pemohon --}}
                <div class="card bg-light">

                    {{-- <div id="papar_maklumat_pemohon" class="collapse"> --}}
                    <div class="card-body">
                        <table class="table table-lg">
                            <tbody>

                                <tr>
                                    <td class="text-right"><span class="text-default">Nama</span></td>
                                    <td>{{ $application->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="text-default">E-mel</span></td>
                                    <td>{{ $application->user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="text-default">Jawatan</span>
                                    </td>
                                    <td>{{ $application->user->profile->position->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="text-default">Bahagian</span>
                                    </td>
                                    <td>{{ $application->user->profile->department->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="text-default">No.
                                            Sambungan</span>
                                    </td>
                                    <td>{{ $application->user->profile->no_extension }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="text-default">No. Telefon
                                            Bimbit</span></td>
                                    <td>{{ $application->user->profile->no_bimbit }}</td>
                                </tr>

                            </tbody>
                        </table>


                    </div>

                </div>
                {{-- Borang Urusetia --}}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /basic modal -->
