<div class="tab-pane fade" id="v-pills-user" role="tabpanel" aria-labelledby="v-pills-user-tab">
    <div class="mt-4">
        <h3>1. Lấy danh sách người dùng</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/users</code></p>
        <p><strong>Mô tả:</strong> Lấy danh sách tất cả người dùng.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>page</code> (string, integer): Lấy dữ liệu từng trang, mặc định là trang 1.</li>
            <li><code>limit</code> (string, integer): Users ở mỗi trang, mặc định là 10.</li>
            <li><code>keyword</code> (string): Từ khóa tìm kiếm.</li>
        </ul>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Users fetched successfully.",
    "data": {
        "current_page": 1,
        "last_page": {last_page},
        "per_page": {user_per_page},
        "total": {total_users},
        "data": [
            {
                "id": 1,
                "name": "Unicode Academy",
                "email": "unicodeacademy@gmail.com",
                "avatar_path": null
            },
            ...
        ]
    }
}
        </code>
    </div>

    <div class="mt-4">
        <h3>2. Lấy chi tiết người dùng</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/users/{id}</code></p>
        <p><strong>Mô tả:</strong> Lấy thông tin chi tiết người dùng.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>id</code> (string): ID người dùng.</li>
        </ul>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "User fetched successfully.",
    "data": {
        "id": 1,
        "name": "Unicode Academy",
        "email": "unicodeacademy@gmail.com",
        "avatar_path": null
    },
}
        </code>
    </div>

    <div class="mt-4">
        <h3>3. Cập nhật thông tin người dùng (???)</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/users/{id}</code></p>
        <p><strong>Mô tả:</strong> Cập nhật thông tin người dùng.</p>
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
    "message": "User updated successfully!",
    "data": {
        "id": 1,
        "name": "Unicode Academy Update",
        "email": "unicodeacademyupdate@gmail.com",
        "avatar_path": {avatar_path}
    }
}
        </code>
    </div>

    <div class="mt-4">
        <h3>4. Xóa người dùng {???}</h3>
        <p><strong>Phương thức:</strong> <code>DELETE</code></p>
        <p><strong>Endpoint:</strong> <code>/users/{id}</code></p>
        <p><strong>Mô tả:</strong> Xóa người dùng.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>id</code> (string): ID người dùng.</li>
        </ul>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "User deleted successfully!",
    "data": null
}
        </code>
    </div>

    <div class="mt-4">
        <h3>5. Lấy danh sách followers</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/follows</code></p>
        <p><strong>Mô tả:</strong> Lấy danh sách những người mình đã follow.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Follow fetched successfully.",
    "data": [
        {
            "id": 2,
            "name": "Unicode Academy 2",
            "email": "unicodeacademy2@gmail.com",
            "avatar_path": null
        }
    ]
}
        </code>
    </div>
    <div class="mt-4">
        <h3>6. Follow hoặc hủy follow</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/follows/{id}</code></p>
        <p><strong>Mô tả:</strong> Follow hoặc hủy follow user, nếu chưa follow thì sẽ follow và ngược lại.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>id</code> (string): ID user.</li>
        </ul>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>201 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Unfollowed successfully.",
    "data": null
}
        </code>
    </div>
</div>
