@extends('layouts.app')

@section('content')
<div class="container page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <ul class="nav nav-pills nav-primary" id="dashboardTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="proses-tab" data-bs-toggle="pill" href="#proses" role="tab" aria-controls="proses" aria-selected="true">
                                Pengelolaan
                            </a>
                        </li>
                        @if(auth()->user()->role === 'receptionist')
                        <li class="nav-item">
                            <a class="nav-link" id="arsip-tab" data-bs-toggle="pill" href="#arsip" role="tab" aria-controls="arsip" aria-selected="false">
                                Arsip
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardTabContent">
                        {{-- Tab Pengelolaan --}}
                        <div class="tab-pane fade show active" id="proses" role="tabpanel" aria-labelledby="proses-tab">
                            <div class="table-responsive">
                                <table id="proses-datatables" class="display table table-striped table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tamu</th>
                                            <th>No HP</th>
                                            <th>Institusi</th>
                                            <th>Tujuan</th>
                                            <th>Petugas</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            @if(auth()->user()->role === 'receptionist')
                                                <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataProses as $i => $form)
                                        <tr class="clickable-row" data-href="{{ route('dashboard.detail', $form->id) }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $form->guest_name }}</td>
                                            <td>{{ $form->guest_phone }}</td>
                                            <td>{{ $form->institution }}</td>
                                            <td>{{ $form->purpose }}</td>
                                            <td>{{ $form->taken }}</td>
                                            <td data-order="{{ $form->created_at->format('Y-m-d H:i:s') }}">{{ $form->created_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                @if ($form->status === 'approved')
                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Accepted</span>
                                                @elseif ($form->status === 'rejected')
                                                    <a href="#" class="badge bg-danger text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#rejectReasonModal-{{ $form->id }}">
                                                        <i class="fas fa-times-circle me-1"></i>Rejected
                                                    </a>
                                                    <div class="modal fade" id="rejectReasonModal-{{ $form->id }}" tabindex="-1" aria-labelledby="rejectReasonLabel-{{ $form->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title" id="rejectReasonLabel-{{ $form->id }}">
                                                                        <i class="fas fa-comment-dots me-2"></i>Alasan Penolakan
                                                                    </h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-danger mb-0">
                                                                        {{ $form->reject_reason ?? 'Tidak ada alasan penolakan.' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Under Review</span>
                                                @endif
                                            </td>
                                            @if(auth()->user()->role === 'receptionist')
                                            <td>
                                                @if(auth()->user()->role === 'receptionist')
                                                    <form action="{{ route('dashboard.archive', $form->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Arsipkan data ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-secondary" title="Arsipkan">
                                                            <i class="fa fa-archive"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Tab Arsip --}}
                        @if(auth()->user()->role === 'receptionist')
                        <div class="tab-pane fade" id="arsip" role="tabpanel" aria-labelledby="arsip-tab">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Data Arsip</h5>
                                <a href="{{ route('dashboard.export') }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="arsip-datatables" class="display table table-striped table-hover w-100" style="min-width:1200px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tamu</th>
                                            <th>No HP</th>
                                            <th>Institusi</th>
                                            <th>Tujuan</th>
                                            <th>Petugas</th>
                                            <th>Tanggal Arsip</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataArsip as $i => $form)
                                        <tr class="clickable-row" data-href="{{ route('dashboard.detail', $form->id) }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $form->guest_name }}</td>
                                            <td>{{ $form->guest_phone }}</td>
                                            <td>{{ $form->institution }}</td>
                                            <td>{{ $form->purpose }}</td>
                                            <td>{{ $form->taken }}</td>
                                            <td data-order="{{ $form->updated_at->format('Y-m-d H:i:s') }}">{{ $form->updated_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                @if ($form->status === 'approved')
                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Accepted</span>
                                                @elseif ($form->status === 'rejected')
                                                    <a href="#" class="badge bg-danger text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#rejectReasonModalArsip-{{ $form->id }}">
                                                        <i class="fas fa-times-circle me-1"></i>Rejected
                                                    </a>
                                                    <!-- Modal alasan penolakan -->
                                                    <div class="modal fade" id="rejectReasonModalArsip-{{ $form->id }}" tabindex="-1" aria-labelledby="rejectReasonLabelArsip-{{ $form->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title" id="rejectReasonLabelArsip-{{ $form->id }}">
                                                                        <i class="fas fa-comment-dots me-2"></i>Alasan Penolakan
                                                                    </h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-danger mb-0">
                                                                        {{ $form->reject_reason ?? 'Tidak ada alasan penolakan.' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($form->status === 'under_review')
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Under Review</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('dashboard.unarchive', $form->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kembalikan data ini ke pengelolaan?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning" title="Unarchive">
                                                        <i class="fa fa-undo"></i> Unarchive
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('.clickable-row').on('click', function(e) {
            if (!$(e.target).is('a, button, .btn, .badge, form')) {
                window.location = $(this).data('href');
            }
        });

        $('#proses-datatables').DataTable({
            "order": [[ 6, "desc" ]],
            "columnDefs": [
                { "type": "datetime", "targets": 6 }
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "»",
                    "previous": "«"
                }
            },
            "scrollX": true,
            "pageLength": 5,
            "autoWidth": false,
            "dom": '<"top"f>rt<"bottom d-flex justify-content-between align-items-center"ip><"clear">'
        });
        $('#arsip-datatables').DataTable({
            "order": [[ 6, "desc" ]],
            "columnDefs": [
                { "type": "datetime", "targets": 6 }
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "»",
                    "previous": "«"
                }
            },
            "scrollX": true,
            "pageLength": 5,
            "autoWidth": false,
            "dom": '<"top"f>rt<"bottom d-flex justify-content-between align-items-center"ip><"clear">'
        });
    });
</script>
@endpush
@endsection
