<div class="tab-pane fade" id="v-pills-comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
    <div class="mt-4">
        <h3>1. Lấy chi tiết bình luận</h3>
        <p><strong>Phương thức:</strong> <code>GET</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{comment_id}</code></p>
        <p><strong>Mô tả:</strong> Lấy chi tiết bình luận.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>comment_id</code> (string, integer): ID Comment.</li>
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
    "message": "Comment fetched successfully.",
    "data": {
        "id": 18,
        "content": "hihi",
        "favorites_count": 1
    }
}
        </code>
    </div>

    <div class="mt-4">
        <h3>2. Tạo bình luận</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/{post_id}/comment</code></p>
        <p><strong>Mô tả:</strong> Tạo bình luận.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>post_id</code> (string, integer): ID Bài viết.</li>
        </ul>
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
    "images": [{file_image}],
    "videos": [{file_video}]
}
        </code></pre>
        <h4>Response:</h4>
        <p><strong>201 OK:</strong></p>
        <pre><code>
{
    "status": "success",
    "message": "Comment published successfully.",
    "data": null
}
        </code>
    </div>

    <div class="mt-4">
        <h3>3. Cập nhật bình luận</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{comment_id}</code></p>
        <p><strong>Mô tả:</strong> Cập nhật comment.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>comment_id</code> (string, integer, bắt buộc): ID Comment.</li>
            <li><code>_method</code> (PUT/PATCH, bắt buộc): Phương thức thực hiện.</li>
            <li><code>content</code> (string): Nội dung comment.</li>
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
    "message": "Comment updated successfully.",
    "data": null
}
</code>
    </div>

    <div class="mt-4">
        <h3>4. Xóa bình luận</h3>
        <p><strong>Phương thức:</strong> <code>DELETE</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{comment_id}</code></p>
        <p><strong>Mô tả:</strong> Xóa bình luận.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>comment_id</code> (string, integer): ID Comment.</li>
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
    "message": "Comment deleted successfully.",
    "data": null
}
        </code>
    </div>

    <div class="mt-4">
        <h3>5. Thích hoặc bỏ thích bình luận</h3>
        <p><strong>Phương thức:</strong> <code>POST</code></p>
        <p><strong>Endpoint:</strong> <code>/posts/comment/{comment_id}/like</code></p>
        <p><strong>Mô tả:</strong> Thích hoặc bỏ thích bình luận, chưa thích sẽ thêm vào danh sách yêu thích và ngược
            lại.</p>
        <p><strong>Tham số:</strong></p>
        <ul>
            <li><code>comment_id</code> (string, integer): ID Comment.</li>
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
    "message": "Comment liked successfully.",
    "data": null
}
        </code>
    </div>


</div>
