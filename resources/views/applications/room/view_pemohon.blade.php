<fieldset>

    <div class="card-group-control card-group-control-left">

        <div class="card bg-light">        

            <div class="card-header bg-white d-flex justify-content-between">
                <strong>Maklumat <a href="#" data-toggle="modal" data-target="#modal_default"> Pemohon </a><i
                        class="icon-info22 mr-3"></i></strong>
            </div>

            <div class="card-body ps-3">
                <div class="mb-3">
                    <strong class="fw-bold text-dark">Maklumat Urusetia</strong>
                </div>

                @php
                    $urusetia = $application->applicationRoom;
                @endphp

                <div class="row" style="padding-left: 4rem;">
                    <div class="col-md-6">
                        <div class="d-flex py-2 border-bottom align-items-center">                        
                            <strong class="me-3" style="min-width: 150px;">Nama</strong>
                            <div class="flex-grow-1 text-muted">{{ $urusetia->nama_urusetia ?: '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">E-mel</strong>                                
                            <div class="flex-grow-1 text-muted">{{ $urusetia->emel_urusetia ?: '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">Jawatan</strong>                                
                            <div class="flex-grow-1 text-muted">{{ $urusetia->position->nama ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">Bahagian/Seksyen</strong>                                
                            <div class="flex-grow-1 text-muted">{{ $urusetia->department->nama ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">No. Sambungan</strong>                                
                            <div class="flex-grow-1 text-muted">{{ $urusetia->no_extension_urusetia ?: '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">No. Telefon Bimbit</strong>                                
                            <div class="flex-grow-1 text-muted">{{ $urusetia->no_telefon_bimbit_urusetia ?: '-' }}</div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="ps-3">
                    <strong class="fw-bold text-dark">Maklumat Mesyuarat</strong>
                    <br><br>
                    <div style="padding-left: 4rem;">     

                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">Lampiran</strong>
                            @if ($application->applicationRoom->surat)
                                    <a href="{{ asset($application->applicationRoom->surat) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-paperclip"></i> Lampiran
                                    </a>
                            @else
                                <span class="text-muted">Tiada lampiran</span>
                            @endif
                        </div>       

                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">Kategori Mesyuarat</strong>
                            <span class="text-muted">
                                {{ $application->applicationRoom->kategori_mesyuarat == '1' 
                                    ? 'Mesyuarat Pengurusan Tertinggi' 
                                    : 'Mesyuarat Lain-lain' }}
                            </span>
                        </div>              
                    
                        @php
                            $penganjur = $application->applicationRoom->penganjur;
                            $penganjurLabel = match($penganjur) {
                                'SENDIRI' => 'Sendiri',
                                'BERSAMA' => 'Bersama/Kolaborasi',
                                'LUAR' => 'Luar',
                                default => '-',
                            };
                            $namaPenganjur = $application->applicationRoom->nama_penganjur;
                        @endphp

                        <div class="d-flex py-2 border-bottom align-items-center">
                            <strong class="me-3" style="min-width: 150px;">Penganjur</strong>
                            <span class="text-muted">{{ $penganjurLabel }}</span>
                        </div>
                   
                        @if(in_array($penganjur, ['BERSAMA', 'LUAR']))
                            <div class="d-flex py-2 border-bottom align-items-center">
                                <strong class="me-3" style="min-width: 150px;">Nama Penganjur</strong>
                                <span class="text-muted">{{ $namaPenganjur ?: '-' }}</span>
                            </div>
                        @endif


                        <div id="div_upload" style="display: none">
                            <div class="d-flex py-2 border-bottom align-items-center">
                                <div class="fw-semibold text-dark" style="min-width: 180px;">
                                    Surat/E-mel Program (.pdf)
                                </div>
                                <div class="flex-grow-1">
                                    @if (!empty($application->applicationRoom->surat))
                                        <a href="{{ asset($application->applicationRoom->surat) }}" target="_blank" class="text-primary text-decoration-none">
                                            <i class="fas fa-paperclip me-2"></i>
                                            Muat Turun Fail
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>            

                        <div class="d-flex py-2 border-bottom align-items-center">                  
                            <strong class="me-3" style="min-width: 150px;">Sajian</strong>
                            <div class="flex-grow-1 text-muted">
                                {{ $application->applicationRoom->sajian ?: '-' }}
                            </div>
                        </div>

                        @if ($application->applicationRoom->sajian !== 'Tidak Perlu')
                            <div class="d-flex py-2 border-bottom align-items-start">
                                <div class="fw-semibold text-dark" style="min-width: 150px;">
                                    Pilihan Sajian
                                </div>
                                <div class="flex-grow-1 text-muted">
                                    @php
                                        $sajianList = [];

                                        if ($application->applicationRoom->minum_pagi == '1') {
                                            $sajianList[] = 'Minum Pagi';
                                        }
                                        if ($application->applicationRoom->makan_tengahari == '1') {
                                            $sajianList[] = 'Makan Tengahari';
                                        }
                                        if ($application->applicationRoom->minum_petang == '1') {
                                            $sajianList[] = 'Minum Petang';
                                        }
                                    @endphp

                                    @if (count($sajianList))
                                        <ul class="mb-0 ps-3">
                                            @foreach ($sajianList as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span>-</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    
                        <div class="d-flex py-2 border-bottom align-items-start">                    
                            <strong class="me-3" style="min-width: 150px;">Catatan</strong>
                            <div class="flex-grow-1 text-muted white-space-prewrap">
                                {{ $application->applicationRoom->catatan ?: '-' }}
                            </div>
                        </div>

                        <!-- Nota : Komen disini sebab komen mengikut setiap permohonan -->
                        @if(!empty($application->applicationVc))
                            @if($application->applicationVc->status_vc_id == '4' && is_null($application->applicationVc->komen_ditolak))
                                <div class="form-group row">
                                    <label for="catatan_vc_penyelia"
                                        class="col-md-3 col-form-label text-md-right">{{ __('Catatan Ditolak/Batal') }}</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="2" class="form-control" name="catatan_vc_penyelia" readonly>{{ $application->applicationRoom->komen_ditolak }}</textarea>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>    
       
        </div>
    </div>

</fieldset>