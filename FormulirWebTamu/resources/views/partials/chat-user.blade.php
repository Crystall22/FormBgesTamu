<div class="list-group">
    @forelse($users as $user)
        <a href="{{ route('chat.user', $user->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-user-circle me-2"></i>{{ $user->name }}
                <span class="badge bg-info ms-2">{{ ucfirst($user->role) }}</span>
            </span>
            <i class="fas fa-chevron-right"></i>
        </a>
    @empty
        <div class="alert alert-warning mb-0">Tidak ada user ditemukan.</div>
    @endforelse
</div>
@if($users->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {!! $users->links() !!}
    </div>
@endif
