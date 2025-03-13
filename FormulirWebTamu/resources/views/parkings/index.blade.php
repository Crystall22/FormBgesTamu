@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Parking List</h1>
        <a href="{{ route('parkings.create') }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Car</th>
                <th>License Number</th>
                <th>Status</th>
                <th>Borrower</th>
                <th>Parking Location</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parkings as $parking)
                <tr data-href="{{ route('parkings.edit', $parking->id) }}" style="cursor: pointer;">
                    <td>
                        {{ $parking->vehicle_name }}
                    </td>
                    <td>
                        {{ preg_replace('/([A-Za-z]{1,2})(\d{1,4})([A-Za-z]{0,4})/', '$1 $2 $3', $parking->license_number) }}
                    </td>
                    <td>
                        <span class="{{ $parking->status == 'available' ? 'text-success' : ($parking->status == 'vacant' ? 'text-danger' : '') }}">
                            {{ ucwords($parking->status ?? '-' )}}
                        </span>
                    </td>
                    <td>
                        {{ $parking->borrower_name ? $parking->borrower_name : '-' }} |
                        {{ $parking->borrower_position ? $parking->borrower_position : '-' }}
                    </td>
                    <td>
                        {{ $parking->parking_location ?? '-' }}
                    </td>
                    <td>
                        @if ($parking->updated_at->isToday())
                            Today, {{ $parking->updated_at->format('H:i:s') }}
                        @elseif ($parking->updated_at->isYesterday())
                            Yesterday, {{ $parking->updated_at->format('H:i:s') }}
                        @elseif ($parking->updated_at->diffInDays() <= 7)
                            {{ $parking->updated_at->format('l, H:i:s') }}
                        @else
                            {{ $parking->updated_at->format('d M Y, H:i:s') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('tr[data-href]');
        rows.forEach(row => {
            row.addEventListener('click', function () {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>
@endsection
