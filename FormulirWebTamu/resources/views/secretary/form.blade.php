@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Form Details</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Guest Information</h4>
                <p><strong>Guest Name:</strong> {{ $form->guest_name }}</p>
                <p><strong>Phone:</strong> {{ $form->guest_phone }}</p>
                <p><strong>Address:</strong> {{ $form->guest_address }}</p>
                <p><strong>Institution:</strong> {{ $form->institution }}</p>
                <p><strong>Category:</strong> {{ $form->category }}</p>
                <p><strong>Purpose:</strong> {{ $form->purpose }}</p>

                <p><strong>PDF File:</strong></p>
                <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-primary">View PDF</a>
                <a href="{{ route('secretary.download.pdf', ['id' => $form->id]) }}" class="btn btn-secondary">Download PDF</a>
                </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Note for Management</h4>

                <form action="{{ route('secretary.update', $form->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" id="note" class="form-control" rows="4" required>{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Forward to Management</button>
                </form>
            </div>
        </div>
    </div>
@endsection
