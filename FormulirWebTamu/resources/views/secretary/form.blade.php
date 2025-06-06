@extends('layouts.app')

@section('content')
    <!-- Back Button -->
    <div class="py-12">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <p2 class="text-lg font-semibold">
                Form Details
            </p2>
            <div class="ml-auto">
                <a href="{{ url()->previous() }}"
                    class="btn btn-lg btn-outline-secondary px-2 py-1 rounded-lg transition duration-300
                        ease-in-out hover:bg-gray-200 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </a>
            </div>
        </div>

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
                        <p><strong>Taken By:</strong> {{ $form->taken }}</p>
                        <p><strong>Purpose:</strong> {{ $form->purpose }}</p>
                    </div>
                </div>

                {{-- PDF Links --}}
                <div class="d-flex justify-content-start mt-4">
                    <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-primary me-2">
                        View PDF
                        <!-- svg icon -->
                    </a>
                    <a href="{{ route('secretary.download.pdf', ['id' => $form->id]) }}" class="btn btn-outline-secondary">
                        Download PDF
                        <!-- svg icon -->
                    </a>
                </div>
            </div>
        </div>

        {{-- Single Form for Note and Forward To Management --}}
        <form action="{{ route('secretary.update', $form->id) }}" method="POST">
            @csrf
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-secondary mb-3">Add Note for Management</h4>

                    <div class="form-group mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea name="note" id="note" class="form-control" rows="4" required>{{ old('note', $form->note ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="management_type" class="form-label">Forward To Management</label>
                        <select name="management_type" id="management_type" class="form-control" required>
                            <option value="" disabled selected>Select Management</option>
                            <option value="business" {{ (old('management_type', $form->forwarded_to_management_type ?? '') == 'business') ? 'selected' : '' }}>Business</option>
                            <option value="government" {{ (old('management_type', $form->forwarded_to_management_type ?? '') == 'government') ? 'selected' : '' }}>Government</option>
                            <option value="enterprise" {{ (old('management_type', $form->forwarded_to_management_type ?? '') == 'enterprise') ? 'selected' : '' }}>Enterprise</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        Forward to Management
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-send ms-2" viewBox="0 0 16 16">
                            <path
                                d="M15.854 0.146a.5.5 0 0 1 .154.5l-1.5 9a.5.5 0 0 1-.972.034L10.972 7.43 7.44 12.439a.5.5 0 0 1-.718.035l-4.5-4.5a.5.5 0 0 1 .035-.719L8.57 1.03l-2.585-2.585a.5.5 0 0 1 .034-.72l9 9a.5.5 0 0 1-.005.696L15.854.146zm-7.936 5.78L2.14 8.573l2.442 2.441 3.78-3.78-3.365-.515zm.78-1.07 4.002 4.003 2.073-.146.267-1.794-9-9-2.292 2.292z" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
