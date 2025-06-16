<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Document Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255,255,255,0.92);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(6px);
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.18);
        }
        .soft-bg {
            background: linear-gradient(135deg, #e0e7ff 0%, #f0fdf4 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="soft-bg min-h-screen flex flex-col">
    <main class="flex flex-1 items-center justify-center">
        <div class="glass max-w-3xl w-full mx-auto p-10 flex flex-col items-center justify-center">
            <h1 class="text-5xl font-extrabold text-blue-700 mb-6 drop-shadow-lg text-center">
                <span class="inline-block align-middle animate-pulse">☁️</span> Cloud-Based Document Analytics
            </h1>
            <p class="text-gray-700 text-lg text-center mb-8">
                Effortlessly search, sort, and classify your documents in the cloud with <span class="font-semibold text-blue-600">docs-analyser</span>.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full mb-8">
                <div class="bg-blue-100 p-6 rounded-2xl text-center shadow-lg hover:scale-105 transition-transform duration-300 border-t-4 border-blue-400">
                    <h2 class="text-xl font-semibold mb-2 text-blue-700">📂 Upload Documents</h2>
                    <p class="text-gray-600">Securely store Word and PDF files in the cloud.</p>
                </div>
                <div class="bg-green-100 p-6 rounded-2xl text-center shadow-lg hover:scale-105 transition-transform duration-300 border-t-4 border-green-400">
                    <h2 class="text-xl font-semibold mb-2 text-green-700">🔍 Search & Highlight</h2>
                    <p class="text-gray-600">Find documents with specific text and highlight matches.</p>
                </div>
                <div class="bg-yellow-100 p-6 rounded-2xl text-center shadow-lg hover:scale-105 transition-transform duration-300 border-t-4 border-yellow-400">
                    <h2 class="text-xl font-semibold mb-2 text-yellow-700">📊 Smart Classification</h2>
                    <p class="text-gray-600">Automatically categorize files using a custom classification tree.</p>
                </div>
            </div>
            <div class="mt-6 text-center">
                <a href="/upload" class="inline-block bg-gradient-to-r from-blue-600 to-green-400 hover:from-blue-700 hover:to-green-500 text-white font-extrabold py-5 px-16 rounded-2xl shadow-2xl transition-all duration-300 text-2xl tracking-wide border-4 border-blue-500 hover:border-green-500 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 transform hover:scale-105 active:scale-95">
                    🚀 Get Started
                </a>
            </div>
            <div class="mt-8 text-gray-500 text-sm">
                <p>Powered by Laravel, Tailwind CSS, and OpenAI.</p>
        </div>
    </main>
    <footer class="w-full py-6 bg-white/80 text-center text-gray-700 text-sm rounded-b-2xl shadow-inner mt-8">
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                © 2024 Hashem Alkeshawi<br>
                ID: 120190191
            </div>
            <div>
                © 2024 Muhammad Abushammalla<br>
                ID: AliasID
            </div>
        </div>
    </footer>
</body>
</html>
