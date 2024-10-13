<div class="tab-pane fade" id="v-pills-auth" role="tabpanel" aria-labelledby="v-pills-auth-tab">
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
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ...",
        "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2l...",
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
            <li><code>avatar_path</code> (file): Ảnh đại diện người dùng.</li>
            <li><code>password</code> (string, bắt buộc): Mật khẩu.</li>
            <li><code>password_confirmation</code> (string, bắt buộc): Xác nhận mật khẩu.</li>
        </ul>
        <h4>Body:</h4>
        <pre><code>
{
        "name": "Unicode Academy",
        "email": "unicode@gmail.com",
        "avatar_path": {file_avatar},
        "password": "unicode",
        "password_confirmation": "unicode"
}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>201 Created:</strong></p>
        <pre><code>
{
        "status": "success",
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOi...",
        "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX...",
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
        "status": "success",
        "data": {
                "id": 1,
                "name": "Unicode Academy",
                "email": "unicodeacademy@gmail.com",
                "avatar_path": {avatar_path}
        }
}
        </code>
    </div>

    <div class="mt-4">
        <h3>4. Cập nhật thông tin profile</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>name</code> (string): Tên.</li>
            <li><code>email</code> (string): Email.</li>
            <li><code>password</code> (string): Mật khẩu.</li>
            <li><code>avatar_path</code> (file): Ảnh đại diện người dùng.</li>
            <li><code>_method</code> (PUT/PATCH, bắt buộc): phương thức thực hiện.</li>
        </ul>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Body:</h4>
        <pre><code>
{
    "name": "Unicode Academy Update",
    "email": "unicodeacademyupdate@gmail.com",
    "password": "unicode",
    "avatar_path": {file_avatar},
    "_method": PUT/PATCH
}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "User updated successfully!"
}
        </code>
    </div>

    <div class="mt-4">
        <h3>5. Refresh Token</h3>
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
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwO...",
        "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjox...",
        "token_type": "bearer"
}
        </code>
    </div>

    <div class="mt-4">
        <h3>6. Đăng xuất</h3>
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
