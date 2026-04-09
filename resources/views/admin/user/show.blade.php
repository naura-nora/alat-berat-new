{{-- resources/views/admin/user/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail User')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail User</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="user-profile">
                                <div class="avatar-circle mb-3">
                                    <span class="initials">{{ substr($user->name, 0, 2) }}</span>
                                </div>
                                <h4>{{ $user->name }}</h4>
                                <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isPetugas() ? 'warning' : 'success') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nama Lengkap</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <span class="badge badge-{{ $user->isAdmin() ? 'danger' : ($user->isPetugas() ? 'warning' : 'success') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>Status Email</th>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Terverifikasi</span>
                                            <small class="text-muted">({{ $user->email_verified_at->format('d/m/Y H:i') }})</small>
                                        @else
                                            <span class="badge badge-warning">Belum Verifikasi</span>
                                        @endif
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <td>{{ $user->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>{{ $user->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.user.destroy', $user) }}" method="POST" 
                          class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection