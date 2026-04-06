@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Log Aktivitas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Aktivitas</th>
                                    <th>Tabel Terkait</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration + ($logs->perPage() * ($logs->currentPage() - 1)) }}</td>
                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $log->user->name ?? 'User Dihapus' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $log->user->role == 'admin' ? 'danger' : ($log->user->role == 'petugas' ? 'warning' : 'success') }}">
                                            {{ ucfirst($log->user->role ?? '-') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($log->aktivitas == 'create')
                                            <span class="badge badge-success">Create</span>
                                        @elseif($log->aktivitas == 'update')
                                            <span class="badge badge-info">Update</span>
                                        @elseif($log->aktivitas == 'delete')
                                            <span class="badge badge-danger">Delete</span>
                                        @elseif($log->aktivitas == 'approve')
                                            <span class="badge badge-primary">Approve</span>
                                        @elseif($log->aktivitas == 'reject')
                                            <span class="badge badge-warning">Reject</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($log->aktivitas) }}</span>
                                        @endif
                                    </p>
                                    <td>
                                        <span class="badge badge-dark">{{ ucfirst($log->tabel_terkait) }}</span>
                                    </p>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                data-toggle="modal" 
                                                data-target="#deleteModal{{ $log->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        <div class="modal fade" id="deleteModal{{ $log->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Log</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin ingin menghapus log ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.log-aktivitas.destroy', $log->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </p>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada aktivitas</p>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection