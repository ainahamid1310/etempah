<div class="text-center text-danger">-Tiada Permohonan VC-</div>
<fieldset>

    <div class="card card bg-light">

        <div class="card-header">
            <div class="form-group">
                <div class="form-check form-check-inline form-check-right">
                    <label class="form-check-label">
                        <span>Permohononan Tempahan VC</span>
                        <input type="checkbox" id="vc_selected" name="vc_selected" class="form-check-input"
                            onclick="showHideFormVc()">
                    </label>
                </div>
            </div>
        </div>

        <div id="form_vc" style="display: none">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 text-md-right">Memerlukan Akaun WEBEX</label>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input" name="webex" id="ya"
                                value="1" onclick="webexSelected()"
                                @if (old('webex') == '1') checked @endif>
                            <label class="custom-control-label position-static" for="ya">Ya</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="custom-control custom-control-right custom-radio">
                            <input type="radio" class="custom-control-input" name="webex" id="tidak"
                                value="0" onclick="webexSelected()"
                                @if (old('webex') == '0') checked @endif>
                            <label class="custom-control-label position-static" for="tidak">Tidak</label>
                        </div>
                    </div>
                </div>

                <div id="div_nama_aplikasi" style="display: none">
                    <div class="form-group row">
                        <label for="nama_aplikasi"
                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}</label>
                        <div class="col-md-9">
                            <input id="nama_aplikasi" type="text" class="form-control" name="nama_aplikasi"
                                value="{{ old('nama_aplikasi') }}" autocomplete="nama_aplikasi">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                    <div class="col-md-9">
                        <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_vc">{{ old('catatan_vc') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
</fieldset>
