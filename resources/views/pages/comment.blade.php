<div class="tab-pane fade" id="v-pills-comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
    <div class="mt-4">
        <h3>1. Lấy chi tiết bình luận</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{id}</code></p>
        <p><strong>Mô tả:</strong> Lấy chi tiết bình luận.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
    </div>

    <div class="mt-4">
        <h3>2. Tạo bình luận</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{id}/comment</code></p>
        <p><strong>Mô tả:</strong> Tạo bình luận.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>parent_id</code> (number): Bình luận cha (Mặc định là 0).</li>
            <li><code>content</code> (string, bắt buộc): Refresh Token.</li>
            <li><code>images</code> (array): Mảng chứa các file ảnh.</li>
            <li><code>videos</code> (array): Mảng chứa các file video.</li>
        </ul>
        <h4>Body:</h4>
        <pre><code>
{
    "parent_id": 0,
    "content": Unicode Academy,
    "images": [
        "https://www.gstatic.com/webp/gallery/1.jpg",
        "https://www.gstatic.com/webp/gallery/2.jpg"
    ],
    "videos": [
        "https://www.youtube.com/watch?v=H0wUqfZJnD0",
        "https://www.youtube.com/watch?v=8Yt3j5KtEJk"
    ]
}
        </code></pre>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
    </div>

    <div class="mt-4">
        <h3>3. Cập nhật bình luận</h3>
        {{-- <p><strong>Phương thức:</strong> <code>PUT</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{id}</code></p>
        <p><strong>Mô tả:</strong> Cập nhật bài viết.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre> --}}
        <pre><code>
            Đang cập nhật ...
                    </code></pre>
    </div>

    <div class="mt-4">
        <h3>4. Xóa bình luận</h3>
        <p><strong>Phương thức:</strong> <code>DELETE</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{id}</code></p>
        <p><strong>Mô tả:</strong> Xóa bình luận.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
    </div>

    <div class="mt-4">
        <h3>5. Thích hoặc bỏ thích bình luận</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{id}/like</code></p>
        <p><strong>Mô tả:</strong> Thích hoặc bỏ thích bình luận.</p>
        <h4>Header:</h4>
        <pre><code>
Authorization: Bearer {your_token}
        </code></pre>
    </div>


</div>
