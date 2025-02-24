@extends('layouts.app')

@section('header', 'Forms Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}"
                    class="btn btn-lg btn-outline-secondary px-5 py-3 rounded-lg shadow-lg transition duration-300
                    ease-in-out hover:bg-gray-200 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Guest Name</th>
                                <th>Phone</th>
                                <th>Institution</th>
                                <th>Category</th>
                                <th>Invoice Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($forms as $form)
                                <tr>
                                    <td>{{ $form->date }}</td>
                                    <td>{{ $form->guest_name }}</td>
                                    <td>{{ $form->guest_phone }}</td>
                                    <td>{{ $form->institution }}</td>
                                    <td>{{ $form->category }}</td>
                                    <td>{{ $form->invoice_number }}</td>
                                    <td>
                                        @if ($form->status === 'approved')
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

                </div>
            </div>
        </div>
    </div>
@endsection
