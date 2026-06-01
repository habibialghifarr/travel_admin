@extends('layouts.admin')

@section('konten')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h3 fw-bold text-secondary">Manifes & Data Pembooking</h1>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 fw-bold text-secondary">Daftar Penumpang / Pemesan Aktif</h4>
                
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lengkap Pemesan</th>
                                <th>Nomor HP</th>
                                <th>Detail Penerbangan</th>
                                <th>Jumlah Kursi</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaPembooking as $pembooking)
                            <tr>
                                <td class="fw-bold text-dark">{{ $pembooking->nama_pembeli }}</td>
                                <td>{{ $pembooking->nomor_hp }}</td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $pembooking->tiket->nama_maskapai }}</span><br>
                                    <small class="text-muted">
                                        {{ $pembooking->tiket->bandara_asal }} 
                                        <i class="bi bi-arrow-right mx-1"></i> 
                                        {{ $pembooking->tiket->bandara_tujuan }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $pembooking->jumlah_kursi }} Kursi</span>
                                </td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($pembooking->total_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if($pembooking->status_pesanan == 'dibayar')
                                        <span class="badge bg-success px-3 py-2">Lunas / Dibayar</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-2">Dibooking (Keep)</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-warning"></i>
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
</div>
@endsection