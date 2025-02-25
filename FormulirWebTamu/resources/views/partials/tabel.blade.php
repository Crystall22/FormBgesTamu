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
                <td>{{ $form->created_at->format('Y-m-d') }}</td>
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

<!-- Pagination -->
@if($forms->hasPages())
    {{ $forms->links() }}
@endif
