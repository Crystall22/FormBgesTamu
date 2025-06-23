@forelse($forms as $form)
<tr>
    <td>
        <span class="badge bg-light text-dark">
            <i class="fas fa-calendar-day me-1"></i>
            {{ $form->created_at ? $form->created_at->format('m-d-Y') : '-' }}
        </span>
    </td>
    <td>
        <i class="fas fa-user text-primary me-1"></i>
        {{ $form->guest_name }}
    </td>
    <td>
        <i class="fas fa-building text-secondary me-1"></i>
        {{ $form->institution }}
    </td>
    <td>
        <i class="fas fa-user-check text-success me-1"></i>
        {{ $form->taken }}
    </td>
    <td>
        <i class="fas fa-file-invoice text-info me-1"></i>
        {{ $form->invoice_number ?? '-' }}
    </td>
    <td>
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.detail', $form->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Detail">
                <i class="fas fa-eye"></i>
            </a>
            <form action="{{ route('form.destroy', $form->id) }}" method="POST" id="delete-form-{{ $form->id }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDeletion({{ $form->id }})">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted py-4">
        <i class="fas fa-inbox fa-2x mb-2"></i>
        <div>No data found.</div>
    </td>
</tr>
@endforelse

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Function to handle delete confirmation
    function confirmDeletion(formId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form after confirmation
                document.getElementById('delete-form-' + formId).submit();
            }
        });
    }
</script>
@endpush
