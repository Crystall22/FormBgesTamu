@extends('layouts.app')

@section('content')
<h1>Management Dashboard</h1>
@foreach($forms as $form)
    <div>
        <h2>{{ $form->guest_name }} ({{ $form->category }})</h2>
        <p>{{ $form->purpose }}</p>
        <p>Status: {{ $form->status }}</p>
        @if($form->status == 'Pending')
            <form action="{{ route('management.approve', $form->id) }}" method="POST">
                @csrf
                <button type="submit">Approve</button>
            </form>
            <form action="{{ route('management.reject', $form->id) }}" method="POST">
                @csrf
                <button type="submit">Reject</button>
            </form>
        @endif
    </div>
@endforeach
@endsection
