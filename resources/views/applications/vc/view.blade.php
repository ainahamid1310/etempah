<fieldset>

    <div class="card-group-control card-group-control-left">
        <div class="card bg-light">        

            <div class="card-header bg-white d-flex justify-content-between">
                <strong>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
                        class="icon-info22 mr-3"></i></strong>
            </div>
              <div class="card-body ps-3">
                 <div class="mb-3">
                    <strong class="fw-bold text-dark">Maklumat VC</strong>

                    <div class="ps-3">
                        
                        <div style="padding-left: 4rem;">     

                            @php
                                $webex = $application->applicationVc->webex;
                                $webexLabel = $webex == '1' ? 'Ya' : ($webex == '0' ? 'Tidak' : '-');
                            @endphp

                            <div class="d-flex py-2 border-bottom align-items-center">
                                <div class="fw-semibold text-dark" style="min-width: 180px;">Memerlukan Akaun WEBEX</div>
                                <div class="flex-grow-1 text-muted">{{ $webexLabel }}</div>
                            </div>

                            @php
                                $peralatan = $application->applicationVc->peralatan;
                                $peralatanLabel = $peralatan == '1' ? 'Ya' : ($peralatan == '0' ? 'Tidak' : '-');
                            @endphp

                            <div class="d-flex py-2 border-bottom align-items-center">
                                <div class="fw-semibold text-dark" style="min-width: 180px;">Memerlukan Peralatan VC</div>
                                <div class="flex-grow-1 text-muted">{{ $peralatanLabel }}</div>
                            </div>

                            @if ($application->applicationVc->webex == '0')
                                <div class="d-flex py-2 border-bottom align-items-center">
                                    <div class="fw-semibold text-dark" style="min-width: 180px;">Nama Aplikasi</div>
                                    <div class="flex-grow-1 text-muted">
                                        {{ $application->applicationVc->nama_aplikasi ?: '-' }}
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex py-2 border-bottom align-items-start">
                                <div class="fw-semibold text-dark" style="min-width: 180px;">Catatan Pemohon</div>
                                <div class="flex-grow-1 text-muted">
                                    {{ $application->applicationVc->catatan ?: '-' }}
                                </div>
                            </div>

                            {{-- @if ($application->applicationVc->status_vc_id == '3') --}}
                            <div id="div_webex" style="display: none">
                                <fieldset>
                                    <legend><i class="icon-user"></i>Tindakan Penyelia VC</legend>
                                    <div class="form-group row">
                                        <label for="link_webex"
                                            class="col-md-3 col-form-label text-md-right">{{ __('Log Masuk WEBEX') }}
                                            <span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                         
                                            @if (!empty($application->applicationVc->link_webex))
                                                <input type="text" class="form-control" id="link_webex" name="link_webex"
                                                    value="{{ $application->applicationVc->link_webex }}" readonly>
                                            @else
                                                <input type="text" class="form-control" id="link_webex" name="link_webex"
                                                    value="{{ old('link_webex', 'miti.webex.com') }}" readonly>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="id_webex" class="col-md-3 col-form-label text-md-right">{{ __('ID WEBEX') }}
                                            <span class="text-danger">*</span></label>
                                        <div class="col-md-9">                                        
                                            @if (!empty($application->applicationVc->id_webex))
                                                <input type="text" class="form-control" id="id_webex" name="id_webex"
                                                    value="{{ $application->applicationVc->id_webex }}" readonly>
                                            @else
                                                <input type="text" class="form-control" id="id_webex" name="id_webex"
                                                    value="{{ old('id_webex', '@miti.gov.my') }}" readonly>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password_webex"
                                            class="col-md-3 col-form-label text-md-right">{{ __('Kata laluan WEBEX') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="password_webex"
                                                value="{{ old('password_webex', $application->applicationVc->password_webex) }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password_expired"
                                            class="col-md-3 col-form-label text-md-right">{{ __('Tarikh Luput Kata laluan') }}
                                            <span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            @if (!empty($application->applicationVc->password_expired))
                                                <input class="form-control" type="date" id="password_expired"
                                                    name="password_expired" readonly
                                                    value="{{ old('password_expired', date('Y-m-d', strtotime($application->applicationVc->password_expired))) }}">
                                            @else
                                                <input class="form-control" type="date" id="password_expired" readonly
                                                    name="password_expired" value="{{ old('password_expired') }}">
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            {{-- @endif --}}

                            @if ($application->applicationVc->status_vc_id == 3 ||
                                $application->applicationVc->status_vc_id == 4 ||
                                $application->applicationVc->status_vc_id == 5 ||
                                $application->applicationVc->status_vc_id == 10 ||
                                $application->applicationVc->status_vc_id == 11)
                                <div class="form-group row">
                                    <label for="catatan_vc_penyelia"
                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Penyelia') }}</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="2" class="form-control" name="catatan_vc_penyelia" readonly>{{ $application->applicationVc->catatan_penyelia }}</textarea>
                                    </div>
                                </div>
                            @endif

                        
                            @if($application->applicationVc->status_vc_id == '4' && is_null($application->applicationVc->komen_ditolak))
                                <div class="form-group row">
                                    <label for="catatan_room_penyelia"
                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Ditolak/Batal') }}</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="2" class="form-control" name="catatan_vc_penyelia" readonly>{{ $application->applicationRoom->komen_ditolak }}</textarea>
                                    </div>
                                </div>
                            @elseif($application->applicationVc->status_vc_id == '4' && !is_null($application->applicationVc->komen_ditolak))
                                <div class="form-group row">
                                    <label for="catatan_vc_penyelia"
                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Ditolak/Batal') }}</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="2" class="form-control" name="catatan_vc_penyelia" readonly>{{ $application->applicationVc->komen_ditolak }}</textarea>
                                    </div>
                                </div>
                            @endif

                        </div>   

                    </div>
                </div>
              </div>
        </div>        
    </div>
</fieldset>