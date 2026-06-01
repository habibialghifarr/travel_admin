<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Admin - Tiket Pesawat</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { background-color: #f4f5f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: #fff; box-shadow: 0 4px 10px 0 rgba(0,0,0,0.03); z-index: 1030; }
        .logo-text { background: linear-gradient(to right, #da8cff, #9a55ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        /* -- PENGATURAN SIDEBAR -- */
        .sidebar { 
            min-height: calc(100vh - 56px); 
            background: #fff; 
            box-shadow: 4px 0 10px 0 rgba(0,0,0,0.02);
        }
        
        /* Area Profil User di Sidebar */
        .sidebar-user-profile {
            padding: 1.5rem 1.25rem 1rem 1.25rem;
            display: flex;
            align-items: center;
        }
        .sidebar-user-profile img {
            width: 44px;
            height: 44px;
            border-radius: 100%;
            object-fit: cover;
            margin-right: 15px;
        }
        .sidebar-user-profile .user-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #3e4b5b;
            margin-bottom: 0.2rem;
        }
        .sidebar-user-profile .user-role {
            font-size: 0.8rem;
            color: #a0a0a0;
        }
        .sidebar-user-profile .status-icon {
            color: #1bcfb4; /* Hijau tosca khas Purple */
            margin-left: auto;
            font-size: 1.2rem;
        }

        /* Menu Navigasi */
        .sidebar .nav {
            padding-top: 0.5rem;
        }
        .sidebar .nav-link { 
            color: #3e4b5b; 
            padding: 1rem 1.25rem; 
            font-size: 0.9rem;
            display: flex; 
            align-items: center; 
            justify-content: space-between; /* Membuat teks di kiri, icon di kanan */
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav-link .menu-icon { 
            font-size: 1.15rem; 
            color: #c9b4e1; /* Warna ikon saat tidak aktif */
        }
        
        /* Efek Hover & Aktif */
        .sidebar .nav-link:hover { color: #9a55ff; }
        .sidebar .nav-item.active .nav-link { 
            color: #9a55ff; 
            font-weight: 500;
        }
        .sidebar .nav-item.active .nav-link .menu-icon { 
            color: #9a55ff; /* Ikon ungu saat aktif */
        }
        
        /* Gradasi & Card Bawaan */
        .bg-purple-gradient { background: linear-gradient(to right, #da8cff, #9a55ff) !important; }
        .bg-blue-gradient { background: linear-gradient(to right, #84d6ff, #3366ff) !important; }
        .bg-green-gradient { background: linear-gradient(to right, #84f9b3, #1bcfb4) !important; }
        .bg-orange-gradient { background: linear-gradient(to right, #fec85e, #fe9431) !important; }
        .btn-purple { background: linear-gradient(to right, #da8cff, #9a55ff); color: white; border: none; }
        .btn-purple:hover { color: white; opacity: 0.9; }
        .card { border: none; border-radius: 0.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold fs-4 fw-bold mx-3 logo-text" href="#"><h2> <b>FLYVEL.</b></h4></a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            
            <nav class="col-md-3 col-lg-2 d-md-block sidebar px-0">
                <div class="position-sticky">
                    
                    <div class="sidebar-user-profile">
                        <img src="https://ui-avatars.com/api/?name=Admin+Travel&background=random" alt="Profile">
                        <div>
                            <div class="user-name">Admin Travel</div>
                            <div class="user-role">Project Manager</div>
                        </div>
                        <i class="bi bi-patch-check-fill status-icon"></i>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <span class="menu-title">Dashboard</span>
                                <i class="bi bi-house-door-fill menu-icon"></i>
                            </a>
                        <li class="nav-item {{ Request::is('admin/bookings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.bookings') }}">
        <span class="menu-title">Daftar Pembooking</span>
        <i class="bi bi-airplane-engines-fill menu-icon"></i>
    </a>
</li>
                    </ul>
    <li class="nav-item">
    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
        @csrf
    </form>
    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="menu-title text-danger">Logout</span>
        <i class="bi bi-box-arrow-right text-danger fs-5"></i>
    </a>
</li>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
                @yield('konten')
            </main>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>