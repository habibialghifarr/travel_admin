@extends('layouts.admin')

@section('konten')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h3 fw-bold text-secondary">Daftar Pembooking Tiket</h1>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                
                @if(session('notif_sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('notif_sukses') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No. Order</th>
                                <th>Nama Pemesan</th>
                                <th>Email</th>
                                <th>Rute Penerbangan</th>
                                <th>Jumlah Tiket</th>
                                <th>Kelas</th>
                                <th>Status / Sisa Waktu</th>
                                <th class="text-center">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaPembooking as $order)
                            <tr>
                                <td><span class="fw-bold text-purple">#ORD-{{ $order->id }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $order->nama_lengkap }}</span></td>
                                <td><span class="text-muted">{{ $order->gmail }}</span></td>
                                <td>
                                    <span class="badge bg-dark">{{ $order->flight }}</span><br>
                                    <small class="fw-bold text-secondary">{{ $order->from }} <i class="bi bi-arrow-right mx-1"></i> {{ $order->to }}</small>
                                </td>
                                <td><span class="badge bg-secondary">{{ $order->jumlah_tiket }} Kursi</span></td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $order->kelas }}</span>
                                </td>
                                <td>
                                    @if($order->status == 'Diverifikasi')
                                        <span class="badge bg-danger p-2 countdown-timer" 
                                              data-expire="{{ date('Y-m-d H:i:s', strtotime($order->updated_at . ' +12 hours')) }}">
                                            Loading Timer...
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark p-2">Belum Diverifikasi</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-1" style="min-width: 190px;">
                                        @if($order->status != 'Diverifikasi')
                                            <form action="{{ route('admin.bookings.verify', $order->id) }}" method="POST" class="d-inline m-0 p-0 flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100 py-1 px-2 d-flex align-items-center justify-content-center" style="font-size: 11px; white-space: nowrap;">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Verifikasi
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.bookings.unverify', $order->id) }}" method="POST" class="d-inline m-0 p-0 flex-grow-1" onsubmit="return confirm('Data janggal! Yakin ingin menghapus orderan ini dari database?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger w-100 py-1 px-2 d-flex align-items-center justify-content-center" style="font-size: 11px; white-space: nowrap;">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Un-verif
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-success fw-bold small d-flex align-items-center justify-content-center py-1">
                                                <i class="bi bi-shield-fill-check fs-5 me-1"></i> Order Fixed
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-emoji-frown fs-2 d-block mb-2"></i>
                                    Belum ada data pembooking di database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi pembantu agar format tanggal dibaca dengan benar di berbagai browser
        function parseLaravelDate(str) {
            let t = str.split(/[- :]/);
            return new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
        }

        function updateTimers() {
            const timers = document.querySelectorAll('.countdown-timer');
            timers.forEach(function(timer) {
                const expireAttr = timer.getAttribute('data-expire');
                const expireTime = parseLaravelDate(expireAttr).getTime();
                const now = new Date().getTime();
                const selisih = expireTime - now;

                if (selisih <= 0) {
                    timer.innerHTML = "WAKTU HABIS";
                    timer.classList.replace('bg-danger', 'bg-dark');
                } else {
                    const jam = Math.floor((selisih % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
                    const detik = Math.floor((selisih % (1000 * 60)) / 1000);

                    timer.innerHTML = `<i class="bi bi-clock-history me-1"></i> Hangus dlm: ${jam}j ${menit}m ${detik}d`;
                }
            });
        }

        // Jalankan langsung dan set interval per 1 detik
        updateTimers();
        setInterval(updateTimers, 1000);
    });
</script>
@endsection