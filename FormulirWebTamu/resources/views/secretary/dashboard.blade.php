@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Secretary Dashboard</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped table-sm table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>Guest Name</th>
                    <th>Institution</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                    <tr>
                        <td>{{ $form->guest_name }}</td>
                        <td>{{ $form->institution }}</td>
                        <td>{{ $form->category }}</td>
                        <td>
                            <a href="{{ route('secretary.form', $form->id) }}" class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
            <div class="text-center mb-4">
                <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-primary px-5 py-3">
                    Go to Dashboard
                </a>
            </div>

@endsection
