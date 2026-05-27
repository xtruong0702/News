@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản lý người dùng</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-alert="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tham gia</th>
                        <th class="text-end">Thay đổi vai trò</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role === 'writer')
                                <span class="badge bg-primary">Writer</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            {{-- Không cho phép Admin tự đổi vai trò của chính mình để tránh lỗi hệ thống --}}
                            @if(Auth::user()->id !== $user->id)
                            <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex justify-content-end gap-2">
                                @csrf
                                <select name="role" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="writer" {{ $user->role === 'writer' ? 'selected' : '' }}>Writer</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                            </form>
                            @else
                            <span class="text-muted small"><em>(Đang đăng nhập)</em></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
