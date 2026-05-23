<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Partner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Panel Admin - Manajemen Partner</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5>Tambah Partner Baru</h5>
                            <form action="{{ route('partners.store') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="name" class="form-control" placeholder="Nama Partner" required>
                                </div>
                                <div class="input-group">
                                    <input type="url" name="logo_url" class="form-control" placeholder="Link URL Logo (https://...)" required>
                                    <button class="btn btn-success" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h5>Cari Partner</h5>
                            <form action="{{ route('partners.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                    @if(request('search'))
                                        <a href="{{ route('partners.index') }}" class="btn alert-secondary border">Reset</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Daftar Partner</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Logo Preview</th>
                                <th>Nama Partner</th>
                                <th>Created At</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partners as $partner)
                                <tr>
                                    <td>{{ $partner->id }}</td>
                                    <td>
                                        <img src="{{ $partner->logo_url }}" alt="Logo" style="height: 50px; object-fit: contain;" onerror="this.src='https://placehold.co/100x50?text=No+Image'">
                                    </td>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->created_at }}</td>
                                    <td>
                                        <form action="{{ route('partners.update', $partner->id) }}" method="POST" class="d-inline-block me-2">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="name" value="{{ $partner->name }}" class="form-control" required style="width: 120px;">
                                                <input type="url" name="logo_url" value="{{ $partner->logo_url }}" class="form-control" required style="width: 180px;">
                                                <button class="btn btn-warning" type="submit">Ubah</button>
                                            </div>
                                        </form>

                                        <form action="{{ route('partners.destroy', $partner->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus partner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data partner tidak ditemukan atau masih kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>