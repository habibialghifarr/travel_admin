@extends('layouts.admin')

@section('konten')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h3 fw-bold text-secondary">Ringkasan Data Hari Ini</h1>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-purple-gradient text-white h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Total Penjualan Tiket</h5>
                    <i class="bi bi-graph-up fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">{{ $totalPenjualan }} Transaksi</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-blue-gradient text-white h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Total Pendapatan</h5>
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-green-gradient text-white h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Total Tiket Terbeli</h5>
                    <i class="bi bi-ticket-perforated fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">{{ $totalTiketTerbeli }} Kursi</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card bg-orange-gradient text-white h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title mb-0 fs-6 opacity-75">Tiket Terbooking</h5>
                    <i class="bi bi-bookmark-star fs-3"></i>
                </div>
                <h2 class="mt-4 mb-0 fw-bold">{{ $tiketTerbooking }} Kursi</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0 fw-bold text-secondary">Daftar Tiket yang Tersedia</h4>
                    <button class="btn btn-purple btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle me-1"></i> Tambah Penerbangan</button>
                </div>

                @if(session('notif_sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('notif_sukses') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Maskapai</th>
                                <th>Rute Penerbangan</th>
                                <th>Jadwal Berangkat</th>
                                <th>Harga Per Tiket</th>
                                <th>Sisa Stok</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarTiket as $tiket)
                            <tr>
                                <td>
                                    <span class="fw-bold text-dark">{{ $tiket->nama_maskapai }}</span><br>
                                    <small class="text-muted">{{ $tiket->nomor_penerbangan }}</small>
                                </td>
                                <td>{{ $tiket->bandara_asal }} <i class="bi bi-arrow-right mx-1 text-muted"></i> {{ $tiket->bandara_tujuan }}</td>
                                <td>{{ date('d M Y, H:i', strtotime($tiket->waktu_berangkat)) }} WIB</td>
                                <td class="fw-bold text-success">Rp {{ number_format($tiket->harga_tiket, 0, ',', '.') }}</td>
                                <td><span class="badge bg-secondary">{{ $tiket->sisa_stok }} Kursi</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $tiket->id }}"><i class="bi bi-pencil-square"></i></button>
                                    <form action="{{ route('tiket.hapus', $tiket->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Kamu yakin ingin menghapus jadwal tiket ini?')"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit{{ $tiket->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('tiket.ubah', $tiket->id) }}" method="POST" class="modal-content">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Ubah Data Penerbangan</h5>
                                            <button type="button" class="btn-close" data-bs-shadow="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3"><label class="form-label">Nama Maskapai</label><input type="text" name="nama_maskapai" class="form-control" value="{{ $tiket->nama_maskapai }}" required></div>
                                            <div class="mb-3"><label class="form-label">Nomor Penerbangan</label><input type="text" name="nomor_penerbangan" class="form-control" value="{{ $tiket->nomor_penerbangan }}" required></div>
                                            <div class="mb-3"><label class="form-label">Bandara Asal</label><input type="text" name="bandara_asal" class="form-control" value="{{ $tiket->bandara_asal }}" required></div>
                                            <div class="mb-3"><label class="form-label">Bandara Tujuan</label><input type="text" name="bandara_tujuan" class="form-control" value="{{ $tiket->bandara_tujuan }}" required></div>
                                            <div class="mb-3"><label class="form-label">Waktu Keberangkatan</label><input type="datetime-local" name="waktu_berangkat" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($tiket->waktu_berangkat)) }}" required></div>
                                            <div class="mb-3"><label class="form-label">Harga (Rp)</label><input type="number" name="harga_tiket" class="form-control" value="{{ $tiket->harga_tiket }}" required></div>
                                            <div class="mb-3"><label class="form-label">Sisa Stok Kursi</label><input type="number" name="sisa_stok" class="form-control" value="{{ $tiket->sisa_stok }}" required></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-purple">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tiket.simpan') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Tiket Penerbangan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Nama Maskapai</label><input type="text" name="nama_maskapai" class="form-control" placeholder="Contoh: Garuda Indonesia" required></div>
                <div class="mb-3"><label class="form-label">Nomor Penerbangan</label><input type="text" name="nomor_penerbangan" class="form-control" placeholder="Contoh: GA-123" required></div>
                <div class="mb-3"><label class="form-label">Bandara Asal</label><input type="text" name="bandara_asal" class="form-control" placeholder="Contoh: Jakarta (CGK)" required></div>
                <div class="mb-3"><label class="form-label">Bandara Tujuan</label><input type="text" name="bandara_tujuan" class="form-control" placeholder="Contoh: Bali (DPS)" required></div>
                <div class="mb-3"><label class="form-label">Waktu Keberangkatan</label><input type="datetime-local" name="waktu_berangkat" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Harga (Rp)</label><input type="number" name="harga_tiket" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Jumlah Stok Kursi</label><input type="number" name="sisa_stok" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-purple">Tambahkan Tiket</button>
            </div>
        </form>
    </div>
</div>
@endsection