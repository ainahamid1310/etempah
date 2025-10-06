<body onload="webexSelected({{ $application->applicationVc->webex }})">
    <fieldset>

        <div class="card card bg-light">

            <div class="card-header">

            </div>

            <div class="card-body">

                <div class="form-group row">
                    <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input webex" name="webex" id="ya"
                                value="1" @if ($application->applicationVc->webex == '1') checked @endif
                                onclick="webexSelected(1)">
                            <label class="custom-control-label position-static" for="ya">Ya</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input webex" name="webex" id="tidak"
                                value="0" @if ($application->applicationVc->webex == '0') checked @endif
                                onclick="webexSelected(0)">
                            <label class="custom-control-label position-static" for="tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div id="div_nama_aplikasi" style="display: none">
                    {{-- @if (isset($application->applicationVc->nama_aplikasi)) --}}
                    <div class="form-group row">
                        <label for="nama_aplikasi"
                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}</label>
                        <div class="col-md-9">

                            <input id="nama_aplikasi" type="text" class="form-control" name="nama_aplikasi"
                                value="{{ old('nama_aplikasi', $application->applicationVc->nama_aplikasi) }}">
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>

                <div class="form-group row">
                    {{-- <label class="col-md-3 text-md-right">Memerlukan Peralatan VC</label>
                <div>
                    <div class="col-md-6 custom-control custom-control-right custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="peralatan" name="peralatan" value="1" @if ($application->applicationVc->peralatan == '1') checked  @endif>
                        <label class="col-md-3 custom-control-label position-static" for="peralatan"></label>
                    </div>
                </div> --}}

                    {{-- <div class="col-md-2">
                    <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="kamera" name="kamera" value="1" @if ($application->applicationVc->kamera == '1') checked  @endif>
                        <label class="custom-control-label position-static" for="kamera">Kamera</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="mikrofon" name="mikrofon" value="1" @if ($application->applicationVc->mikrofon == '1') checked  @endif>
                        <label class="custom-control-label position-static" for="mikrofon">Mikrofon</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="speaker" name="speaker" value="1" @if ($application->applicationVc->speaker == '1') checked  @endif>
                        <label class="custom-control-label position-static" for="speaker1">Speaker</label>
                    </div>
                </div> --}}

                </div>

                <div class="form-group row">
                    <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                    <div class="col-md-9">
                        <textarea rows="3" cols="3" class="form-control" name="catatan_vc">{{ $application->applicationVc->catatan }}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </fieldset>
