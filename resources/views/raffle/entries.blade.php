@extends('layouts.app')

@section('content')
    <div class="mt-4">

        <h1 class="mb-4 text-center fw-bold">📥 Upload Raffle Entries</h1>

        {{-- Upload Form --}}
        <form action="{{ route('raffle.import') }}" method="POST" enctype="multipart/form-data" class="mb-5">
            @csrf
            <div class="input-group input-group-lg shadow-sm rounded">
                <input
                    type="file"
                    name="file"
                    class="form-control @error('file') is-invalid @enderror"
                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, text/plain"
                    required
                    aria-describedby="uploadHelp"
                >
                <button class="btn btn-primary" type="submit" id="uploadBtn">Upload</button>
            </div>
            <div id="uploadHelp" class="form-text text-muted">
                Supported formats: CSV (.csv)
            </div>

            @error('file')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </form>

        <h2 class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
            <span>
                🎟️ Current Raffle Entries
                <span class="badge bg-secondary">{{ $entries->count() }}</span>
            </span>

                {{-- Filter Dropdown --}}
                <form action="{{ route('raffle.entries') }}" method="GET">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                        <option value="winner" {{ $status === 'winner' ? 'selected' : '' }}>Winners</option>
                        <option value="loser" {{ $status === 'loser' ? 'selected' : '' }}>Losers</option>
                    </select>
                </form>
            </div>

            {{-- Clear All Button --}}
            <form
                action="{{ route('raffle.entries.clear') }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete all entries? This action cannot be undone.');"
            >
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    🗑️ Clear All
                </button>
            </form>

        </h2>


        @if ($entries->isEmpty())
            <div class="alert alert-warning text-center">No entries found.</div>
        @else
            <div class="list-group shadow-sm rounded" style="max-height: 400px; overflow-y: auto;">
                @foreach ($entries as $entry)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $entry->name }}</span>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-pill">{{ $loop->iteration }}</span>

                            <form
                                action="{{ route('raffle.entries.delete', $entry->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete entry: {{ addslashes($entry->name) }}?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Entry">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
