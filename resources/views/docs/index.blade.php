<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Documents | Cloud Document Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e0e7ff 0%, #f0fdf4 100%); min-height: 100vh; }
        .glass {
            background: rgba(255,255,255,0.92);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(6px);
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.18);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill d-flex align-items-center justify-content-center">
        <div class="glass container my-5 p-5">
            <h1 class="display-5 fw-bold text-primary text-center mb-4">Available Documents</h1>
            @if(session('success'))
                <div class="alert alert-success text-center fw-bold">
                    {{ session('success') }}
                </div>
            @endif
            @php
                $highlighted = session('highlighted_docs') ?? [];
            @endphp
            <div class="d-flex justify-content-end mb-3">
                <div class="btn-group" role="group" aria-label="Sort options">
                    <a href="{{ route('docs.index') }}" class="btn btn-outline-primary @if(request()->routeIs('docs.index')) active @endif">Sort by Upload Time</a>
                    <a href="{{ route('docs.indexByTitle') }}" class="btn btn-outline-primary @if(request()->routeIs('docs.indexByTitle')) active @endif">Sort by Title</a>
                </div>
            </div>
            <form method="GET" action="" class="mb-4">
                <div class="input-group mx-auto" style="max-width: 500px;">
                    <input type="text" name="q" class="form-control" placeholder="Search documents..." value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
            @if(count($docs) > 0)
                <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered rounded-3 overflow-hidden bg-white">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">File Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Size</th>
                            <th scope="col">Classification</th>
                            <th scope="col">Uploaded At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docs as $i => $doc)
                        <tr @if(in_array($doc->id, $highlighted)) class="table-success" @endif>
                            <th scope="row">{{ $i + 1 }}</th>
                            <td>
                                <div class="fw-semibold text-primary">{{ $doc->generated_name ?? '-' }}</div>
                                <div class="text-muted small">Title</div>
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="fw-semibold text-decoration-none text-primary">
                                    <span class="me-2">📄</span>{{ $doc->title }}
                                </a>
                                <div class="text-muted small">File Name</div>
                                @if($doc->description)
                                    <div class="text-muted small mt-1">{{ $doc->description }}</div>
                                @endif
                            </td>
                            <td class="text-secondary text-uppercase">{{ $doc->file_type }}</td>
                            <td class="text-secondary">{{ number_format($doc->size / 1024, 2) }} KB</td>
                            <td>
                                @if($doc->classification)
                                    <span class="badge bg-success">{{ $doc->classification }}</span>
                                @else
                                    <span class="badge bg-secondary">Unclassified</span>
                                @endif
                            </td>
                            <td class="text-secondary">
                                <span class="uploaded-at" data-utc="{{ $doc->uploaded_at }}"></span>
                            </td>
                            <td>
                                <a href="{{ route('docs.show', $doc->id) }}" class="btn btn-sm btn-outline-primary me-2">View</a>
                                <form action="{{ route('docs.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            @else
                <div class="alert alert-info text-center my-5">
                    No documents found.<br>
                    <a href="/docs/create" class="fw-bold text-primary text-decoration-underline">Upload your first document</a>
                </div>
            @endif
            <div class="mt-4 text-center">
                <a href="/" class="text-primary text-decoration-underline small me-3">&larr; Back to Home</a>
                <a href="{{ route('docs.create') }}" class="btn btn-success btn-sm fw-bold">+ Upload More</a>
            </div>
        </div>
    </main>
    <footer class="w-100 py-4 bg-white border-top mt-auto shadow-sm">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <span class="fw-bold text-primary">Cloud &amp; Distributed Systems (Required Course)</span><br>
                    <span class="text-secondary">Project by:</span>
                    <span class="badge bg-primary ms-2">Hashem Alkeshawi</span>
                    <span class="badge bg-light text-dark border ms-2">ID: 120190191</span>
                    <span class="badge bg-success ms-2">Mohammed Abushamalla</span>
                    <span class="badge bg-light text-dark border ms-2">ID: 120200000</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="fst-italic text-secondary">Proud builders of this course project</span>
                </div>
            </div>
            <div class="text-center text-muted small mt-2">
                &copy; {{ date('Y') }} Cloud Document Analytics &mdash; All rights reserved.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.uploaded-at').forEach(function(el) {
                const utc = el.getAttribute('data-utc');
                if (utc) {
                    const local = new Date(utc + ' UTC');
                    el.textContent = local.toLocaleString();
                }
            });
        });
    </script>
</body>
</html>
