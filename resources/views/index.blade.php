<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Document Analytics</title>
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
        .hover-shadow:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .feature-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .feature-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18), 0 2px 8px 0 rgba(0,0,0,0.10);
            z-index: 2;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill d-flex align-items-center justify-content-center">
        <div class="glass container my-5 p-5 text-center">
            <h1 class="display-4 fw-bold text-primary mb-4">
                <span class="me-2 animate-pulse">☁️</span>Cloud-Based Document Analytics
            </h1>
            <p class="lead text-secondary mb-5">
                Effortlessly search, sort, and classify your documents in the cloud with <span class="fw-semibold text-primary">docs-analyser</span>.
            </p>
            <div class="alert alert-info mx-auto mb-4" style="max-width: 600px;">
                <strong>Course Project:</strong> This project, <em>Cloud Document Analytics</em>, was developed for the Cloud Computing course at IUG.<br>
                The following students worked on this project:
                <ul class="mb-0 mt-2 text-start" style="list-style: disc inside;">
                    <li><strong>Hashem Nizar Alkeshawi</strong> (ID: 120190191)</li>
                    <li><strong>Mohammed Ziad Abushamalla</strong> (ID: 120200000)</li>
                </ul>
            </div>
            <form method="GET" action="" class="mb-4">
                <div class="input-group mx-auto" style="max-width: 500px;">
                    <input type="text" name="q" class="form-control" placeholder="Search documents..." value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <a href="/docs/create" class="text-decoration-none">
                        <div class="card feature-card h-100 border-0 shadow-sm bg-blue-100">
                            <div class="card-body">
                                <h2 class="h5 fw-bold text-primary mb-2">📂 Upload Documents</h2>
                                <p class="text-secondary">Securely store Word and PDF files in the cloud.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/docs" class="text-decoration-none">
                        <div class="card feature-card h-100 border-0 shadow-sm bg-green-100">
                            <div class="card-body">
                                <h2 class="h5 fw-bold text-success mb-2">🔍 Search & Highlight</h2>
                                <p class="text-secondary">Find documents with specific text and highlight matches.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('docs.indexByTitle') }}" class="text-decoration-none">
                        <div class="card feature-card h-100 border-0 shadow-sm bg-warning-subtle">
                            <div class="card-body">
                                <h2 class="h5 fw-bold text-warning mb-2">📊 Smart Classification</h2>
                                <p class="text-secondary">Automatically categorize files using a custom classification tree.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="mb-4">
                <button onclick="window.location.href='/docs/create'" type="button" class="btn btn-lg btn-gradient-primary fw-bold px-5 py-3 shadow-lg">
                    🚀 Upload Files
                </button>
                <button onclick="window.location.href='/docs'" type="button" class="btn btn-lg btn-outline-secondary fw-bold px-5 py-3 shadow-sm">
                    📄 Show All Documents
                </button>
                <button onclick="window.location.href='/scrape'" type="button" class="btn btn-lg btn-outline-info fw-bold px-5 py-3 shadow-sm">
                    🌐 Scrape Documents
                </button>
            </div>
            <div class="text-secondary small mb-2">
                Build by Laravel and Bootstrap || with the help of GitHub Copilot & OpenAI.
            </div>
        </div>
    </main>
    <footer class="w-100 py-4 bg-white border-top mt-auto shadow-sm">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <span class="fw-normal text-muted">Cloud &amp; Distributed Systems (Course Project)</span><br>
                    <span class="text-muted small">By Hashem Alkeshawi (120190191), Mohammed Abushamalla (120200000)</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="fst-italic text-secondary small">Proud builders of this course project</span>
                </div>
            </div>
            <div class="text-center text-muted small mt-2">
                &copy; {{ date('Y') }} Cloud Document Analytics &mdash; All rights reserved.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
