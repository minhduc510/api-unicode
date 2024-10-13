<div class="tab-pane fade" id="v-pills-post" role="tabpanel" aria-labelledby="v-pills-post-tab">
    <div class="mt-4">
        <h3>1. Lấy danh sách bài viết</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/posts</code></p>
        <p><strong>Mô tả:</strong> Lấy danh sách tất cả bài viết.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>page</code> (string, integer): Lấy dữ liệu từng trang, mặc định là trang 1.</li>
            <li><code>limit</code> (string, integer): Posts ở mỗi trang, mặc định là 10.</li>
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
    "message": "Retrieve all posts successfully!",
    "data": {
        "current_page": 1,
        "last_page": {last_page},
        "per_page": {post_per_page},
        "total": {total_posts},
        "data": [
            {
                "id": 1,
                "content": "Post 1",
                "total_favorites": 0,
                "total_comments": 0,
            },
            ...
        ]
    }
}
</code>
    </div>

    <div class="mt-4">
        <h3>2. Lấy danh sách bài viết của 1 user</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/user/{user_id}</code></p>
        <p><strong>Mô tả:</strong> Lấy danh sách tất cả bài viết của 1 user cụ thể.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>user_id</code> (string, integer): ID user.</li>
            <li><code>page</code> (string, integer): Lấy dữ liệu từng trang, mặc định là trang 1.</li>
            <li><code>limit</code> (string, integer): Posts ở mỗi trang, mặc định là 10.</li>
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
    "message": "Retrieve all posts successfully!",
    "data": {
        "current_page": 1,
        "last_page": {last_page},
        "per_page": {post_per_page},
        "total": {total_posts},
        "data": [
            {
                "id": 1,
                "content": "Post 1",
                "total_favorites": 0,
                "total_comments": 0,
            },
            ...
        ]
    }
}
</code>
    </div>

    <div class="mt-4">
        <h3>3. Lấy chi tiết bài viết</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{post_id}</code></p>
        <p><strong>Mô tả:</strong> Lấy chi tiết bài viết.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>post_id</code> (string, integer): ID bài viết.</li>
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
    "message": "Retrieve all posts successfully!",
    "data": {
        "id": 1,
        "content": "Post 1",
        "total_favorites": 0,
        "total_comments": 0,
        "user": null
    }
}
</code>
    </div>

    <div class="mt-4">
        <h3>4. Tạo bài viết</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts</code></p>
        <p><strong>Mô tả:</strong> Tạo bài viết.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>content</code> (string, bắt buộc): Refresh Token.</li>
            <li><code>images</code> (array): Mảng chứa các file ảnh.</li>
            <li><code>videos</code> (array): Mảng chứa các file video.</li>
        </ul>
        <h4>Body:</h4>
        <pre><code>
{
    "content": Unicode Academy,
    "images": [{file_image}],
    "videos": [{file_video}]
}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Post published successfully!",
    "data": null
}
</code>
    </div>

    <div class="mt-4">
        <h3>5. Cập nhật bài viết</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{post_id}</code></p>
        <p><strong>Mô tả:</strong> Cập nhật bài viết.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>post_id</code> (string, integer, bắt buộc): ID bài viết.</li>
            <li><code>_method</code> (PUT/PATCH, bắt buộc): Phương thức thực hiện.</li>
            <li><code>content</code> (string): Nội dung bài viết.</li>
            <li><code>images</code> (array): Mảng chứa các file ảnh.</li>
            <li><code>videos</code> (array): Mảng chứa các file video.</li>
            <li><code>keep_images</code> (string): Mảng chứa các id ảnh cần giữ lại, không có sẽ xóa.</li>
            <li><code>keep_videos</code> (string): Mảng chứa các id video cần giữ lại, không có sẽ xóa.</li>
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
    "message": "Post updated successfully.",
    "data": null
}
</code>
    </div>

    <div class="mt-4">
        <h3>6. Xóa bài viết</h3>
        <p><strong>Phương thức:</strong> <code>DELETE</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{post_id}</code></p>
        <p><strong>Mô tả:</strong> Xóa bài viết.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>post_id</code> (string, integer): ID bài viết muốn xóa.</li>
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
    "message": "Post deleted successfully.",
    "data": null
}
</code>
    </div>

    <div class="mt-4">
        <h3>7. Lấy danh sách bài viết đã thích</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/like/list</code></p>
        <p><strong>Mô tả:</strong> Lấy danh sách những bài viết đã thêm vào yêu thích của mình.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Retrieve post successfully!",
    "data": [
        "current_page": 1,
        "last_page": {last_page},
        "per_page": {post_per_page},
        "total": {total_posts},
        "data": [
            {
                "id": 1,
                "content": "Post 1",
                "favorites_count": 0,
                "comments_count": 0,
            },
            ...
        ]
    ]
}
        </code>
    </div>

    <div class="mt-4">
        <h3>8. Thích hoặc bỏ thích bài viết</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{post_id}/like</code></p>
        <p><strong>Mô tả:</strong> Thích hoặc bỏ thích bài viết, nếu bài viết chưa thích thì sẽ thêm vào yêu thích và ngược lại.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>post_id</code> (string, integer): ID bài viết.</li>
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
    "message": "Post liked successfully.",
    "data": null
}
</code>
    </div>

    <div class="mt-4">
        <h3>9. Lấy danh sách bài viết đã lưu</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/like/list</code></p>
        <p><strong>Mô tả:</strong> Lấy danh sách những bài viết đã lưu của mình.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>200 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Retrieve post successfully!",
    "data": [
        "current_page": 1,
        "last_page": {last_page},
        "per_page": {post_per_page},
        "total": {total_posts},
        "data": [
            {
                "id": 1,
                "content": "Post 1",
                "favorites_count": 0,
                "comments_count": 0,
            },
            ...
        ]
    ]
}
        </code>
    </div>

    <div class="mt-4">
        <h3>8. Lưu hoặc bỏ lưu bài viết</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{post_id}/saved</code></p>
        <p><strong>Mô tả:</strong> Thích hoặc bỏ thích bài viết, nếu bài viết chưa thích thì sẽ thêm vào yêu thích và ngược lại.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>post_id</code> (string, integer): ID bài viết.</li>
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
    "message": "Post saved successfully.",
    "data": null
}
</code>
    </div>


</div>
