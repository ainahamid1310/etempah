{{-- <div class="sidebar-content">
    <div class="card card-sidebar-mobile"> --}}

<!-- Main navigation -->
{{-- <div class="card-body p-0"> --}}
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
    {{-- @role('super-admin') --}}
    <li class="nav-item">
        <a href="/user" class="nav-link"><i class="icon-users4"></i> <span>Pengurusan Pengguna</span></a>
    </li>
    {{-- @endrole --}}

    <li class="nav-item">
        <a href="/cari/tempahan" class="nav-link"><i class="icon-search4"></i> <span>Carian
                Tempahan</span></a>
    </li>
    {{-- @role('super-admin') --}}
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link"><i class="icon-location4"></i> <span>Pengurusan Bilik Mesyuarat</span></a>

        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
            <li class="nav-item"><a href="/reference/room" class="nav-link">Profail Bilik Mesyuarat</a></li>
            <li class="nav-item"><a href="/admin" class="nav-link">Profail Pentadbir Bilik</a></li>
            {{--<li class="nav-item"><a href="/application/search" class="nav-link">Semak Kekosongan</a></li>--}}
        </ul>
    </li>
    {{-- @endrole --}}

    @hasanyrole('approver-room|super-admin')
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-list"></i> <span>Pengurusan Tempahan Bilik</span></a>

            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                <li class="nav-item"><a href="/admin/application_room/1" class="nav-link">Tindakan</a></li>
                <li class="nav-item"><a href="/admin/application_room/2" class="nav-link">Rekod Tempahan</a>
                <li class="nav-item"><a href="/admin/report" class="nav-link">Aduan Tempahan</a>
                </li>
            </ul>
        </li>
    @endhasanyrole

    @role('approver-vc|super-admin')
        <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-list"></i> <span>Pengurusan Tempahan VC</span></a>

            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                <li class="nav-item"><a href="/admin/application_vc/1" class="nav-link">Tindakan</a></li>
                <li class="nav-item"><a href="/admin/application_vc/2" class="nav-link">Rekod Tempahan</a></li>
            </ul>
        </li>
    @endrole

    {{-- @role('super-admin') --}}
    <li class="nav-item nav-item-submenu">
        <a href="/application/room/search" class="nav-link"><i class="icon-table2"></i>
            <span>Laporan</span></a>

       <ul class="nav nav-group-sub" data-submenu-title="Layouts">
            <li class="nav-item"><a href="/laporan/bilik" class="nav-link">Tempahan Bilik Mesyuarat</a></li>
            <li class="nav-item"><a href="/laporan/vc" class="nav-link">Tempahan Vc</a></li>
            <li class="nav-item"><a href="/laporan/aduan" class="nav-link">Aduan</a></li>
            <li class="nav-item"><a href="/laporan/statistik" class="nav-link">Statistik</a></li>
        </ul>
    </li>

    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link"><i class="icon-cog3"></i> <span>Konfigurasi</span></a>

        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

            <li class="nav-item nav-item-submenu">
                {{-- <a href="#" class="nav-link"><i class="icon-database"></i> <span>Pengurusan Data Rujukan</span></a> --}}
                <a href="#" class="nav-link"><span>Pengurusan Data Rujukan</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a href="/reference/department" class="nav-link">Bahagian</a></li>
                    <li class="nav-item"><a href="/reference/position" class="nav-link">Jawatan</a></li>

                </ul>
            </li>

            <li class="nav-item">
                {{-- <a href="/role" class="nav-link"><i class="icon-cog3"></i> <span>Peranan</span></a> --}}
                <a href="/role" class="nav-link"><span>Peranan</span></a>
            </li>

            <li class="nav-item">
                {{-- <a href="/announcement" class="nav-link"><i class="icon-megaphone"></i> <span>Informasi Umum</span></a> --}}
                <a href="/announcement" class="nav-link"><span>Informasi Umum</span></a>
            </li>

            <li class="nav-item">
                {{-- <a href="/contact" class="nav-link"><i class="icon-phone"></i> <span>Hubungi Kami</span></a> --}}
                <a href="/contact" class="nav-link"><span>Hubungi Kami</span></a>
            </li>
        </ul>
    </li>
    {{-- @endrole --}}

    {{-- @role('approver-room') --}}
    {{-- <li class="nav-item nav-item-submenu">
                        <a href="/application/search" class="nav-link"><i class="icon-table2"></i> <span>Laporan</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="/layout_1/LTR/default/full/index.html" class="nav-link">Laporan 1</a></li>
                            <li class="nav-item"><a href="/layout_2/LTR/default/full/index.html" class="nav-link">Laporan 2</a></li>
                            <li class="nav-item"><a href="/layout_2/LTR/default/full/index.html" class="nav-link">Laporan 3</a></li>
                        </ul>
                    </li> --}}
    {{-- @endrole --}}
</ul>
