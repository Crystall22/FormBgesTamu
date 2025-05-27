<table class="min-w-full table-auto border-collapse border border-gray-300">
    <thead>
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
    <tbody>
        @foreach ($forms as $form)
            <tr>
                <td class="border px-4 py-2">
                    {{ $form->created_at ? $form->created_at->format('Y-m-d') : 'N/A' }}
                </td>
                <td class="border px-4 py-2">{{ $form->guest_name ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $form->guest_phone ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $form->institution ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $form->taken ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $form->invoice_number ?? 'N/A' }}</td>
                <td class="border px-4 py-2">
                    @if ($form->status === 'approved')
                        <span class="badge badge-success ">Accepted</span>
                    @elseif ($form->status === 'rejected')
                        <span class="badge badge-danger">Rejected</span>
                    @else
                        <span class="badge badge-warning text-transparent">Under Review</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
