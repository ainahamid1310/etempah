
<fieldset>

    <div class="card-group-control card-group-control-left">

        <div class="card bg-light">

            <div id="collapsible-control-group1" class="collapse show">

                <div class="card-header bg-white d-flex justify-content-between">
                    <span class="text-default"><i class="icon-user mr-1"></i><b>Maklumat Urusetia</b></span>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <div class="form-check form-check-inline form-check-right">
                            <label class="form-check-label">
                                <span>Maklumat Seperti <a href="#" data-toggle="modal"
                                        data-target="#modal_default"><i class="fas fa-info-circle mr-1"></i>Pemohon</a></span>
                                <input type="checkbox" id="copy_applicant" name="copy_applicant"
                                    class="form-check-input" title="Salin">                                    
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nama"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                                <div class="col-md-8">
                                    <input id="nama_urusetia" type="text"
                                        class="form-control @error('nama_urusetia') is-invalid @enderror"
                                        name="nama_urusetia"
                                        value="{{ old('nama_urusetia') }}"
                                        autocomplete="off">

                                    @error('nama_urusetia')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-mel') }}</label>
                                <div class="col-md-8">
                                    <input id="email_urusetia" type="text" class="form-control @error('email_urusetia') is-invalid @enderror" name="email_urusetia"
                                        value="{{ old('email_urusetia') }}" autocomplete="no_sambungan">
                                    @error('email_urusetia')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                    @enderror
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
                                    <select name="jawatan_urusetia" id="jawatan_urusetia"
                                        data-placeholder="Pilih Jawatan" class="form-control select-search @error('jawatan_urusetia') is-invalid @enderror">
                                        <option></option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                @if (old('jawatan_urusetia') == $position->id) selected @endif>
                                                {{ $position->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jawatan_urusetia')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bahagian_urusetia"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>
                                <div class="col-md-8">
                                    <select name="bahagian_urusetia" id="bahagian_urusetia"
                                        data-placeholder="Pilih Bahagian" class="form-control select-search @error('bahagian_urusetia') is-invalid @enderror">
                                        <option></option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if (old('bahagian_urusetia') == $department->id) selected @endif>
                                                {{ $department->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('bahagian_urusetia')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                    @enderror
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
                                    <input id="no_sambungan_urusetia" type="text" class="form-control @error('no_sambungan_urusetia') is-invalid @enderror"
                                        name="no_sambungan_urusetia" value="{{ old('no_sambungan_urusetia') }}"
                                        autocomplete="no_sambungan_urusetia">
                                        @error('no_sambungan_urusetia')
                                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_bimbit_urusetia"
                                    class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>
                                <div class="col-md-8">
                                    <input id="no_bimbit_urusetia" type="text" class="form-control @error('no_bimbit_urusetia') is-invalid @enderror"
                                        name="no_bimbit_urusetia" value="{{ old('no_bimbit_urusetia') }}"
                                        autocomplete="no_bimbit">
                                        @error('no_bimbit_urusetia')
                                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                                        @enderror
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
            <span class="text-default"><i class="icon-briefcase3 mr-1"></i><b>Maklumat Mesyuarat</b></span>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <label for="kategori_mesyuarat"
                    class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                <div class="col-md-9">
                    <select name="kategori_mesyuarat" data-placeholder="Pilih Kategori Mesyuarat"
                        class="form-control select-search @error('kategori_mesyuarat') is-invalid @enderror">
                        <option></option>
                        <option value="1" @if (old('kategori_mesyuarat') == '1') selected @endif>
                            Mesyuarat Pengurusan Tertinggi</option>
                        <option value="2" @if (old('kategori_mesyuarat') == '2') selected @endif>
                            Mesyuarat Lain-lain</option>
                    </select>
                    @error('kategori_mesyuarat')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="penganjur" class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                <div class="col-md-9">
                    <select name="penganjur" id="penganjur" data-placeholder="Pilih Penganjur"
                        class="form-control select-search @error('penganjur') is-invalid @enderror" onchange="alert_nama_penganjur()">
                        <option></option>
                        <option value="SENDIRI" @if (old('penganjur') == 'SENDIRI') selected @endif>Sendiri</option>
                        <option value="BERSAMA" @if (old('penganjur') == 'BERSAMA') selected @endif>
                            Bersama/Kolabrasi</option>
                        <option value="LUAR" @if (old('penganjur') == 'LUAR') selected @endif>
                            Luar</option>
                    </select>
                    @error('penganjur')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="div_nama_penganjur" style="display: none">
                <div class="form-group row">
                    <label for="nama_penganjur"
                        class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                    <div class="col-md-9">
                        <input id="nama_penganjur" type="text" class="form-control @error('nama_penganjur') is-invalid @enderror"" name="nama_penganjur"
                            value="{{ old('nama_penganjur') }}" autocomplete="nama_penganjur">
                        @error('nama_penganjur')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="div_upload" style="display: none">
                <div class="form-group row">
                    <label for="surat_emel"
                        class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                    <div class="col-md-9">
                        <input type="file" class="form-control-uniform-custom @error('surat_emel') is-invalid @enderror" name="surat_emel" id="surat_emel">
                        @error('surat_emel')
                            <div class="invalid-feedback d-block">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>    
        
            <div id="no_pantry" class="alert alert-primary border-0 alert-dismissible" role="alert" style="display: block;">              
                <i class="icon-info22 mr-2"></i>
                <div id="mesej_sajian" style="display: block; color: red; font-size: 13px; padding-left: 15px;">
                    <b>Mesej</b> : Sekiranya memerlukan sajian, pemohon perlu mengisi 
                    <a href="{{ asset('references/do_adhoc.pdf') }}" target="_blank">Borang Permohonan Pantri Dalaman</a> 
                    dan menghantar terus ke Bizpoint / KOMITI (Aras 3). Tempahan Pantri Dalaman hanya untuk Bilik Mesyuarat sahaja.
                </div>
            </div>

            {{-- Sajian Dropdown --}}
            <div class="form-group row">
                <label for="sajian" class="col-md-3 col-form-label text-md-right">{{ __('Sajian') }}</label>
                <div class="col-md-9">                  
                    <select name="sajian" id="sajian" data-placeholder="Pilih Sajian"
                        onchange="sajianSelected(this.value)"
                        class="form-control select-search @error('sajian') is-invalid @enderror">
                        <option value="Tidak Perlu" selected>Tidak Perlu</option>
                    </select>
                    @error('sajian')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>
          
            <div id="div_sajian" style="display: none">
                <div class="form-group row">

                    <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                    <div id="div_minum_pagi" style="display: none">
                        <div class="col-md-12">
                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="minum_pagi"
                                    name="minum_pagi" value="1"
                                    @if (old('minum_pagi')) checked @endif>
                                <label class="custom-control-label position-static" for="minum_pagi">Minum
                                    Pagi</label>
                            </div>
                        </div>
                    </div>

                    <div id="div_makan_tengahari" style="display: none">
                        <div></b> : Sekiranya memerlukan sajian perlu mengisi Borang Permohonan Pantri Dalaman dan menghantar terus ke Bizpoint / KOMITI (Aras 3)</u>.ol-md-12">
                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="makan_tengahari"
                                    name="makan_tengahari" value="1"
                                    @if (old('makan_tengahari')) checked @endif>
                                <label class="custom-control-label position-static" for="makan_tengahari">Makan
                                    Tengahari</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <small class="text-danger">
                            <b>Mesej</b>: Sekiranya memerlukan sajian, perlu mengisi Borang Permohonan Pantri Dalaman dan menghantar terus ke Bizpoint / KOMITI (Aras 3).
                        </small>

                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline mt-2">
                            <input type="checkbox" class="custom-control-input" id="makan_tengahari"
                                name="makan_tengahari" value="1"
                                @if (old('makan_tengahari')) checked @endif>
                            <label class="custom-control-label position-static" for="makan_tengahari">Makan Tengahari</label>
                        </div>
                    </div>

                    <div id="div_minum_petang" style="display: none">
                        <div class="col-md-12">
                            <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="minum_petang"
                                    name="minum_petang" value="1"
                                    @if (old('minum_petang')) checked @endif>
                                <label class="custom-control-label position-static" for="minum_petang">Minum
                                    Petang</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="catatan" class="col-md-3 col-form-label text-md-right">{{ __('Catatan') }}</label>
                <div class="col-md-9">
                    <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room">{{ old('catatan_room') }}</textarea>
                </div>
            </div>
        </div>


    </div>

</fieldset>
