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
                    aria-controls="login" aria-selected="true">Auth</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                    aria-controls="register" aria-selected="false">Post</a>
            </li>
        </ul>

        <!-- Nội dung của từng tab -->
        <div class="tab-content mt-4" id="myTabContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <div class="mt-4">
                    <h3>1. Đăng nhập</h3>
                    <p><strong>Phương thức:</strong> <code>POST</code></p>
                    <p><strong>Endpoint:</strong> <code>/auth/login</code></p>
                    <p><strong>Mô tả:</strong> Đăng nhập với email và password.</p>
                    <p><strong>Tham số:</strong></p>
                    <ul>
                        <li><code>email</code> (string, bắt buộc): Email.</li>
                        <li><code>password</code> (string, bắt buộc): Mật khẩu.</li>
                    </ul>
                    <h4>Body:</h4>
                    <pre><code>
        {
            "email": "unicode@gmail.com",
            "password": "unicode"
        }
                    </code></pre>
                    <h4>Response:</h4>
                    <p><strong>200 OK:</strong></p>
                    <pre><code>
        {
            "status": "success",
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vM
                            TI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjc5NzE2OTIsImV4cCI6MTcyNzk3NTI5MiwibmJmIjo
                            xNzI3OTcxNjkyLCJqdGkiOiJ0NElsSU1NcHo0TmZJV1ZFIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlm
                            NjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.lJRTihN19-fvP9ZfM7RS8SLgeyU-uOx0xjmei9kzeUc",
            "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxL
                            CJyYW5kb20iOiIyNjI3ODU3MTExNzI3OTcxNjkzIiwiZXhwIjoxNzI3OTkxODUzfQ.b4q7LEEYIITykBUCRVDqAmkGOPz5xp
                            BmPY6qPw4C64Y",
            "token_type": "bearer"
        }
                    </code></pre>
                </div>

                <div class="mt-4">
                    <h3>2. Đăng ký</h3>
                    <p><strong>Phương thức:</strong> <code>POST</code></p>
                    <p><strong>Endpoint:</strong> <code>/auth/register</code></p>
                    <p><strong>Mô tả:</strong> Đăng ký tài khoản.</p>
                    <p><strong>Tham số:</strong></p>
                    <ul>
                        <li><code>name</code> (string, bắt buộc): Tên.</li>
                        <li><code>email</code> (string, bắt buộc): Email.</li>
                        <li><code>password</code> (string, bắt buộc): Mật khẩu.</li>
                        <li><code>password_confirmation</code> (string, bắt buộc): Xác nhận mật khẩu.</li>
                    </ul>
                    <h4>Body:</h4>
                    <pre><code>
        {
            "name": "Unicode Academy",
            "email": "unicode@gmail.com",
            "password": "unicode",
            "password_confirmation": "unicode"
        }
                    </code></pre>
                    <h4>Response:</h4>
                    <p><strong>201 Created:</strong></p>
                    <pre><code>
        {
            "status": "success",
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vM
                            TI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjc5NzE2OTIsImV4cCI6MTcyNzk3NTI5MiwibmJmIjo
                            xNzI3OTcxNjkyLCJqdGkiOiJ0NElsSU1NcHo0TmZJV1ZFIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlm
                            NjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.lJRTihN19-fvP9ZfM7RS8SLgeyU-uOx0xjmei9kzeUc",
            "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxL
                            CJyYW5kb20iOiIyNjI3ODU3MTExNzI3OTcxNjkzIiwiZXhwIjoxNzI3OTkxODUzfQ.b4q7LEEYIITykBUCRVDqAmkGOPz5xp
                            BmPY6qPw4C64Y",
            "token_type": "bearer"
        }
                    </code></pre>
                </div>

                <div class="mt-4">
                    <h3>3. Lấy thông tin profile</h3>
                    <p><strong>Phương thức:</strong> <code>GET</code></p>
                    <p><strong>Endpoint:</strong> <code>/auth/profile</code></p>
                    <p><strong>Mô tả:</strong> Lấy thông tin profile của người dùng.</p>
                    <p><strong>Tham số:</strong> Không có</p>
                    <h4>Header:</h4>
                    <pre><code>
        Authorization: Bearer {your_token}
                    </code></pre>
                    <h4>Response:</h4>
                    <p><strong>200 OK:</strong></p>
                    <pre><code>
        {
            "id": 1,
            "name": "Unicode Academy",
            "email": "unicode@gmail.com",
            "email_verified_at": null,
            "created_at": "2024-10-01T14:19:45.000000Z",
            "updated_at": "2024-10-01T14:19:45.000000Z"
        }
                    </code>
                </div>
        
                <div class="mt-4">
                    <h3>4. Refresh Token</h3>
                    <p><strong>Phương thức:</strong> <code>POST</code></p>
                    <p><strong>Endpoint:</strong> <code>/auth/refresh</code></p>
                    <p><strong>Mô tả:</strong> Cấp lại Access Token và Refresh Token mới.</p>
                    <p><strong>Tham số:</strong></p>
                    <ul>
                        <li><code>refresh_token</code> (string, bắt buộc): Refresh Token.</li>
                    </ul>
                    <h4>Body:</h4>
                    <pre><code>
        {
            "refresh_token": {your_token},
        }
                    </code></pre>
                    <h4>Header:</h4>
                    <pre><code>
        Authorization: Bearer {your_token}
                    </code></pre>
                    <h4>Response:</h4>
                    <p><strong>200 OK:</strong></p>
                    <pre><code>
        {
            "status": "success",
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vM
                            TI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjc5NzE2OTIsImV4cCI6MTcyNzk3NTI5MiwibmJmIjo
                            xNzI3OTcxNjkyLCJqdGkiOiJ0NElsSU1NcHo0TmZJV1ZFIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlm
                            NjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.lJRTihN19-fvP9ZfM7RS8SLgeyU-uOx0xjmei9kzeUc",
            "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxL
                            CJyYW5kb20iOiIyNjI3ODU3MTExNzI3OTcxNjkzIiwiZXhwIjoxNzI3OTkxODUzfQ.b4q7LEEYIITykBUCRVDqAmkGOPz5xp
                            BmPY6qPw4C64Y",
            "token_type": "bearer"
        }
                    </code>
                </div>
        
                <div class="mt-4">
                    <h3>5. Đăng xuất</h3>
                    <p><strong>Phương thức:</strong> <code>POST</code></p>
                    <p><strong>Endpoint:</strong> <code>/auth/logout</code></p>
                    <p><strong>Mô tả:</strong> Đăng xuất.</p>
                    <p><strong>Tham số:</strong> Không có</p>
                    <h4>Header:</h4>
                    <pre><code>
        Authorization: Bearer {your_token}
                    </code></pre>
                    <h4>Response:</h4>
                    <p><strong>200 OK:</strong></p>
                    <pre><code>
        {
            "status": "success",
            "message": "Successfully logged out"
        }
                    </code>
                </div>
            </div>

            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
             132
                </div>

               
            </div>
            <h2 class="mt-5">Kết luận</h2>
            <p>Tài liệu này cung cấp cái nhìn tổng quan về các endpoint của API. Vui lòng liên hệ với bộ phận hỗ trợ nếu
                bạn
                có bất kỳ câu hỏi nào.</p>
        </div>

        <!-- Thêm Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
