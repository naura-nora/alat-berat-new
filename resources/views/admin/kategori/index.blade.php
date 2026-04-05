{{-- resources/views/admin/kategori/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin - Daftar Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Kategori</h5>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>{{ Str::limit($kategori->deskripsi, 50) ?? '-' }}</td>
                        <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.kategori.show', $kategori) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $kategori->id }}"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $kategori->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus kategori <strong>{{ $kategori->nama }}</strong>?</p>
                                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="py-4">
                                <i class="bi bi-inbox display-6 text-muted"></i>
                                <p class="mt-2">Tidak ada data kategori.</p>
                                <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Tambah Kategori Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kategoris->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Menampilkan {{ $kategoris->firstItem() }} sampai {{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data
            </div>
            <div>
                {{ $kategoris->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection