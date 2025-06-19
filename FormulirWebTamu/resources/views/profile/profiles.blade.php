@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Profil Pengguna</h3>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex align-items-center mb-4">
                            <div>
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil" class="rounded-circle" width="90" height="90" style="object-fit:cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" alt="Foto Profil" class="rounded-circle" width="90" height="90">
                                @endif
                            </div>
                            <div class="ms-4">
                                <label for="profile_photo" class="form-label fw-bold">Ganti Foto Profil</label>
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control form-control-sm" accept="image/*">
                                @if ($errors->has('profile_photo'))
                                    <div class="text-danger small">{{ $errors->first('profile_photo') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                            @if ($errors->has('name'))
                                <div class="text-danger small">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <input type="text" class="form-control text-capitalize" value="{{ auth()->user()->role }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dibuat pada</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->created_at->format('d-m-Y H:i') }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Terakhir update</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->updated_at->format('d-m-Y H:i') }}" disabled>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('profile.change-password') }}" class="btn btn-warning">
                                <i class="fas fa-key"></i> Ganti Password
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
