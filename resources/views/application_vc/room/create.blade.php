<fieldset>

    <div class="card-group-control card-group-control-left">

        <div class="card card bg-light">

            <div class="card-header">
                <div class="form-group">
                    <div class="form-check form-check-inline form-check-right">
                        <label class="form-check-label">
                            <span>Permohononan Tempahan Bilik</span>
                            <input type="checkbox" id="room_selected" name="room_selected" class="form-check-input"
                                onclick="showHideFormRoom()">
                        </label>
                    </div>
                </div>
            </div>

            <div id="form_room_urusetia" style="display: none">

                <div id="collapsible-control-group1" class="collapse show">

                    <div class="card-header bg-white d-flex justify-content-between">
                        <span class="text-default">Maklumat Urusetia</span>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <div class="form-check form-check-inline form-check-right">
                                <label class="form-check-label">
                                    <span>Maklumat Seperti <a href="#" data-toggle="modal"
                                            data-target="#modal_default"> Pemohon</a></span>
                                    <input type="checkbox" id="copy_applicant" name="copy_applicant"
                                        class="form-check-input" onclick="copyApplicantInfo()">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="nama"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>
                                    <div class="col-md-8">
                                        <input id="nama_urusetia" type="text" class="form-control "
                                            name="nama_urusetia" value="{{ old('nama_urusetia') }}"
                                            autocomplete="no_sambungan">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('E-mel') }}</label>
                                    <div class="col-md-8">
                                        <input id="email_urusetia" type="text" class="form-control"
                                            name="email_urusetia" value="{{ old('email') }}"
                                            autocomplete="no_sambungan">
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
                                            data-placeholder="Pilih Jawatan" class="form-control">
                                            <option>Pilih Jawatan</option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position->id }}"
                                                    @if (old('jawatan_urusetia') == $position->id) selected @endif>
                                                    {{ $position->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="bahagian_urusetia"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Bahagian/Seksyen') }}</label>
                                    <div class="col-md-8">
                                        <select name="bahagian_urusetia" id="bahagian_urusetia"
                                            data-placeholder="Pilih Bahagian" class="form-control">
                                            <option>Pilih Bahagian</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if (old('department') == $department->id) selected @endif>
                                                    {{ $department->nama }}</option>
                                            @endforeach
                                        </select>
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
                                        <input id="no_sambungan_urusetia" type="text" class="form-control"
                                            name="no_sambungan_urusetia" value="{{ old('no_sambungan_urusetia') }}"
                                            autocomplete="no_sambungan_urusetia">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="no_bimbit_urusetia"
                                        class="col-md-4 col-form-label text-md-right">{{ __('No.Telefon Bimbit') }}</label>
                                    <div class="col-md-8">
                                        <input id="no_bimbit_urusetia" type="text" class="form-control"
                                            name="no_bimbit_urusetia" value="{{ old('no_bimbit_urusetia') }}"
                                            autocomplete="no_bimbit">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="form_room" style="display: none">
        <div class="card card bg-light">
            <div class="card-header bg-white d-flex justify-content-between">
                <span class="text-default">Maklumat Mesyuarat</span>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <label for="kategori_mesyuarat"
                        class="col-md-3 col-form-label text-md-right">{{ __('Kategori Mesyuarat') }}</label>
                    <div class="col-md-9">
                        <select name="kategori_mesyuarat" data-placeholder="Pilih Kategori Mesyuarat"
                            class="form-control">
                            <option>Pilih Kategori Mesyuarat</option>
                            <option value="1" @if (old('kategori_mesyuarat') == '1') selected @endif>Mesyuarat
                                Pengurusan Tertinggi</option>
                            <option value="2" @if (old('kategori_mesyuarat') == '2') selected @endif>Mesyuarat
                                Lain-lain</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="penganjur"
                        class="col-md-3 col-form-label text-md-right">{{ __('Penganjur') }}</label>
                    <div class="col-md-9">
                        <select name="penganjur" id="penganjur" data-placeholder="Pilih Penganjur"
                            class="form-control" onchange="alert_nama_penganjur()">
                            <option>Pilih Penganjur</option>
                            <option value="SENDIRI" @if (old('penganjur') == 'SENDIRI') selected @endif>Sendiri</option>
                            <option value="BERSAMA" @if (old('penganjur') == 'BERSAMA') selected @endif>Bersama/Kolabrasi
                            </option>
                            <option value="LUAR" @if (old('penganjur') == 'LUAR') selected @endif>Luar</option>
                        </select>
                    </div>
                </div>

                <div id="div_nama_penganjur" style="display: none">
                    <div class="form-group row">
                        <label for="nama_penganjur"
                            class="col-md-3 col-form-label text-md-right">{{ __('Nama Penganjur') }}</label>
                        <div class="col-md-9">
                            <input id="nama_penganjur" type="text" class="form-control" name="nama_penganjur"
                                value="{{ old('nama_penganjur') }}" autocomplete="nama_penganjur">
                        </div>
                    </div>
                </div>

                <div id="div_upload">
                    <div class="form-group row">
                        <label for="surat_emel"
                            class="col-md-3 col-form-label text-md-right">{{ __('Surat/E-mel Program (.pdf)') }}</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-uniform-custom" name="surat_emel"
                                id="surat_emel">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sajian" class="col-md-3 col-form-label text-md-right">{{ __('Sajian') }}</label>
                    <div class="col-md-9">
                        <select name="sajian" id="sajian" data-placeholder="Pilih Sajian"
                            onChange="java_script_:sajianSelected(this.options[this.selectedIndex].value)"
                            class="form-control form-control-select2">
                            <option></option>
                            <option value="Tidak Perlu">Tidak Perlu</option>
                            <option value="Pantri Dalaman">Pantri Dalaman</option>
                            <option value="Katerer Luar">Katerer Luar</option>
                        </select>
                    </div>
                </div>

                <div id="div_sajian" style="display: none">
                    <div class="form-group row">

                        <label class="col-md-3 text-md-right">Pilihan Sajian</label>
                        <div id="div_minum_pagi" style="display: none">
                            <div class="col-md-12">
                                <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="minum_pagi"
                                        name="minum_pagi" value="1">
                                    <label class="custom-control-label position-static" for="minum_pagi">Minum
                                        Pagi</label>
                                </div>
                            </div>
                        </div>

                        <div id="div_makan_tengahari" style="display: none">
                            <div class="col-md-12">
                                <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="makan_tengahari"
                                        name="makan_tengahari" value="1">
                                    <label class="custom-control-label position-static" for="makan_tengahari">Makan
                                        Tengahari</label>
                                </div>
                            </div>
                        </div>

                        <div id="div_minum_petang" style="display: none">
                            <div class="col-md-12">
                                <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="minum_petang"
                                        name="minum_petang" value="1">
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
                        <textarea rows="3" cols="3" class="form-control" placeholder="Catatan" name="catatan_room"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>
