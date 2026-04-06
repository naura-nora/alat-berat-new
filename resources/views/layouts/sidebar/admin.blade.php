<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">

            {{-- Logo --}}
            <div class="image">
                <img src="{{ asset('images/logo-alatberat.png') }}"
                    class="img-circle elevation-2"
                    alt="User Image"
                    style="width: 45px; height: 45px; object-fit: cover;">
            </div>

            {{-- Info user --}}
            <div class="info ml-2">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                <small class="text-info">Admin</small>
            </div>

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Manajemen Data -->
                <li class="nav-item {{ request()->is('admin/alat*') || request()->is('admin/kategori*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('admin/alat*') || request()->is('admin/kategori*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Manajemen Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Data Alat Berat - Langsung link ke index -->
                        <li class="nav-item">
                            <a href="{{ route('admin.alat.index') }}" 
                               class="nav-link {{ request()->is('admin/alat*') ? 'active' : '' }}">
                                <i class="fas fa-tools nav-icon"></i>
                                <p>Data Alat Berat</p>
                            </a>
                        </li>
                        
                        <!-- Data Alat Berat - Langsung link ke index -->
                        <li class="nav-item">
                            <a href="{{ route('admin.kategori.index') }}" 
                               class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <!-- Manajemen User -->
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" 
                    class="nav-link {{ request()->routeIs('admin/user*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Manajemen User</p>
                    </a>
                </li>

                <!-- Peminjaman -->
                <li class="nav-item {{ request()->is('admin/peminjaman*') || request()->is('admin/pengembalian*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/peminjaman*') || request()->is('admin/pengembalian*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding"></i>
                        <p>
                            Peminjaman
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                           <a href="{{ route('admin.peminjaman.index') }}" 
                                class="nav-link {{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pengembalian.index') }}" 
                                class="nav-link {{ request()->is('admin/pengembalian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengembalian</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Laporan -->
                <li class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}" 
                    class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Laporan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.log-aktivitas.index') }}" class="nav-link">
                        <i class="fas fa-history nav-icon"></i>
                        <p>Log Aktivitas</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>