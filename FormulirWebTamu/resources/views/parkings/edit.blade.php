@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <a href="javascript:history.back()" style="text-decoration: none; color: inherit;">
            <h1>Edit Parking</h1>
        </a>

        <form action="{{ route('parkings.destroy', $parking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this parking record?');" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Parking</button>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parkings.update', $parking->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="vehicle_name">Vehicle Name</label>
                    <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" value="{{ $parking->vehicle_name }}" disabled>
                </div>

                <div class="form-group mb-4">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="available" {{ $parking->status == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="vacant" {{ $parking->status == 'vacant' ? 'selected' : '' }}>Vacant</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="borrower_name">Borrower Name</label>
                    <input type="text" class="form-control" id="borrower_name" name="borrower_name" value="{{ $parking->borrower_name }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="license_number">License Number</label>
                    <input type="text" class="form-control" id="license_number" name="license_number" value="{{ $parking->license_number }}" disabled>
                </div>

                <div class="form-group mb-4">
                    <label for="parking_location">Parking Location</label>
                    <input type="text" class="form-control" id="parking_location" name="parking_location" value="{{ $parking->parking_location }}">
                </div>

                <div class="form-group mb-4">
                    <label for="borrower_position">Borrower Position</label>
                    <select class="form-control" id="borrower_position" name="borrower_position" onchange="toggleCustomPosition(this)" required>
                        <option value="" disabled {{ !$parking->borrower_position || !in_array($parking->borrower_position, ['Manager', 'Assistant Manager', 'Staff', 'Other']) ? 'selected' : '' }}>-- Select Position --</option>
                        <option value="Manager" {{ $parking->borrower_position == 'Manager' ? 'selected' : '' }}>Manager</option>
                        <option value="Assistant Manager" {{ $parking->borrower_position == 'Assistant Manager' ? 'selected' : '' }}>Assistant Manager</option>
                        <option value="Staff" {{ $parking->borrower_position == 'Staff' ? 'selected' : '' }}>Staff</option>
                        <option value="Other" {{ !in_array($parking->borrower_position, ['Manager', 'Assistant Manager', 'Staff']) && $parking->borrower_position ? 'selected' : '' }}>Other</option>
                    </select>

                    <input type="text" class="form-control mt-2" id="custom_position" name="custom_borrower_position" style="display: none;" placeholder="Enter position" value="{{ !in_array($parking->borrower_position, ['Manager', 'Assistant Manager', 'Staff']) ? $parking->borrower_position : '' }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Parking</button>
    </form>
</div>

<script>
    function toggleCustomPosition(select) {
        var customPositionInput = document.getElementById('custom_position');
        if (select.value === 'Other') {
            customPositionInput.style.display = 'block';
            customPositionInput.value = '';
        } else {
            customPositionInput.style.display = 'none';
            customPositionInput.value = select.value;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('borrower_position');
        if (select.value === 'Other') {
            document.getElementById('custom_position').style.display = 'block';
        }
    });
</script>
@endsection
