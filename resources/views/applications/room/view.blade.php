<fieldset>

    <div class="card-group-control card-group-control-left">

        <div class="card card bg-light">


            <div id="collapsible-control-group1" class="collapse show">

                {{-- <div class="card-header bg-white d-flex justify-content-between">
                    <strong>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
                            class="icon-info22 mr-3"></i></strong>
                </div> --}}

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
                                        value="{{ $application->applicationRoom->no_telefon_bimbit_urusetia }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
