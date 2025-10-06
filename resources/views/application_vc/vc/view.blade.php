<fieldset>
    <div class="card card bg-light">

        <div class="card-body">

            <div class="form-group row">
                <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                <div class="col-md-1">
                    <div class="custom-control custom-control-right custom-radio">
                        <input type="radio" class="custom-control-input"
                            @if ($application->applicationVc->webex == '1') checked @endif>
                        <label class="custom-control-label position-static" for="ya">Ya</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="custom-control custom-control-right custom-radio">
                        <input type="radio" class="custom-control-input"
                            @if ($application->applicationVc->webex == '0') checked @endif>
                        <label class="custom-control-label position-static" for="tidak">Tidak</label>
                    </div>
                </div>
            </div>

            @if ($application->applicationVc->webex == '0')
                <div class="form-group row">
                    <label for="nama_aplikasi"
                        class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}</label>
                    <div class="col-md-9">
                        <input id="nama_aplikasi" type="text" class="form-control" name="nama_aplikasi"
                            value="{{ $application->applicationVc->nama_aplikasi }}" readonly>
                    </div>
                </div>
            @endif

            <div class="form-group row">
                <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                <div class="col-md-9">
                    <textarea rows="3" cols="3" class="form-control" name="catatan_vc" readonly>{{ $application->applicationVc->catatan }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="status_vc" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
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

            @if ($application->applicationVc->statusVc == '3')
                <div class="form-group row">
                    <label for="id_webex" class="col-md-3 col-form-label text-md-right">{{ __('ID WEBEX') }}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="webex" name="id_webex"
                            @if (!empty($application->applicationVc->id_webex)) disabled @endif
                            value="{{ old('id_webex', $application->applicationVc->id_webex) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_webex"
                        class="col-md-3 col-form-label text-md-right">{{ __('Kata laluan WEBEX') }}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="password_webex"
                            @if (!empty($application->applicationVc->password_webex)) disabled @endif
                            value="{{ old('password_webex', $application->applicationVc->password_webex) }}">
                    </div>
                </div>
            @endif


        </div>

    </div>

</fieldset>
