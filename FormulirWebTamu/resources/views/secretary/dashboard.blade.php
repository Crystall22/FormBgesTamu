@extends('layouts.app')

@section('content')
<h1>Secretary Dashboard</h1>
@foreach($forms as $form)
    <div>
        <h2>{{ $form->guest_name }} ({{ $form->category }})</h2>
        <form action="{{ route('secretary.forward', $form->id) }}" method="POST">
            @csrf
            <textarea name="note" placeholder="Add a note">{{ $form->secretary_note }}</textarea>
            <button type="submit">Forward to Management</button>
        </form>
    </div>
@endforeach
@endsection
