<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="font-bold text-xl text-indigo-600">ShortLink</span>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="/admin" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Cabinet</a>
                    @else
                        <a href="/admin/login" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="/admin/register" class="bg-indigo-600 text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium ml-2">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Create Short Link</h2>
            
            <form id="shorten-form" class="space-y-6">
                <div>
                    <label for="original_url" class="block text-sm font-medium text-gray-700">Original URL</label>
                    <div class="mt-1">
                        <input type="url" name="original_url" id="original_url" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="https://example.com/long-url">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Shorten
                    </button>
                </div>
            </form>

            <div id="result" class="mt-6 hidden">
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Success!</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Your short link is: <a id="short-url" href="#" target="_blank" class="font-bold underline"></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="error" class="mt-6 hidden">
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Error</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p id="error-message"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('shorten-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const originalUrl = document.getElementById('original_url').value;
            const resultDiv = document.getElementById('result');
            const errorDiv = document.getElementById('error');
            const shortUrlLink = document.getElementById('short-url');
            const errorMessage = document.getElementById('error-message');
            
            resultDiv.classList.add('hidden');
            errorDiv.classList.add('hidden');
            
            try {
                const response = await fetch('/api/links', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ original_url: originalUrl })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    shortUrlLink.href = data.data.short_url;
                    shortUrlLink.textContent = data.data.short_url;
                    resultDiv.classList.remove('hidden');
                } else {
                    errorMessage.textContent = data.message || 'An error occurred';
                    errorDiv.classList.remove('hidden');
                }
            } catch (err) {
                errorMessage.textContent = 'Network error. Please try again.';
                errorDiv.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>