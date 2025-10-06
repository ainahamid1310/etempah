<ul class="nav nav-sidebar" data-nav-type="accordion">

    <!-- Main -->
    {{-- <li class="nav-item-header mt-0"><div class="text-uppercase font-size-xs line-height-xs">Super Admin</div> <i class="icon-menu" title="Main"></i></li> --}}
    <li class="nav-item">
        <a href="/home" class="nav-link active">
            <i class="icon-home4"></i>
            <span>
                Laman Utama
            </span>
        </a>
    </li>

    <!-- /main -->
    @role('super-admin|admin-room|approver-room')
        <li class="nav-item">
            <a href="/user" class="nav-link"><i class="icon-users4"></i> <span>Pengurusan Pengguna</span></a>
        </li>


        <li class="nav-item">
            <a href="{{ url('/cari/tempahan/admin_room') }}" class="nav-link"><i class="icon-search4"></i> <span>Carian
                    Tempahan Bilik</span></a>
        </li>
    @endrole

    @role('super-admin|approver-vc')
        <li class="nav-item">
            <a href="{{ url('/cari/tempahan/admin_vc') }}" class="nav-link"><i class="icon-search4"></i> <span>Carian
                    Tempahan VC</span></a>
        </li>
    @endrole


    @role('super-admin|admin-room|approver-room')
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-location4"></i> <span>Pengurusan Bilik Mesyuarat</span></a>

            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                <li class="nav-item"><a href="/reference/room" class="nav-link">Profil Bilik Mesyuarat</a></li>
                <li class="nav-item"><a href="/admin" class="nav-link">Profil Pentadbir Bilik</a></li>
                {{-- <li class="nav-item"><a href="/application/search" class="nav-link">Semak Kekosongan</a></li> --}}
            </ul>
        </li>
    @endrole

    <?php

    $tindakan_room = DB::table('application_rooms')
        ->selectRaw('count(*) as application_count, status_room_id')
        ->whereIn('status_room_id', [1, 3])
        ->count();

    ?>

    @hasanyrole('approver-room|super-admin|admin-room')
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-list"></i> <span>Pengurusan Tempahan Bilik</span></a>
            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                <li class="nav-item"><a href="/admin/application_room/1" class="nav-link">Tindakan &nbsp;
                        @if ($tindakan_room != 0)
                            <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">
                                {{ $tindakan_room }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item"><a href="/admin/application_room/2" class="nav-link">Rekod Tempahan</a>
                <li class="nav-item"><a href="/admin/report" class="nav-link">Aduan Tempahan</a>
                </li>
            </ul>
        </li>
    @endhasanyrole

    <?php

    $tindakan_vc = DB::table('application_vcs')
        ->selectRaw('count(*) as application_count, status_vc_id')
        ->whereIn('status_vc_id', [2])
        ->count();
    ?>

    @role('approver-vc|super-admin')
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-list"></i> <span>Pengurusan Tempahan VC</span></a>

            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                <li class="nav-item"><a href="/admin/application_vc/1" class="nav-link">Tindakan &nbsp;
                        @if ($tindakan_vc != 0)
                            <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{ $tindakan_vc }}
                            </span>
                        @endif
                    </a>
                <li class="nav-item"><a href="/admin/application_vc/2" class="nav-link">Rekod Tempahan</a></li>
            </ul>
        </li>
    @endrole


    <li class="nav-item nav-item-submenu">
        <a href="/application/room/search" class="nav-link"><i class="icon-table2"></i>
            <span>Laporan</span></a>

        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

            @role('super-admin|approver-room|pmsb|biz-point|admin-room')
                <li class="nav-item"><a href="/laporan/bilik" class="nav-link">Tempahan Bilik Mesyuarat</a></li>
            @endrole

            @role('super-admin|approver-vc')
                <li class="nav-item"><a href="/laporan/vc" class="nav-link">Tempahan Vc</a></li>
            @endrole

            @role('super-admin|approver-room|admin-room')
                <li class="nav-item"><a href="/laporan/aduan" class="nav-link">Aduan</a></li>
            @endrole
            @role('super-admin|approver-room|admin-room')
                <li class="nav-item"><a href="/laporan/statistik" class="nav-link">Statistik</a></li>
            @endrole

        </ul>
    </li>


    <li class="nav-item nav-item-submenu">
        @role('super-admin|approver-room|approver-vc')
            <a href="#" class="nav-link"><i class="icon-cog3"></i> <span>Konfigurasi</span></a>
        @endrole
        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

            @role('super-admin|approver-room|approver-vc')
                @role('super-admin|approver-room')
                    <li class="nav-item nav-item-submenu">

                        <a href="#" class="nav-link"><span>Pengurusan Data Rujukan</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="/reference/department" class="nav-link">Bahagian</a></li>
                            <li class="nav-item"><a href="/reference/position" class="nav-link">Jawatan</a></li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/role" class="nav-link"><span>Peranan</span></a>
                    </li> --}}
                @endrole
                <li class="nav-item">
                    <a href="/announcement" class="nav-link"><span>Informasi Umum</span></a>
                </li>
            @endrole

            {{-- @role('super-admin|approver-vc|approver-room')
                <li class="nav-item">
                    <a href="/announcement?i=vc" class="nav-link"><span>Informasi Umum</span></a>
                </li>
            @endrole --}}

            @role('super-admin|approver-room|approver-vc')
                <li class="nav-item">
                    <a href="/contact" class="nav-link"><span>Hubungi Kami</span></a>
                </li>
            @endrole

            @role('super-admin')
                <li class="nav-item">
                    <a href="/role" class="nav-link"><span>Peranan</span></a>
                </li>
            @endrole

        </ul>
    </li>
    <li class="nav-item nav-item-submenu">
        @role('super-admin|approver-room|approver-vc')
            <a href="#" class="nav-link"><i class="icon-book2"></i> <span>Manual Pengguna</span></a>
        @endrole
        <ul class="nav nav-group-sub" data-submenu-title="Layouts">


            @role('super-admin|approver-room|approver-vc')
                <li class="nav-item">

                    <a href="{{ asset('/manual/Manual.pdf') }}" class="nav-link"><span>Pemohon</span></a>

                </li>
            @endrole
            @role('approver-room')
                <li class="nav-item">
                    <a href="{{asset('/manual/Pentadbir_bilik.pdf')}}" class="nav-link" target="_blank"><span>Pentadbir Bilik</span></a>
                </li>
            @endrole


            @role('approver-vc')
                <li class="nav-item">
                    <a href="{{asset('/manual/Admin_vc.pdf')}}" class="nav-link" target="_blank"><span>Pentadbir Vc</span></a>
                </li>
            @endrole


        </ul>
    </li>

    <a href="/logout" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>




</ul>
