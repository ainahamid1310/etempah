<fieldset>
    @if (empty($application->applicationRoom))
        <legend>
            <div class="card-header bg-white d-flex justify-content-between">
                <span>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
                        class="icon-info22 mr-3"></i></span>
            </div>
        </legend>
    @endif
</fieldset>

{{-- <div class="card-header bg-white d-flex justify-content-between">
    <span>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
            class="icon-info22 mr-3"></i></span>
</div> --}}

<fieldset>
    <legend><b>Maklumat VC</b></legend>
    <div class="card bg-light">
        {{-- @if (!empty($contains)) Untuk recreate kena enable tick vc --}}
        @if (empty($contains))
            <div class="card-header">

                <div class="alert alert-danger border-0 alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"></button><i class="icon-info22 mr-1"></i>
                    <strong>Perhatian : </strong> </i>Sila <i>'tick'</i> sekiranya ingin membuat
                    permohonan kemudahan <b>Video Conference (VC)</b>.
                </div>

                <div class="form-group">
                    <div class="form-check form-check-inline form-check-right">
                        <label class="form-check-label">
                            <span class="text-primary">Permohonan Tempahan VC</span>
                            <input type="checkbox" id="vc_selected" name="vc_selected" value="1"
                                class="form-check-input" onclick="showHideForm()"
                                @if (old('vc_selected')) checked @endif>
                        </label>
                    </div>
                </div>
            </div>
        @endrole
        {{-- <div id="form_vc" @if (!empty($contains)) style="display: none" @endif> --}}
        <div id="form_vc" @if (empty($contains)) style="display: none" @endif>
            <div class="card-body">

                <div class="form-group row">

                    <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input" name="akaun_webex" id="ya"
                                value="1" onclick="webexSelected()"
                                @if (old('akaun_webex', $application->applicationVc->webex) == '1') checked @endif>
                            <label class="custom-control-label position-static" for="ya">Ya</label>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input" name="akaun_webex" id="tidak"
                                value="0" onclick="webexSelected()"
                                @if (old('akaun_webex', $application->applicationVc->webex) == '0') checked @endif>
                            <label class="custom-control-label position-static" for="tidak">Tidak</label>
                        </div>
                    </div>

                </div>

                <div class="form-group row">

                    <label class="col-md-3 text-md-right">Memerlukan Peralatan VC <br><span
                            class="text-muted">(Mikrofon, Speaker,
                            Kamera)</span></label>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input" name="peralatan" id="peralatan_ya"
                                value="1" @if (old('peralatan', $application->applicationVc->peralatan) == '1') checked @endif>
                            <label class="custom-control-label position-static" for="peralatan_ya">Ya</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input" name="peralatan" id="peralatan_tidak"
                                value="0" @if (old('peralatan', $application->applicationVc->peralatan) == '0') checked @endif>
                            <label class="custom-control-label position-static" for="peralatan_tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="catatan" class="col-md-3 col-form-label text-md-right">
                        {{ __('Catatan Pemohon') }}
                    </label>
                    <div class="col-md-9">
                        <textarea rows="2" cols="2" class="form-control" name="catatan_vc"
                            @if ($contains == 1) readonly @endif>{{ old('catatan_vc', optional($application->applicationVc)->catatan) }}</textarea>
                    </div>
                </div>
                

                {{-- @if ($application->applicationVc->webex == '1') --}}
                <div id="div_webex" style="display: none">
                    <fieldset>
                        <legend><i class="icon-user"></i>Tindakan Penyelia VC</legend>
                        <div class="form-group row">
                            <label for="link_webex"
                                class="col-md-3 col-form-label text-md-right">{{ __('Log Masuk WEBEX') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                {{-- <input type="hidden" name="link_webex" value="{{ $application->applicationVc->webex }}"> --}}
                                @if (!empty($application->applicationVc->link_webex))
                                    <input type="text" class="form-control" id="link_webex" name="link_webex"
                                        value="{{ $application->applicationVc->link_webex }}">
                                @else
                                    <input type="text" class="form-control" id="link_webex" name="link_webex"
                                        value="{{ old('link_webex', 'miti.webex.com') }}">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_webex" class="col-md-3 col-form-label text-md-right">{{ __('ID WEBEX') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                {{-- <input type="hidden" name="webex" value="{{ $application->applicationVc->webex }}"> --}}
                                @if (!empty($application->applicationVc->id_webex))
                                    <input type="text" class="form-control" id="id_webex" name="id_webex"
                                        value="{{ $application->applicationVc->id_webex }}"
                                        placeholder="id@miti.gov.my">
                                @else
                                    <input type="text" class="form-control" id="id_webex" name="id_webex"
                                        value="{{ old('id_webex') }}" placeholder="id@miti.gov.my">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_webex"
                                class="col-md-3 col-form-label text-md-right">{{ __('Kata laluan WEBEX') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="password_webex"
                                    id="password_webex"
                                    value="{{ old('password_webex', $application->applicationVc->password_webex) }}"
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_expired"
                                class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Luput Kata laluan') }}
                                <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                @if (!empty($application->applicationVc->password_expired))
                                    <input class="form-control" type="date" id="password_expired"
                                        name="password_expired"
                                        value="{{ old('password_expired', date('Y-m-d', strtotime($application->applicationVc->password_expired))) }}">
                                @else
                                    <input class="form-control" type="date" id="password_expired"
                                        name="password_expired" value="{{ old('password_expired') }}">
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>
                {{-- @endif --}}

                <div id="div_nama_aplikasi" style="display: none">

                    <div class="form-group row">
                        <label for="nama_aplikasi"
                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input id="nama_aplikasi" type="text"
                                class="form-control @error('no_extension') is-invalid @enderror""
                                name="nama_aplikasi" placeholder="Contoh :  Google Meet, Zoom, MS Team"
                                value="{{ old('nama_aplikasi', $application->applicationVc->nama_aplikasi) }}">
                        </div>
                    </div>

                </div>

                @role('approver-vc')
                    <div class="form-group row">
                        <label for="catatan_vc_penyelia"
                            class="col-md-3 col-form-label text-md-right">{{ __('Catatan Penyelia') }}</label>
                        <div class="col-md-9">
                            <textarea rows="2" cols="2" class="form-control" id="catatan_vc_penyelia" name="catatan_vc_penyelia"
                                @role('user') readonly @endrole>{{ old('catatan_vc_penyelia', $application->applicationVc->catatan_penyelia) }}</textarea>
                        </div>
                    </div>
                @endrole


                @if (!empty($recreate)) {{-- Kalau recreate, nak remove status --}}
                    <div class="form-group row">
                        <label for="status_vc"
                            class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                        <div class="col-md-9">
                            @if ($application->applicationVc->status_vc_id == '2')
                                <span
                                    class="badge badge-primary">{{ $application->applicationVc->statusVc->status_pentadbiran }}</span>
                            @elseif($application->applicationVc->status_vc_id == '3')
                                <span
                                    class="badge badge-success">{{ $application->applicationVc->statusVc->status_pentadbiran }}</span>
                            @elseif($application->applicationVc->status_vc_id == '4')
                                <span
                                    class="badge badge-danger">{{ $application->applicationVc->statusVc->status_pentadbiran }}</span>
                            @else
                                <span
                                    class="badge badge-secondary">{{ $application->applicationVc->statusVc->status_pentadbiran }}</span>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>

</div>

</fieldset>
