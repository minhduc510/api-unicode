<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài liệu API</title>
    <!-- Thêm Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Tài liệu API</h1>
        <p class="text-center">Tài liệu này mô tả các endpoint của API cho ứng dụng.</p>

        <h2 class="mt-5">Base URL</h2>
        <pre><code>https://reactjs-api-unicode.online/api</code></pre>

        <h2 class="mt-5">Endpoint</h2>

        <!-- Tabs điều hướng -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                    aria-controls="login" aria-selected="true">Đăng nhập</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                    aria-controls="register" aria-selected="false">Đăng ký</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Lấy thông tin profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="refresh-tab" data-toggle="tab" href="#refresh" role="tab"
                    aria-controls="refresh" aria-selected="false">Refresh Token</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="logout-tab" data-toggle="tab" href="#logout" role="tab"
                    aria-controls="logout" aria-selected="false">Đăng xuất</a>
            </li>
        </ul>

        <!-- Nội dung của từng tab -->
        <div class="tab-content mt-4" id="myTabContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <h3>1. Đăng nhập</h3>
                <p><strong>Phương thức:</strong> <code>POST</code></p>
                <p><strong>Endpoint:</strong> <code>/auth/login</code></p>
                <p><strong>Mô tả:</strong> Đăng nhập với email và password.</p>
                <ul>
                    <li><code>email</code> (string, bắt buộc): Email.</li>
                    <li><code>password</code> (string, bắt buộc): Mật khẩu.</li>
                </ul>
                <h4>Body:</h4>
                <pre><code>{
    "email": "unicode@gmail.com",
    "password": "unicode"
}</code></pre>
                <h4>Response:</h4>
                <pre><code>{
    "status": "success",
    "access_token": "eyJ0eXAiOi...",
    "refresh_token": "eyJ0eXAiOi...",
    "token_type": "bearer"
}</code></pre>
            </div>

            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <h3>2. Đăng ký</h3>
                <p><strong>Phương thức:</strong> <code>POST</code></p>
                <p><strong>Endpoint:</strong> <code>/auth/register</code></p>
                <ul>
                    <li><code>name</code> (string, bắt buộc): Tên.</li>
                    <li><code>email</code> (string, bắt buộc): Email.</li>
                    <li><code>password</code> (string, bắt buộc): Mật khẩu.</li>
                    <li><code>password_confirmation</code> (string, bắt buộc): Xác nhận mật khẩu.</li>
                </ul>
                <h4>Body:</h4>
                <pre><code>{
    "name": "Unicode Academy",
    "email": "unicode@gmail.com",
    "password": "unicode",
    "password_confirmation": "unicode"
}</code></pre>
                <h4>Response:</h4>
                <pre><code>{
    "status": "success",
    "access_token": "eyJ0eXAiOi...",
    "refresh_token": "eyJ0eXAiOi...",
    "token_type": "bearer"
}</code></pre>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h3>3. Lấy thông tin profile</h3>
                <p><strong>Phương thức:</strong> <code>GET</code></p>
                <p><strong>Endpoint:</strong> <code>/auth/profile</code></p>
                <pre><code>Authorization: Bearer {your_token}</code></pre>
                <h4>Response:</h4>
                <pre><code>{
    "id": 1,
    "name": "Unicode Academy",
    "email": "unicode@gmail.com",
    "created_at": "2024-10-01T14:19:45.000000Z"
}</code></pre>
            </div>

            <div class="tab-pane fade" id="refresh" role="tabpanel" aria-labelledby="refresh-tab">
                <h3>4. Refresh Token</h3>
                <p><strong>Phương thức:</strong> <code>POST</code></p>
                <p><strong>Endpoint:</strong> <code>/auth/refresh</code></p>
                <h4>Body:</h4>
                <pre><code>{
    "refresh_token": {your_token}
}</code></pre>
                <h4>Response:</h4>
                <pre><code>{
    "status": "success",
    "access_token": "eyJ0eXAiOi...",
    "refresh_token": "eyJ0eXAiOi...",
    "token_type": "bearer"
}</code></pre>
            </div>

            <div class="tab-pane fade" id="logout" role="tabpanel" aria-labelledby="logout-tab">
                <h3>5. Đăng xuất</h3>
                <p><strong>Phương thức:</strong> <code>POST</code></p>
                <pre><code>Authorization: Bearer {your_token}</code></pre>
                <h4>Response:</h4>
                <pre><code>{
    "status": "success",
    "message": "Successfully logged out"
}</code></pre>
            </div>
        </div>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
