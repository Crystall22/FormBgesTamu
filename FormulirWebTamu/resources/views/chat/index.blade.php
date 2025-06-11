{{-- filepath: resources/views/chat/index.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-comments fa-lg me-2"></i>
            <h4 class="mb-0">Cari User untuk Chat</h4>
        </div>
        <div class="card-body">
            <div class="row g-2 mb-3 align-items-end">
                <div class="col-md-6">
                    <label for="searchUser" class="form-label mb-1">Cari Nama User</label>
                    <input type="text" id="searchUser" class="form-control" placeholder="Ketik nama user...">
                </div>
                <div class="col-md-4">
                    <label for="roleSort" class="form-label mb-1">Filter Role</label>
                    <select id="roleSort" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="userList">
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function fetchUsers(page = 1) {
        let search = $('#searchUser').val();
        let role = $('#roleSort').val();
        $('#userList').html('<div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
        $.ajax({
            url: "{{ route('chat.index') }}?page=" + page,
            data: { search: search, role: role, ajax: 1 },
            success: function(res) {
                $('#userList').html(res.html + res.pagination);
            }
        });
    }

    $(document).ready(function () {
        fetchUsers();
        let debounceTimer;
        $('#searchUser').on('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchUsers(), 300);
        });
        $('#roleSort').on('change', function () {
            fetchUsers();
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchUsers(page);
        });
    });
</script>
@endpush
@endsection
