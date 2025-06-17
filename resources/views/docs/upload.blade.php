<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Documents | Cloud Document Analytics</title>
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
        .custom-file-label {
            cursor: pointer;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill d-flex align-items-center justify-content-center">
        <div class="glass container my-5 p-5">
            <h1 class="display-6 fw-bold text-primary text-center mb-4">
                <span class="me-2">📂</span>Upload Your Documents
            </h1>
            <form id="uploadForm" action="{{ route('docs.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 500px;">
                @csrf
                <div class="mb-4">
                    <label for="documents" class="form-label fw-semibold">Select Word or PDF files</label>
                    <input class="form-control form-control-lg" type="file" id="documents" name="documents[]" accept=".pdf,.doc,.docx" multiple required>
                    <div class="form-text">You can select multiple files.</div>
                </div>
                <div class="mb-3" id="progressWrapper" style="display:none;">
                    <label for="uploadProgress" class="form-label">Uploading...</label>
                    <div class="progress">
                        <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                    ⬆️ Upload
                </button>
            </form>
            <div class="mt-4 text-center">
                <a href="/" class="text-primary text-decoration-underline small">&larr; Back to Home</a>
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
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        var progressWrapper = document.getElementById('progressWrapper');
        var progressBar = document.getElementById('uploadProgress');
        progressWrapper.style.display = 'block';
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                var percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressBar.textContent = percent + '%';
            }
        });
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200 || xhr.status === 201) {
                    progressBar.classList.remove('progress-bar-animated');
                    progressBar.classList.add('bg-success');
                    progressBar.textContent = 'Upload Complete!';
                    setTimeout(function() { window.location.href = '/docs'; }, 1000);
                } else {
                    progressBar.classList.remove('progress-bar-animated');
                    progressBar.classList.add('bg-danger');
                    progressBar.textContent = 'Upload Failed';
                }
            }
        };
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);
        xhr.send(formData);
    });
    </script>
</body>
</html>
