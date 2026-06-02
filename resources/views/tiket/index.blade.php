<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelFly - Boarding Pass Pembeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f2edf3; 
            font-family: "Ubuntu", sans-serif; 
        }
        /* Navbar khas Purple Admin */
        .navbar-purple {
            background: #ffffff;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }
        .navbar-brand-custom {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(to right, #da8cff, #9a55ff);
            -webkit-background-clip: text;
            -webkit-text-color: transparent;
            -webkit-text-fill-color: transparent;
        }
        /* Header Gradasi Ungu */
        .page-header-gradient {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(154, 85, 255, 0.2);
        }
        /* Kontainer Utama Tiket Pesawat */
        .ticket-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            margin-bottom: 30px;
            overflow: hidden;
            border: none;
            transition: transform 0.3s;
        }
        .ticket-container:hover {
            transform: translateY(-5px);
        }
        .ticket-purple-header {
            background: linear-gradient(to right, #9a55ff, #da8cff);
            color: white;
            padding: 12px 20px;
            font-weight: 600;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        .airport-code {
            font-size: 1.6rem;
            font-weight: 800;
            color: #343a40;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Garis Putus-putus Rute Penerbangan */
        .flight-line {
            border-bottom: 2px dashed #b66dff;
            position: relative;
            margin-bottom: 10px;
        }
        .plane-icon-purple {
            position: absolute;
            left: 50%;
            bottom: -13px;
            transform: translateX(-50%);
            background: white;
            padding: 0 10px;
            color: #9a55ff;
            font-size: 1.3rem;
        }
        /* Sisi Kanan Potongan Tiket (Stub) */
        .ticket-stub-purple {
            background: #fbf9fc;
            border-left: 3px dashed #dfd5ef;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        /* Tombol Gradasi Khas Template Purple */
        .btn-purple-gradient {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 50px;
            transition: opacity 0.2s;
        }
        .btn-purple-gradient:hover {
            opacity: 0.9;
            color: white;
        }
        .modal-header-purple {
            background: linear-gradient(to right, #9a55ff, #da8cff);
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-purple sticky-top mb-4">
    <div class="container">
        <span class="navbar-brand-custom"><i class="fa-solid fa-plane-departure me-2"></i>FLYVEL</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary small d-none d-sm-inline">
                Selamat Datang, <strong class="text-dark">{{ Auth::user()->name ?? 'Penumpang' }}</strong> 
                <span class="badge p-1 px-2 text-white ms-1" style="background: #9a55ff;">Pembeli</span>
            </span>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf 
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-power-off me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="page-header-gradient d-flex align-items-center justify-content-between">
        <div>
            <h3 class="fw-bold mb-1">Cari & Pesan Tiket Penerbangan</h3>
            <p class="mb-0 opacity-75">Silakan pilih destinasi rute pilihanmu hasil real-time inputan admin.</p>
        </div>
        <i class="fa-solid fa-globe display-4 opacity-25 d-none d-md-block"></i>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @foreach($tikets as $tiket)
    <div class="card ticket-container border-0 mx-0 mb-4">
        <div class="row g-0 align-items-stretch">
            
            <div class="col-md-9 d-flex flex-column justify-content-between">
                <div class="ticket-purple-header d-flex justify-content-between w-100">
                    <span><i class="fa-solid fa-passport me-2"></i> {{ strtoupper($tiket->nama_maskapai) }} BOARDING PASS</span>
                    <span>FLIGHT CODE: <strong>{{ $tiket->nomor_penerbangan }}</strong></span>
                </div>
                
                <div class="p-4 flex-grow-1 d-flex flex-column justify-content-center">
                    <div class="row align-items-center text-center mb-4">
                        <div class="col-4">
                            <small class="text-muted d-block small mb-1">FROM</small>
                            <span class="airport-code d-block text-uppercase fw-bold">{{ $tiket->bandara_asal }}</span>
                        </div>
                        <div class="col-4 px-0 position-relative">
                            <div class="flight-line"></div>
                            <i class="fa-solid fa-plane plane-icon-purple"></i>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block small mb-1">TO</small>
                            <span class="airport-code d-block text-uppercase fw-bold">{{ $tiket->bandara_tujuan }}</span>
                        </div>
                    </div>

                    <div class="row text-center g-2 mt-auto">
                        <div class="col-3">
                            <div class="bg-light p-2 rounded-3 h-100">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">DATE</small>
                                <strong class="text-dark small">18 JUN 2026</strong>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-light p-2 rounded-3 h-100">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">TIME</small>
                                <strong class="text-dark small">10:30 WIB</strong>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-light p-2 rounded-3 h-100">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">STOK</small>
                                <strong class="text-danger small">{{ $tiket->sisa_stok }} Kursi</strong>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-light p-2 rounded-3 h-100">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">BASE PRICE</small>
                                <strong class="small" style="color: #9a55ff;">Rp {{ number_format($tiket->harga_tiket, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 ticket-stub-purple text-center d-flex flex-column justify-content-center align-items-center p-4">
                <i class="fa-solid fa-qrcode display-5 mb-2 text-secondary opacity-50"></i>
                <small class="text-muted mb-3 d-block">Pemesanan Instan</small>
                <button class="btn btn-purple-gradient shadow-sm w-100 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalPesan{{ $tiket->id }}">
                    Booking Tiket
                </button>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalPesan{{ $tiket->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-3 overflow-hidden shadow-lg">
                <div class="modal-header modal-header-purple">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-pen me-2"></i> Form Manifes Penumpang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tiket.pesan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="flight" value="{{ $tiket->nomor_penerbangan }}">
                    <input type="hidden" name="from" value="{{ $tiket->bandara_asal }}">
                    <input type="hidden" name="to" value="{{ $tiket->bandara_tujuan }}">
                    <input type="hidden" name="harga_dasar" value="{{ $tiket->harga_tiket }}">

                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Alamat Email Gmail</label>
                            <input type="email" name="gmail" class="form-control" placeholder="budi@gmail.com" value="{{ Auth::user()->email ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Alamat Rumah</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap kota asal" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Jumlah Tiket</label>
                                <input type="number" name="jumlah_tiket" class="form-control" value="1" min="1" max="{{ $tiket->sisa_stok }}" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Tingkatan Kelas</label>
                                <select name="kelas" class="form-select">
                                    <option value="Ekonomi">Ekonomi (Harga Normal)</option>
                                    <option value="Bisnis">Bisnis (2x Lipat)</option>
                                    <option value="First Class">First Class (4x Lipat)</option>
                                </select>
                            </div>
                        </div>
                        <div class="p-2 small rounded-3 text-center" style="background: #f3f0f7; color: #6c757d;">
                            <i class="fa-solid fa-circle-info me-1"></i> Data di atas bersifat dummy untuk demo simulasi tugas sekolah.
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light btn-sm rounded-pill text-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-purple-gradient btn-sm px-4">Kirim Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>