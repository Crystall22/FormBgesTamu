@extends('layouts.app')

@section('header', 'Forms Dashboard')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Guest Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Institution</th>
                <th>Date</th>
                <th>Purpose</th>
                <th>Category</th>
                <th>Invoice Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
            <tr>
                <td>{{ $form->guest_name }}</td>
                <td>{{ $form->guest_phone }}</td>
                <td>{{ $form->guest_address }}</td>
                <td>{{ $form->institution }}</td>
                <td>{{ $form->date }}</td>
                <td>{{ $form->purpose }}</td>
                <td>{{ $form->category }}</td>
                <td>{{ $form->invoice_number }}</td>
                <td>
                    @if ($form->status === 'accepted')
                        <span class="badge badge-success">Accepted</span>
                    @elseif ($form->status === 'rejected')
                        <span class="badge badge-danger">Rejected</span>
                    @else
                        <span class="badge badge-warning">Under Review</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
