@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-user-edit text-primary me-2"></i>
            Edit User
        </h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required onchange="toggleManagementType(this)">
                        <option value="receptionist" {{ $user->role == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                        <option value="secretary" {{ $user->role == 'secretary' ? 'selected' : '' }}>Secretary</option>
                        <option value="management-business" {{ $user->role == 'management-business' ? 'selected' : '' }}>Management - Business</option>
                        <option value="management-government" {{ $user->role == 'management-government' ? 'selected' : '' }}>Management - Government</option>
                        <option value="management-enterprise" {{ $user->role == 'management-enterprise' ? 'selected' : '' }}>Management - Enterprise</option>
                        <option value="security" {{ $user->role == 'security' ? 'selected' : '' }}>Security</option>
                        <option value="customer_service" {{ old('role') == 'customer_service' ? 'selected' : '' }}>Customer Service</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
