@foreach ($forms as $form)
    <div class="form-card">
        <h3>{{ $form->guest_name }} ({{ $form->category }})</h3>
        <p>{{ $form->purpose }}</p>
        <p>Submitted on: {{ $form->created_at }}</p>

        <form action="{{ route('secretary.addNote', $form->id) }}" method="POST">
            @csrf
            <textarea name="note" placeholder="Add a note"></textarea>
            <button type="submit">Forward to Management</button>
        </form>
    </div>
@endforeach
