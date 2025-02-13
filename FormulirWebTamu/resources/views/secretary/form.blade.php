@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1 class="mb-4 text-center text-primary">Form Details</h1>

        {{-- Guest Information Card --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-4 text-secondary">Guest Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Guest Name:</strong> {{ $form->guest_name }}</p>
                        <p><strong>Phone:</strong> {{ $form->guest_phone }}</p>
                        <p><strong>Address:</strong> {{ $form->guest_address }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Institution:</strong> {{ $form->institution }}</p>
                        <p><strong>Category:</strong> {{ $form->category }}</p>
                        <p><strong>Purpose:</strong> {{ $form->purpose }}</p>
                    </div>
                </div>

                {{-- PDF Links --}}
                <div class="d-flex justify-content-start mt-4">
                    <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-primary me-2">
                        View PDF
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf ms-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                        </svg>
                    </a>
                    <a href="{{ route('secretary.download.pdf', ['id' => $form->id]) }}" class="btn btn-outline-secondary">
                        Download PDF
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download ms-1" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Note Form --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title text-secondary">Add Note for Management</h4>

                <form action="{{ route('secretary.update', $form->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea name="note" id="note" class="form-control" rows="4" required>{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        Forward to Management
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send ms-2" viewBox="0 0 16 16">
                            <path d="M15.854 0.146a.5.5 0 0 1 .154.5l-1.5 9a.5.5 0 0 1-.972.034L10.972 7.43 7.44 12.439a.5.5 0 0 1-.718.035l-4.5-4.5a.5.5 0 0 1 .035-.719L8.57 1.03l-2.585-2.585a.5.5 0 0 1 .034-.72l9 9a.5.5 0 0 1-.005.696L15.854.146zm-7.936 5.78L2.14 8.573l2.442 2.441 3.78-3.78-3.365-.515zm.78-1.07 4.002 4.003 2.073-.146.267-1.794-9-9-2.292 2.292z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
