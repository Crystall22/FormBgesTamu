@extends('layouts.app')

@section('content')
    <h1>Form Details</h1>

    <p><strong>Guest Name:</strong> {{ $form->guest_name }}</p>
    <p><strong>Phone:</strong> {{ $form->guest_phone }}</p>
    <p><strong>Address:</strong> {{ $form->guest_address }}</p>
    <p><strong>Institution:</strong> {{ $form->institution }}</p>
    <p><strong>Category:</strong> {{ $form->category }}</p>
    <p><strong>Purpose:</strong> {{ $form->purpose }}</p>
    <p><strong>PDF File:</strong> <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank">Download</a></p>

    <form action="{{ route('secretary.update', $form->id) }}" method="POST">
        @csrf
        <div>
            <label for="note">Add Note for Management</label>
            <textarea name="note" id="note" required>{{ old('note') }}</textarea>
        </div>

        <button type="submit">Forward to Management</button>
    </form>
@endsection
