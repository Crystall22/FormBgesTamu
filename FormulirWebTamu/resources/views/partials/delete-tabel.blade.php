@foreach ($forms as $form)
    <tr>
        <td>{{ $form->created_at->format('Y-m-d') }}</td>
        <td>{{ $form->guest_name }}</td>
        <td>{{ $form->institution }}</td>
        <td>{{ $form->taken }}</td>
        <td>{{ $form->invoice_number }}</td>
        <td>
            <form action="{{ route('form.destroy', $form->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this form?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
