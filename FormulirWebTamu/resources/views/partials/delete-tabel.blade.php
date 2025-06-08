{{-- filepath: resources/views/partials/delete-tabel.blade.php --}}
@forelse($forms as $form)
<tr>
    <td>
        <span class="badge bg-light text-dark">
            <i class="fas fa-calendar-day me-1"></i>
            {{ $form->created_at ? $form->created_at->format('d-m-Y') : '-' }}
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
            <a href="{{ route('dashboard', $form->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Detail">
                <i class="fas fa-eye"></i>
            </a>
            <form action="{{ route('form.destroy', $form->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Yakin hapus data ini?')">
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
