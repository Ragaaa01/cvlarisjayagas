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
    <li class="nav-item">
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

    <!-- Collapse Menu: Master Data -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData"
            aria-expanded="false" aria-controls="collapseMasterData">
            <i class="fas fa-fw fa-database"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseMasterData" class="collapse" aria-labelledby="headingMasterData" data-parent="#accordionSidebar">
            <div class="bg-dark py-2 collapse-inner rounded">
                <a class="collapse-item text-light" href="#}">
                    <i class="fas fa-users mr-2"></i> Data User
                </a>
                <a class="collapse-item text-light" href="#">
                    <i class="fas fa-gas-pump mr-2"></i> Data Tabung
                </a>
                <a class="collapse-item text-light" href="#">
                    <i class="fas fa-building mr-2"></i> Data Perusahaan
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Transaksi -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Transaksi</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
