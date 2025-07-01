<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #212529;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo.png') }}" alt="Laris Jaya Gas Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3" style="font-size: 13px;">Laris Jaya Gas</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading text-light">
        Master Data
    </div>

    @php
        $masterRoutes = [
            'data_akun', 'data_perorangan', 'data_perusahaan',
            'data_jenis_tabung', 'data_status_tabung', 'data_tabung'
        ];
        $masterActive = collect($masterRoutes)->contains(fn($r) => request()->routeIs($r));
    @endphp

    <li class="nav-item {{ $masterActive ? 'active' : '' }}">
        <a class="nav-link {{ $masterActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
           data-target="#collapseMasterData" aria-expanded="{{ $masterActive ? 'true' : 'false' }}"
           aria-controls="collapseMasterData">
            <i class="fas fa-fw fa-database"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseMasterData" class="collapse {{ $masterActive ? 'show' : '' }}"
             aria-labelledby="headingMasterData" data-parent="#accordionSidebar">
            <div class="bg-dark py-2 collapse-inner rounded">
                <a class="collapse-item text-light {{ request()->routeIs('data_akun') ? 'active' : '' }}"
                   href="{{ route('data_akun') }}">
                    <i class="fas fa-user-cog mr-2"></i> Data Akun
                </a>
                <a class="collapse-item text-light {{ request()->routeIs('data_perorangan') ? 'active' : '' }}"
                   href="{{ route('data_perorangan') }}">
                    <i class="fas fa-user mr-2"></i> Data Perorangan
                </a>
                <a class="collapse-item text-light {{ request()->routeIs('data_perusahaan') ? 'active' : '' }}"
                   href="{{ route('data_perusahaan') }}">
                    <i class="fas fa-building mr-2"></i> Data Perusahaan
                </a>
                <a class="collapse-item text-light {{ request()->routeIs('data_jenis_tabung') ? 'active' : '' }}"
                   href="{{ route('data_jenis_tabung') }}">
                    <i class="fas fa-gas-pump mr-2"></i> Jenis Tabung
                </a>
                <a class="collapse-item text-light {{ request()->routeIs('data_status_tabung') ? 'active' : '' }}"
                   href="{{ route('data_status_tabung') }}">
                    <i class="fas fa-gas-pump mr-2"></i> Status Tabung
                </a>
                <a class="collapse-item text-light {{ request()->routeIs('data_tabung') ? 'active' : '' }}"
                   href="{{ route('data_tabung') }}">
                    <i class="fas fa-cube mr-2"></i> Data Tabung
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Pengaturan Transaksi (Dijadikan 2 item sejajar dengan Transaksi) -->
    <li class="nav-item {{ request()->routeIs('jenis_transaksi.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jenis_transaksi.index') }}">
            <i class="fas fa-fw fa-random"></i>
            <span>Jenis Transaksi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.status_transaksi.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.status_transaksi.index') }}">
            <i class="fas fa-fw fa-toggle-on"></i>
            <span>Status Transaksi</span>
        </a>
    </li>

    <!-- Transaksi -->
    <li class="nav-item {{ request()->routeIs('transaksis.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('transaksis.index') }}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Transaksi</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Menu Fitur Tambahan -->
    <li class="nav-item">
        <a class="nav-link disabled" href="#" onclick="return false;" style="cursor: not-allowed;">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Tagihan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#" onclick="return false;" style="cursor: not-allowed;">
            <i class="fas fa-fw fa-truck-moving"></i>
            <span>Peminjaman</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" href="#" onclick="return false;" style="cursor: not-allowed;">
            <i class="fas fa-fw fa-undo-alt"></i>
            <span>Pengembalian</span>
        </a>
    </li>

    <!-- Riwayat Transaksi -->
<li class="nav-item">
    <a class="nav-link disabled" href="#" onclick="return false;" style="cursor: not-allowed;">
        <i class="fas fa-fw fa-history"></i>
        <span>Riwayat Transaksi</span>
    </a>
</li>

</ul>
<!-- End of Sidebar -->
