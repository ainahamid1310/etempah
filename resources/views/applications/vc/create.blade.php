<fieldset>
    <div class="card card bg-light">
        <div class="card-header">

            <div class="alert alert-danger border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"></button><i class="icon-info22 mr-1"></i>
                <strong>Perhatian : </strong> </i>Sila <i>'tick'</i> untuk membuat tempahan/permohonan <b>Video Conference (VC)</b>.
            </div>

            <div class="form-group">
                <div class="form-check form-check-inline form-check-right">
                    <label class="form-check-label">
                        {{-- <i class="icon-file-plus mr-2"></i> --}}
                        <span class="text-primary">Permohonan Tempahan VC</span>
                        <input type="checkbox" id="vc_selected" name="vc_selected" value="1"
                            class="form-check-input" onclick="showHideForm()"
                            @if (old('vc_selected')) checked @endif>

                    </label>
                </div>
            </div>
        </div>
        <div id="form_vc" style="display: none">
            <div class="card-body">
                <fieldset id="webex">                    

                    <div class="form-group row">
                        <label for="akaun_webex" class="col-md-3 col-form-label text-md-right">Adakah anda perlu akaun webex untuk mencipta pautan mesyuarat?</label>

                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input @error('akaun_webex') is-invalid @enderror"
                                    name="akaun_webex" id="ya" value="1" {{ old('akaun_webex') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input @error('akaun_webex') is-invalid @enderror"
                                    name="akaun_webex" id="tidak" value="0" {{ old('akaun_webex') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                           
                            @error('akaun_webex')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </fieldset>             

                <fieldset id="peralatan">                   

                    <div class="form-group row">
                        <label for="akaun_webex" class="col-md-3 col-form-label text-md-right">Memerlukan Peralatan VC <br><span
                                class="text-muted">(Mikrofon, Speaker,
                                Kamera)</span></label>

                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input @error('peralatan') is-invalid @enderror"
                                    name="peralatan" id="ya" value="1" {{ old('peralatan') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="ya">Ya</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input @error('peralatan') is-invalid @enderror"
                                    name="peralatan" id="tidak" value="0" {{ old('peralatan') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>                           
                            @error('peralatan')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <div id="div_nama_aplikasi" style="display: none">
                    <div class="form-group row">
                        <label for="nama_aplikasi"
                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Aplikasi') }}</label>
                        <div class="col-md-9">
                            <input id="nama_aplikasi" type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror" name="nama_aplikasi"
                                value="{{ old('nama_aplikasi') }}" placeholder="Contoh :  Google Meet, Zoom, MS Team"
                                autocomplete="nama_aplikasi">
                                @error('nama_aplikasi')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                    <div class="col-md-9">
                        <textarea rows="3" cols="3" class="form-control" placeholder="1.Sila nyatakan masa mula sesi VC&#10;2.Lain-lain catatan" name="catatan_vc">{{ old('catatan_vc') }}</textarea>
                    </div>
                    <span class="text-warning">Nota : ID WEBEX hanya akan diberikan dalam tempoh 5 hari bekerja sebelum tarikh program/mesyuarat bermula</span>
                </div>

            </div>
        </div>


    </div>
</fieldset>
