<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful | AWN Venture Ready Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .btn-primary { background-color: #b81d8f; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #9e1879; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 text-center">
        <div class="mb-6">
            <svg class="mx-auto mb-4 w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Registration Successful!</h1>
            <p class="text-gray-600">Your account has been created and is pending admin approval.<br>
                You will receive an email once your account is activated.</p>
        </div>
        <a href="/" class="btn-primary inline-block px-6 py-3 rounded-lg text-white font-semibold">Return to Homepage</a>
        <a href="{{ route('login') }}" class="ml-4 text-[#b81d8f] font-medium hover:underline">Login</a>
    </div>
</body>
</html> 