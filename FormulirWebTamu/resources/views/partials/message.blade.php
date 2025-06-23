<div class="px-3">
    @forelse($messages as $msg)
        <div class="mb-2 d-flex {{ $msg->from_user_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
            @if($msg->from_user_id != auth()->id())
                @php
                    $sender = $msg->fromUser;
                    $senderPhoto = $sender && $sender->profile_photo
                        ? asset('storage/' . $sender->profile_photo)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($sender?->name ?? 'User') . '&background=0D8ABC&color=fff';
                @endphp
                <img src="{{ $senderPhoto }}" alt="Foto Profil" class="rounded-circle me-2" width="32" height="32" style="object-fit:cover;">
            @endif
            <div>
                @if($msg->image_path)
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$msg->image_path) }}" target="_blank">
                            <img src="{{ asset('storage/'.$msg->image_path) }}"
                                 alt="Lampiran"
                                 class="img-fluid rounded"
                                 style="max-width:320px; max-height:320px; width:auto; height:auto; object-fit:contain; background:#f8f9fa; border:1px solid #e0e0e0;">
                        </a>
                    </div>
                @endif
                @if($msg->message)
                    <div class="px-3 py-2 rounded-4 shadow-sm
                        {{ $msg->from_user_id == auth()->id() ? 'bg-success text-white' : 'bg-white text-dark border' }}"
                        style="max-width: 420px; word-break: break-word; font-size:1.08em;">
                        {{ $msg->message }}
                    </div>
                @endif
                <div class="text-muted small mt-1 text-end" style="font-size:0.85em;">
                    {{ $msg->created_at->format('H:i d-m-Y') }}
                    @if($msg->from_user_id == auth()->id())
                        @if($msg->is_read)
                            <i class="fas fa-check-double ms-1" style="color:#2196f3"></i>
                        @else
                            <i class="fas fa-check-double ms-1 text-secondary"></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-muted text-center py-5">Belum ada pesan.</div>
    @endforelse
</div>
