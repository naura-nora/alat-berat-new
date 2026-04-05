<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('peminjam.dashboard') }}" class="brand-link">
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
                <small class="text-info">Peminjam</small>
            </div>

        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('peminjam.dashboard') }}" class="nav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

            

                <li class="nav-item">
                    <a href="{{ route('peminjam.alat.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-list"></i>
                        <p>Daftar Barang</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('peminjam.peminjaman.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding"></i>
                        <p>Ajukan Peminjaman</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('peminjam.peminjaman.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Peminjaman Saya </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>