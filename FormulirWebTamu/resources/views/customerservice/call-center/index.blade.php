@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-phone-alt text-primary me-2"></i>
            Rekap Panggilan Call Center
        </h3>
        <div>
            <form action="{{ route('customerservice.call-center.export') }}" method="GET" class="d-inline">
                <button type="submit" class="btn btn-success btn-sm px-3 py-2 shadow-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </form>
            <a href="{{ route('customerservice.call-center.create') }}" class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="call-center-datatables" class="display table table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Nomor Ponsel</th>
                            <th>Nomor Internet/Telepon Rumah</th>
                            <th>Kategori Keperluan</th>
                            <th>Keperluan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($calls as $i => $call)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $call->name }}</td>
                                <td>{{ $call->phone_number }}</td>
                                <td>{{ $call->connection_type }}</td>
                                <td>{{ $call->category }}</td>
                                <td>{{ $call->purpose }}</td>
                                <td class="text-center">
                                    <form action="{{ route('customerservice.call-center.destroy', $call->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#call-center-datatables').DataTable();
    });
</script>
@endpush
@endsection
