<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title') - Peminjaman Alat Berat</title>
  
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- AdminLTE (SUDAH INCLUDE Bootstrap 4) -->
   <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
   
   <style>
       :root {
           --primary-color: #ffbf2b;
       }
       
       .sidebar-dark-primary {
           background-color: #343a40 !important;
       }
       
       .btn-primary {
           background-color: var(--primary-color);
           border-color: var(--primary-color);
       }
       
       .btn-primary:hover {
           background-color: #e6ac27;
           border-color: #e6ac27;
       }
       
       .bg-primary {
           background-color: var(--primary-color) !important;
       }
   </style>
   
   @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
   <!-- Navbar -->
   @include('layouts.navbar')

   <!-- Sidebar berdasarkan role -->
   @auth
       @if(auth()->user()->role == 'admin')
           @include('layouts.sidebar.admin')
       @elseif(auth()->user()->role == 'petugas')
           @include('layouts.sidebar.petugas')
       @elseif(auth()->user()->role == 'peminjam')
           @include('layouts.sidebar.peminjam')
       @endif
   @endauth
  
   <!-- Content -->
   <div class="content-wrapper">

       <!-- Content Header -->
       <div class="content-header">
           <div class="container-fluid">
               <div class="row mb-2"></div>
           </div>
       </div>

       <!-- Main Content -->
       <section class="content">
            <div class="container-fluid">

                {{-- Notifikasi --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @yield('content')

            </div>
        </section>
   </div>
  
   <!-- Footer -->
   @include('layouts.footer')
</div>

<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 4 (WAJIB untuk AdminLTE) -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

@stack('scripts')
</body>
</html>