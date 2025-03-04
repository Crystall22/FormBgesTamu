@foreach ($forms as $form)
    <tr>
        <td>{{ $form->created_at->format('Y-m-d') }}</td>
        <td>{{ $form->guest_name }}</td>
        <td>{{ $form->institution }}</td>
        <td>{{ $form->taken }}</td>
        <td>{{ $form->invoice_number }}</td>
        <td>
            <form action="{{ route('form.destroy', $form->id) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This action is irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your form has been deleted.',
                        'success'
                    );
                    form.submit();
                }
            });
        });
    });
</script>
