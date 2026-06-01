@extends('layouts.admin') {{-- Sesuaikan dengan nama layout admin kamu, jangan sampai salah --}}

@section('konten')
<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <h2 class="fw-bold text-secondary">Manifes & Data Pembooking</h2>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="card-title fw-bold text-dark mb-0">Daftar Penumpang / Pemesan Aktif</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light text-secondary fw-semibold">
                        <tr>
                            <th class="ps-4">Nama Lengkap</th>
                            <th>Kontak (Gmail)</th>
                            <th>Rute & Penerbangan</th>
                            <th>Kelas & Tiket</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $book)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $book->nama_lengkap }}</td>
                                <td>{{ $book->gmail }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $book->flight }}</span><br>
                                    <small class="text-muted">{{ $book->from }} ✈️ {{ $book->to }}</small>
                                </td>
                                <td>
                                    <span class="badge text-dark fw-semibold" style="background-color: #f3e8ff;">{{ $book->kelas }}</span><br>
                                    <small class="text-secondary">{{ $book->jumlah_tiket }} Kursi</small>
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($book->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($book->status == 'Pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                    @else
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Success</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-folder-x text-warning" viewBox="0 0 16 16">
                                            <path d="M.5 3 .04 4.35a.5.5 0 0 0 .496.568h14.928a.5.5 0 0 0 .496-.568L15.5 3H.5zM14.75 5H1.25L1 11h14l-.25-6zM2 2a1 1 0 0 1 1-1h3.293a1 1 0 0 1 .707.293L8.293 2H13a1 1 0 0 1 1 1v1H2V2z"/>
                                        </svg>
                                    </div>
                                    Belum ada pesanan tiket yang masuk untuk saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection