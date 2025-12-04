<!DOCTYPE html>
<html>
<head>
    <title>Simple E-Raffle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h1 class="mb-4">E-Raffle System</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('winner'))
    <div class="alert alert-info">🎉 Winner: <strong>{{ session('winner') }}</strong></div>
@endif

<form action="{{ route('raffle.import.csv') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf
    <div class="input-group">
        <input type="file" name="file" class="form-control" required>
        <button class="btn btn-secondary" type="submit">Upload CSV</button>
    </div>
</form>


<form action="{{ route('raffle.store') }}" method="POST" class="mb-4">
    @csrf
    <div class="input-group">
        <input type="text" name="name" class="form-control" placeholder="Enter name" required>
        <button class="btn btn-primary" type="submit">Add Entry</button>
    </div>
</form>

<h3>Entries</h3>
<ul class="list-group mb-4">
    @forelse($entries as $entry)
        <li class="list-group-item">{{ $entry->name }}</li>
    @empty
        <li class="list-group-item">No entries yet.</li>
    @endforelse
</ul>

<a href="{{ route('raffle.draw') }}" class="btn btn-success">🎯 Draw Winner</a>

</body>
</html>
