<div class="sidebar-content">
    <div class="card card-sidebar-mobile">

        <!-- Main navigation -->
        <div class="card-body p-0">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->


                <li class="nav-item-header mt-0">
                    <div class="text-uppercase font-size-xs line-height-xs">Menu Utama</div> <i class="icon-menu"
                        title="Main"></i>
                </li>
                <li class="nav-item">
                    <a href="/home?val=0" class="nav-link active">
                        <i class="icon-home4"></i>
                        <span>
                            Laman Utama
                        </span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-location4"></i> <span>Bilik Mesyuarat</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="/reference/room_applicant" class="nav-link">Profil
                                Bilik Mesyuarat</a></li>
                        {{-- <li class="nav-item"><a href="/application/search" class="nav-link">Semak Kekosongan</a></li> --}}
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-list"></i> <span>Permohonan
                            Tempahan</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="/application/applicant/create" class="nav-link">Mohon
                                Tempahan</a></li>
                        {{-- <li class="nav-item"><a href="/application/search" class="nav-link">Cari & Mohon Tempahan</a></li> --}}
                        <li class="nav-item"><a href="/application/1" class="nav-link">Rekod Tempahan</a>
                        </li>
                        <li class="nav-item"><a href="/application/2" class="nav-link">Sejarah Tempahan</a>
                        </li>
                        <li class="nav-item"><a href="/report/" class="nav-link">Aduan
                                Tempahan</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/cari/tempahan/pengguna') }}" class="nav-link"><i class="icon-search4"></i>
                        <span>Carian
                            Tempahan</span></a>

                    {{-- <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="/layout_1/LTR/default/full/index.html" class="nav-link">Default layout</a></li>
                            <li class="nav-item"><a href="/layout_2/LTR/default/full/index.html" class="nav-link">Layout 2</a></li>
                        </ul> --}}
                </li>


                @role('pmsb')
                    <li class="nav-item"><a href="/layout_2/LTR/default/full/index.html" class="nav-link"><i
                                class="icon-table2"></i> Laporan PMSB</a></li>
                @endrole

                @role('biz-point')
                    <li class="nav-item"><a href="/layout_2/LTR/default/full/index.html" class="nav-link"><i
                                class="icon-table2"></i> Laporan Biz Point</a></li>
                @endrole


                <!-- /layout -->
		  <li class="nav-item nav-item-submenu">
                    @role('user')
                    <a href="#" class="nav-link"><i class="icon-book2"></i> <span>Manual Pengguna</span></a>
                    @endrole
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">


                        @role('user')
                        <li class="nav-item">

                            <a href="{{ asset('/manual/Manual.pdf') }}" class="nav-link" target="_blank"><span>Pemohon</span></a>

                        </li>
                        @endrole
                    </ul>
                </li>
			 <a href="/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
</div>
