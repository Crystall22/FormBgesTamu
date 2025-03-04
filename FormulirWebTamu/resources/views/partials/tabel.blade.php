<div class="w-full overflow-auto">
    <table class="min-w-full table-auto border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Guest Name</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Institution</th>
                <th class="border px-4 py-2">Taken By</th>
                <th class="border px-4 py-2">Invoice Number</th>
                <th class="border px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($forms as $form)
                <tr>
                    <td class="border px-4 py-2">{{ $form->created_at->format('Y-m-d') }}</td>
                    <td class="border px-4 py-2">{{ $form->guest_name }}</td>
                    <td class="border px-4 py-2">{{ $form->guest_phone }}</td>
                    <td class="border px-4 py-2">{{ $form->institution }}</td>
                    <td class="border px-4 py-2">{{ $form->taken }}</td>
                    <td class="border px-4 py-2">{{ $form->invoice_number }}</td>
                    <td class="border px-4 py-2">
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

<!-- Pagination -->
<div class="pagination">
    {{-- Previous Page Link --}}
    @if ($forms->onFirstPage())
      <a class="disabled" href="#">&laquo;</a>
    @else
      <a href="{{ $forms->previousPageUrl() }}">&laquo;</a>
    @endif

    {{-- Pagination Links --}}
    @for ($i = 1; $i <= $forms->lastPage(); $i++)
      <a href="{{ $forms->url($i) }}" class="{{ ($forms->currentPage() == $i) ? 'active' : '' }}">
        {{ $i }}
      </a>
    @endfor

    {{-- Next Page Link --}}
    @if ($forms->hasMorePages())
      <a href="{{ $forms->nextPageUrl() }}">&raquo;</a>
    @else
      <a class="disabled" href="#">&raquo;</a>
    @endif
  </div>
