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
    /* Custom style for image input */
    .input-group .btn-image {
        border-radius: 0;
        background: #f8f9fa;
        border: 1px solid #ced4da;
        border-right: none;
        padding: 0 12px;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .input-group .btn-image:hover {
        background: #e2e6ea;
    }
    .input-group input[type="file"] {
        display: none;
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
                <div class="input-group input-group-lg align-items-center">
                    <input type="text" name="message" class="form-control rounded-start-4 border-end-0" placeholder="Ketik pesan..." autocomplete="off">
                    <label class="btn btn-image mb-0" title="Lampirkan gambar" style="position:relative;">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" name="image" accept="image/*" id="chatImageInput">
                    </label>
                    <span id="imageSelectedIndicator" class="ms-2 text-success fw-semibold" style="display:none; font-size:1em;">
                        <i class="fas fa-check-circle"></i> Gambar dipilih
                    </span>
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

    // Indikator gambar dipilih
    $('#chatImageInput').on('change', function() {
        if (this.files && this.files.length > 0) {
            $('#imageSelectedIndicator').show();
        } else {
            $('#imageSelectedIndicator').hide();
        }
    });

    // Cegah submit chat kosong & validasi gambar
    $('form[action*="chat/send"]').on('submit', function(e) {
        var msg = $(this).find('input[name="message"]').val().trim();
        var img = $(this).find('input[type="file"]')[0].files[0];
        if (msg === "" && !img) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Pesan kosong!',
                text: 'Silakan ketik pesan atau lampirkan gambar.',
                timer: 1800,
                showConfirmButton: false
            });
            return;
        }
        if (img) {
            const maxSize = 4 * 1024 * 1024; // 4MB
            // Cek hanya tipe image/*
            if (!img.type.startsWith('image/')) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'File bukan gambar!',
                    text: 'Silakan pilih file gambar yang valid.',
                    timer: 2200,
                    showConfirmButton: false
                });
                return;
            }
            if (img.size > maxSize) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran gambar terlalu besar!',
                    text: 'Ukuran maksimal gambar adalah 4MB.',
                    timer: 2200,
                    showConfirmButton: false
                });
                return;
            }
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection
