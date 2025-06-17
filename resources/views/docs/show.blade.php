<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Document | Cloud Document Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h1 class="h3 fw-bold text-primary mb-2">Title: {{ $doc->generated_name ?? '-' }}</h1>
            <h2 class="h5 fw-normal text-secondary mb-4">File Name: {{ $doc->title ?? '-' }}</h2>
            <div class="mb-3">
                <span class="badge bg-secondary me-2">Type: {{ strtoupper($doc->file_type) }}</span>
                <span class="badge bg-info text-dark me-2">Classification: {{ $doc->classification ?? 'Unclassified' }}</span>
                <span class="badge bg-light text-dark border">Uploaded: <span class="uploaded-at" data-utc="{{ $doc->uploaded_at }}"></span></span>
            </div>
            @if(in_array($doc->file_type, ['pdf']))
                <div class="ratio ratio-16x9 mb-4" style="min-height: 500px;">
                    <iframe src="{{ asset('storage/' . $doc->file_path) }}" width="100%" height="100%" style="border:0; min-height:500px;" allowfullscreen></iframe>
                </div>
            @elseif(in_array($doc->file_type, ['txt', 'doc', 'docx']))
                <div class="border rounded p-3 bg-light mb-4" id="doc-content" style="white-space: pre-wrap; min-height: 300px; cursor:text;">
                    {{ $doc->content }}
                </div>
            @else
                <div class="alert alert-warning">Preview not available for this file type.</div>
            @endif
            <div class="mt-4 text-center">
                <a href="{{ route('docs.index') }}" class="btn btn-outline-primary btn-sm">&larr; Back to Documents</a>
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
