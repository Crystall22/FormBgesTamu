{{-- filepath: resources/views/dashboard.blade.php --}}
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
                    <h4 class="card-title">Daftar Pengunjung</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="guest-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Tamu</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Institusi</th>
                                    <th>Tujuan</th>
                                    <th>PDF</th>
                                    <th>Petugas</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forms as $form)
                                <tr>
                                    <td>{{ $form->guest_name }}</td>
                                    <td>{{ $form->guest_phone }}</td>
                                    <td>{{ $form->guest_address }}</td>
                                    <td>{{ $form->institution }}</td>
                                    <td>{{ $form->purpose }}</td>
                                    <td>
                                        @if($form->pdf_file)
                                            <a href="{{ asset('storage/'.$form->pdf_file) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-file-pdf"></i> Lihat
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $form->taken }}</td>
                                    <td>{{ $form->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if ($form->status === 'approved')
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Accepted</span>
                                        @elseif ($form->status === 'rejected')
                                            <!-- Klik badge rejected untuk lihat alasan -->
                                            <a href="#" class="badge bg-danger text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#rejectReasonModal-{{ $form->id }}">
                                                <i class="fas fa-times-circle me-1"></i>Rejected
                                            </a>
                                            <!-- Modal alasan penolakan -->
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
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('dashboard.detail', $form->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!-- (opsional: tambahkan baris footer jika perlu) -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#guest-datatables').DataTable({
            "order": [[ 7, "desc" ]],
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
            "pageLength": 5, // jumlah data per halaman
            "dom": '<"top"f>rt<"bottom d-flex justify-content-between align-items-center"ip><"clear">'
        });
    });
</script>
@endpush
@endsection
