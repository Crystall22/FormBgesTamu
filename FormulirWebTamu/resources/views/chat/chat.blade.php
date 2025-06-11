@extends('layouts.app')
@section('content')
<style>
    /* Agar chat benar-benar full, hilangkan padding container utama */
    .chat-fullscreen-row {
        min-height: calc(100vh - 110px); /* kira-kira header+footer 110px */
        height: calc(100vh - 110px);
    }
    @media (max-width: 991.98px) {
        .chat-fullscreen-row { min-height: calc(100vh - 90px); height: calc(100vh - 90px);}
    }
</style>
<div class="row chat-fullscreen-row gx-0">
    <div class="col-12 d-flex flex-column px-0" style="height:100%;">
        <!-- Chat Header ala WhatsApp -->
        <div class="d-flex align-items-center gap-3 px-3 py-3 border-bottom bg-white" style="min-height:70px;">
            @php
                $profilePhoto = $user->profile_photo
                    ? asset('storage/' . $user->profile_photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff';
            @endphp
            <img src="{{ $profilePhoto }}" alt="Foto Profil" class="rounded-circle border" width="48" height="48" style="object-fit:cover;">
            <div>
                <div class="fw-bold text-dark" style="font-size:1.15em;">{{ $user->name }}</div>
                {{-- <div class="small text-muted">Online</div> --}}
            </div>
            <a href="{{ route('chat.index') }}" class="btn btn-light btn-sm ms-auto border">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <!-- Chat Body -->
        <div id="chatBody" class="flex-grow-1 px-0 py-3" style="background: #ece5dd; overflow-y:auto; min-height:0;">
            <div class="px-3">
                {{-- Pesan chat di sini --}}
                @include('partials.message', ['messages' => $messages])
            </div>
        </div>
        <!-- Chat Input -->
        <div class="border-top bg-white px-3 py-3">
            <form method="post" action="{{ route('chat.send', $user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-lg">
                    <input type="text" name="message" class="form-control rounded-start-4 border-end-0" placeholder="Ketik pesan..." autocomplete="off">
                    <input type="file" name="image" accept="image/*" class="form-control border-0" style="max-width:120px;">
                    <button class="btn btn-success rounded-end-4 px-4" type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
function fetchChat() {
    $.get("{{ route('chat.fetch', $user->id) }}", function(res) {
        $('#chatBody .px-3').replaceWith(res.html);
        var chatBody = document.getElementById('chatBody');
        if(chatBody) chatBody.scrollTop = chatBody.scrollHeight;
    });
}
$(function(){
    setInterval(fetchChat, 3000);
});
</script>
@endpush
@endsection
