@extends('layouts.admin')

@section('konten')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h3 fw-bold text-secondary">Ringkasan Data Hari Ini</h1>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-purple-gradient text-white h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Total Penjualan Tiket</h5>
                    <i class="bi bi-graph-up fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">{{ $total_pesanan }} Transaksi</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-blue-gradient text-white h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Total Pendapatan</h5>
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-green-gradient text-white h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Total Tiket Terbeli</h5>
                    <i class="bi bi-ticket-perforated fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">{{ $total_tiket_terjual }} Tiket</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-orange-gradient text-white h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Jumlah Pembooking</h5>
                    <i class="bi bi-bookmark-star fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">{{ $total_pesanan }} Orang</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0 fw-bold text-secondary">Daftar Tiket yang Tersedia</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTiket">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Tiket Penerbangan
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Maskapai</th>
                                <th>Rute Penerbangan</th>
                                <th>Harga Per Tiket</th>
                                <th>Sisa Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarTiket as $tiket)
                            <tr>
                                <td>
                                    <span class="fw-bold text-dark">{{ $tiket->nama_maskapai }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $tiket->bandara_asal }}</span> 
                                    <i class="bi bi-arrow-right text-muted mx-1"></i> 
                                    <span class="fw-bold">{{ $tiket->bandara_tujuan }}</span>
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($tiket->harga_tiket, 0, ',', '.') }}</td>
                                <td><span class="badge bg-secondary">{{ $tiket->sisa_stok }} Tiket</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $tiket->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('tiket.hapus', $tiket->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus tiket ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit{{ $tiket->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('tiket.ubah', $tiket->id) }}" method="POST" class="modal-content">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Tiket Penerbangan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Maskapai</label>
                                                <input type="text" name="nama_maskapai" class="form-control" value="{{ $tiket->nama_maskapai }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bandara Asal</label>
                                                <input type="text" name="bandara_asal" class="form-control" value="{{ $tiket->bandara_asal }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bandara Tujuan</label>
                                                <input type="text" name="bandara_tujuan" class="form-control" value="{{ $tiket->bandara_tujuan }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Harga Tiket</label>
                                                <input type="number" name="harga_tiket" class="form-control" value="{{ $tiket->harga_tiket }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Sisa Stok Kursi</label>
                                                <input type="number" name="sisa_stok" class="form-control" value="{{ $tiket->sisa_stok }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-airplane fs-2 d-block mb-2"></i>
                                    Belum ada data tiket penerbangan. Silakan tambah data baru.
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

<div class="modal fade" id="modalTambahTiket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tiket.simpan') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Tiket Penerbangan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Maskapai</label>
                    <input type="text" name="nama_maskapai" class="form-control" placeholder="Contoh: Garuda Indonesia" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bandara Asal</label>
                    <input type="text" name="bandara_asal" class="form-control" placeholder="Contoh: JAKARTA (CGK)" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bandara Tujuan</label>
                    <input type="text" name="bandara_tujuan" class="form-control" placeholder="Contoh: TOKYO (HND)" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Tiket</label>
                    <input type="number" name="harga_tiket" class="form-control" placeholder="Contoh: 2500000" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sisa Stok Kursi</label>
                    <input type="number" name="sisa_stok" class="form-control" placeholder="Contoh: 150" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Penerbangan</button>
            </div>
        </form>
    </div>
</div>
@endsection