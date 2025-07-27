<!DOCTYPE html>
<html>
<head>
    <title>Test File Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test File Upload</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
    <div id="result"></div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('result');
            
            try {
                const response = await fetch('/test-upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });
                
                const data = await response.json();
                resultDiv.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            } catch (error) {
                resultDiv.innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
            }
        });
    </script>
</body>
</html> 