<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

</head>
<body>

<!-- VIDEO -->
<video autoplay muted loop id="bg-video">
    <source src="{{ asset('videos/eskanew.mp4') }}" type="video/mp4">
</video>

<!-- OVERLAY -->
<div class="overlay"></div>

<div class="container-fluid main-wrapper">
    <div class="row w-100">

        <!-- LEFT -->
        <div class="col-md-6 d-flex flex-column justify-content-center left-content">
            <h1>HEAVY EQUIPMENT RENTAL</h1>
            <div class="line"></div>
            <p>Daftar dan mulai kelola peminjaman alat berat dengan mudah dan cepat</p>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="register-box">

                <!-- HEADER -->
                <div class="register-header">
                    <h2>
                        <img src="{{ asset('images/logo-alatberat.png') }}"
                            alt="Logo"
                            style="width: 130px; height: 130px; object-fit: contain;">
                        <br>
                        {{ config('app.name', 'Laravel') }}
                    </h2>
                    <p>Buat akun baru</p>
                </div>

                <!-- FORM -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control"
                               placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control"
                               placeholder="Email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control"
                               placeholder="Password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Konfirmasi Password" required>
                    </div>

                    <button type="submit" class="btn btn-register w-100">
                        <i class="fas fa-user-plus me-2"></i> Register
                    </button>
                </form>

                <!-- LOGIN LINK -->
                <div class="login-link">
                    <p class="mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Login</a>
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>