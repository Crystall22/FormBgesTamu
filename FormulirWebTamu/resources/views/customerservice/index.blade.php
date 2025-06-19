@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-database text-primary me-2"></i>
            Rekap Data Modem
        </h3>
        <div>
            <form action="{{ route('customerservice.modem.export') }}" method="GET" class="d-inline">
                <button type="submit" class="btn btn-success btn-sm px-3 py-2 shadow-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="start_date" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" id="end_date" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="filterButton" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="modem-datatables" class="display table table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Keluar</th>
                            <th>ID Pelanggan</th>
                            <th>Provider Modem</th>
                            <th>Serial Number Modem</th>
                            <th>Set Top Box ID</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modems as $i => $modem)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $modem->tanggal_terima }}</td>
                                <td>{{ $modem->tanggal_keluar ?? '-' }}</td>
                                <td>{{ $modem->id_pelanggan }}</td>
                                <td>{{ $modem->provider_modem === 'other' ? $modem->manual_provider : ucfirst($modem->provider_modem) }}</td>
                                <td>{{ $modem->serial_number_modem }}</td>
                                <td>{{ $modem->stb_id }}</td>
                                <td class="text-center">
                                    <a href="{{ route('customerservice.modem.edit', $modem->id) }}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('customerservice.modem.destroy', $modem->id) }}" method="POST" style="display:inline;">
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
        const table = $('#modem-datatables').DataTable();

        $('#filterButton').on('click', function () {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();

            table.draw();
        });

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();
            const tanggalTerima = data[1]; // Index kolom Tanggal Terima

            if (startDate && tanggalTerima < startDate) return false;
            if (endDate && tanggalTerima > endDate) return false;

            return true;
        });
    });
</script>
@endpush
@endsection
