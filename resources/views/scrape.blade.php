<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrape Documents | Cloud Document Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e0e7ff 0%, #f0fdf4 100%); min-height: 100vh; }
        .glass { background: rgba(255,255,255,0.92); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18); backdrop-filter: blur(6px); border-radius: 2rem; border: 1px solid rgba(255,255,255,0.18); }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill d-flex align-items-center justify-content-center">
        <div class="glass container my-5 p-5 text-center" style="max-width: 600px;">
            <h1 class="display-6 fw-bold text-primary mb-4">Web Scraping Tool</h1>
            <form id="scrapeForm" class="mb-4" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="url" class="form-label">Target Page URL</label>
                    <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com/docs" required>
                </div>
                <div class="mb-3">
                    <label for="limit" class="form-label">Max Documents (default: 10)</label>
                    <input type="number" class="form-control" id="limit" name="limit" min="1" max="100" value="10">
                </div>
                <button type="submit" class="btn btn-primary w-100">Start Scraping</button>
            </form>
            <div id="scrapeStatus" style="display:none;">
                <div class="progress mb-3">
                    <div id="scrapeProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                </div>
                <pre id="scrapeOutput" class="text-start bg-light p-3 rounded small" style="max-height: 300px; overflow:auto;"></pre>
            </div>
        </div>
    </main>
    <footer class="w-100 py-4 bg-primary text-white border-top mt-auto shadow-sm">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col text-center">
                    <span class="fw-bold">Cloud & Distributed Systems (Course Project)</span><br>
                    <span class="fw-bold">By Hashem Nizar Alkeshawi (120190191) & Mohammed Ziad Abushammala (120200471)</span>
                </div>
            </div>
            <div class="text-center small mt-2">
                &copy; {{ date('Y') }} Cloud Document Analytics
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('scrapeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var status = document.getElementById('scrapeStatus');
        var progress = document.getElementById('scrapeProgress');
        var output = document.getElementById('scrapeOutput');
        status.style.display = 'block';
        progress.style.width = '10%';
        progress.textContent = 'Starting...';
        output.textContent = '';
        fetch('/scrape-docs', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            progress.style.width = '100%';
            if (data.exit_code === 0) {
                progress.classList.remove('bg-danger');
                progress.classList.add('bg-success');
                progress.textContent = 'Done!';
            } else {
                progress.classList.remove('bg-success');
                progress.classList.add('bg-danger');
                progress.textContent = 'Error';
            }
            output.textContent = data.output || 'No output.';
        })
        .catch(err => {
            progress.style.width = '100%';
            progress.classList.add('bg-danger');
            progress.textContent = 'Failed';
            output.textContent = err;
        });
    });
    </script>
</body>
</html>
