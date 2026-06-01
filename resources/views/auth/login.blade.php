<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - TRAVEL-FLY</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #f4f5f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .login-wrapper {
            height: 100vh;
            display: flex;
        }

        /* --- SISI KIRI: FORM LOGIN --- */
        .login-left {
            flex: 1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        
        .form-container {
            width: 100%;
            max-width: 420px;
        }

        .logo-text {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            letter-spacing: 1px;
            display: inline-block;
        }

        .btn-purple-gradient {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            color: white;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        
        .btn-purple-gradient:hover {
            color: white;
            opacity: 0.9;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #ebedf2;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #b66dff;
            box-shadow: 0 0 0 0.25rem rgba(182, 109, 255, 0.15);
        }

        .btn-outline-custom {
            border: 1px solid #ebedf2;
            padding: 0.65rem;
            font-size: 0.9rem;
            color: #495057;
            background: #fff;
            transition: all 0.2s;
        }
        .btn-outline-custom:hover {
            background: #f8f9fa;
            border-color: #ced4da;
        }

        /* --- SISI KANAN: BANNER GRADASI (Sesuai Gambar 2 + Sentuhan Purple) --- */
        .login-right {
            flex: 1.2;
            background: linear-gradient(135deg, #9a55ff 0%, #da8cff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            color: white;
            position: relative;
        }

        /* Pola lingkaran estetik di background kanan */
        .login-right::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .info-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 460px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .ticket-mockup {
            background: white;
            border-radius: 0.5rem;
            padding: 1rem;
            color: #333;
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        /* Responsif untuk HP (Sisi kanan disembunyikan kalau di layar kecil) */
        @media (max-width: 991.98px) {
            .login-right { display: none; }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <div class="login-left">
            <div class="form-container">
                
                <div class="mb-4">
                    <h4 class="logo-text m-0"><b>FLYVEL✈️</b></h4>
                </div>

                <p>                <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Sign in</h2>
</p>

                @if(session('error_login'))
                    <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error_login') }}
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.8rem;"></button>
                    </div>
                @endif

                <form action="{{ route('login.proses') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
    <label class="form-label text-muted small fw-bold mb-1">Username</label>
    <input type="text" name="username" class="form-control rounded" placeholder="Masukkan username anda" value="{{ old('username') }}" required autofocus>
</div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold mb-1">Password</label>
                        <input type="password" name="password" class="form-control rounded" placeholder="••••••••" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-input-label text-muted" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-muted">Forgot Password?</a>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-purple-gradient rounded">Sign in</button>
                    </div>

                    <div class="position-relative text-center mb-4">
                        <hr class="text-muted">
                    </div>

                </form>
            </div>
        </div>
        
        <div class="login-right">
            <div class="info-card">
                <h3 class="fw-bold mb-3">Kelola Penerbangan Lebih Cepat & Mudah</h3>
                <p class="text-white-50 small mb-0">Pantau statistik penjualan, pantau sisa kuota kursi maskapai, dan verifikasi manifest data pembooking dalam satu panel admin terintegrasi.</p>
                
                <div class="ticket-mockup">
                    <div class="bg-light p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-airplane-fill text-primary fs-5"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold small text-dark">Garuda Indonesia - GA402</div>
                        <div class="text-muted" style="font-size: 0.75rem;">CGK &rarr; DPS | 120 Kursi Terisi</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success small">+Rp 45.2M</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Earnings</div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5" style="max-width: 460px;">
                <h5 class="fw-bold mb-2">Introducing new dashboard features</h5>
                <p class="text-white-50 small mb-0">Versi terbaru kini mendukung pembaruan sisa stok tiket secara otomatis (real-time) begitu form pemesanan pelanggan disubmit.</p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>