{{-- filepath: resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Daftar Tamu</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tables</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">DataTables</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title">Daftar Tamu</h4>
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
                                        {{-- Contoh tombol aksi --}}
                                        <div class="form-button-action">
                                            <a href="{{ route('dashboard', $form->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            {{-- @if(auth()->user()->role === 'receptionist') --}}
                                            <form action="{{ route('form.destroy', $form->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                            {{-- @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- DataTables Kaiadmin --}}
@push('scripts')
<script>
    $(document).ready(function () {
        $('#guest-datatables').DataTable({
            "order": [[ 7, "desc" ]], // Urutkan berdasarkan tanggal terbaru
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
            }
        });
    });
</script>
@endpush
@endsection
