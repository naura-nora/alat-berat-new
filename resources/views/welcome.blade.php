    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - {{ config('app.name', 'Laravel') }}</title>
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">
        
    </head>
    <body>

        <!-- VIDEO -->
        <video autoplay muted loop id="bg-video">
            <source src="{{ asset('videos/eskanew.mp4') }}" type="video/mp4">
        </video>

        <!-- OVERLAY -->
        <div class="overlay"></div>

        <!-- CONTENT -->
        <div class="container-fluid main-wrapper">
            <div class="row w-100">

                <!-- LEFT -->
                <div class="col-md-6 d-flex flex-column justify-content-center left-content">
                    <h1>HEAVY EQUIPMENT RENTAL</h1>
                    <div class="line"></div>
                    <p>Solusi cepat dan profesional untuk peminjaman alat berat</p>
                </div>

                <!-- RIGHT LOGIN -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="login-box">

                        <!-- HEADER -->
                        <div class="login-header">
                            <h2>
                                <img src="{{ asset('images/logo-alatberat.png') }}"
                                    alt="Logo"
                                    style="width: 130px; height: 130px; object-fit: contain;">
                                <br>
                                {{ config('app.name', 'Laravel') }}
                            </h2>
                            <p>Silakan login untuk melanjutkan</p>
                        </div>

                        <!-- FORM -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" 
                                    placeholder="Email" value="{{ old('email') }}" required autofocus>
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
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </form>

                        <!-- REGISTER -->
                        <div class="register-link">
                            <p class="mb-0">Belum punya akun? 
                                <a href="{{ route('register') }}">Register</a>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </body>
    </html>