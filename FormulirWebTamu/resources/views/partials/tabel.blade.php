{{-- filepath: resources/views/partials/tabel.blade.php --}}
<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th><i class="fas fa-calendar-day"></i> Date</th>
            <th><i class="fas fa-user"></i> Guest Name</th>
            <th><i class="fas fa-phone"></i> Phone</th>
            <th><i class="fas fa-building"></i> Institution</th>
            <th><i class="fas fa-user-check"></i> Taken By</th>
            <th><i class="fas fa-file-invoice"></i> Invoice Number</th>
            <th><i class="fas fa-info-circle"></i> Status</th>
            <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($forms as $form)
            <tr>
                <td>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-calendar-day me-1"></i>
                        {{ $form->created_at ? $form->created_at->format('Y-m-d') : 'N/A' }}
                    </span>
                </td>
                <td>
                    <i class="fas fa-user text-primary me-1"></i>
                    {{ $form->guest_name ?? 'N/A' }}
                </td>
                <td>
                    <i class="fas fa-phone text-info me-1"></i>
                    {{ $form->guest_phone ?? 'N/A' }}
                </td>
                <td>
                    <i class="fas fa-building text-secondary me-1"></i>
                    {{ $form->institution ?? 'N/A' }}
                </td>
                <td>
                    <i class="fas fa-user-check text-success me-1"></i>
                    {{ $form->taken ?? 'N/A' }}
                </td>
                <td>
                    <i class="fas fa-file-invoice text-info me-1"></i>
                    {{ $form->invoice_number ?? 'N/A' }}
                </td>
                <td>
                    @if ($form->status === 'approved')
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Accepted</span>
                    @elseif ($form->status === 'rejected')
                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Under Review</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('dashboard', ['id' => $form->id]) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <div>No data found.</div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
