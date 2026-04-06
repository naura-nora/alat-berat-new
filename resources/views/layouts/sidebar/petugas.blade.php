<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('petugas.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

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
                <small class="text-info">Petugas</small>
            </div>

        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('petugas.alat.index') }}" 
                    class="nav-link {{ request()->routeIs('petugas.alat.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Data Alat Berat</p>
                    </a>
                </li>

        

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding"></i>
                        <p>
                            Peminjaman
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengembalian</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="{{ route('petugas.transaksi.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Transaksi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('petugas.user.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Peminjam</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>