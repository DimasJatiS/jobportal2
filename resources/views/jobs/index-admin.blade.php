@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">
            <i class="bi bi-briefcase-fill"></i> Manajemen Lowongan
        </h3>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.jobs.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Tambah Lowongan
            </a>

            <a href="{{ route('admin.jobs.import.template') }}" class="btn btn-outline-secondary">
                <i class="bi bi-download"></i> Template Import
            </a>

            <form action="{{ route('admin.jobs.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                @csrf
                <input type="file" name="file" accept=".xlsx,.csv" required class="form-control form-control-sm me-2">
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-upload"></i> Import
                </button>
            </form>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Daftar Lowongan --}}
    @if($jobs->count())
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($jobs as $job)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card">

                        {{-- Logo perusahaan --}}
                        @if($job->logo)
                            <img src="{{ asset('storage/' . $job->logo) }}"
                                 class="card-img-top p-3 rounded"
                                 alt="{{ $job->company }}">
                        @else
                            <div class="card-img-top text-center py-5 bg-light text-muted">No Logo</div>
                        @endif

                        {{-- Isi card --}}
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-semibold">{{ $job->title }}</h5>
                            <p class="mb-1 text-secondary">
                                <i class="bi bi-building"></i> {{ $job->company }}
                            </p>
                            <p class="mb-1 text-secondary">
                                <i class="bi bi-geo-alt"></i> {{ $job->location }}
                            </p>
                            <p class="text-success fw-semibold">
                                <i class="bi bi-cash"></i> Rp {{ number_format($job->salary ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-muted small">
                                <i class="bi bi-briefcase"></i> {{ $job->type }}
                            </p>
                        </div>

                        {{-- Aksi --}}
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                            <a href="{{ route('admin.applications.index', $job->id) }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="bi bi-people"></i> Pelamar
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $jobs->links() }}
        </div>

    @else
        <div class="alert alert-info text-center">
            Belum ada lowongan yang tersedia.
        </div>
    @endif
</div>
@endsection
