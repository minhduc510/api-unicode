<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use App\Helpers\FileHelper;
use App\Models\PostFavorite;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\CommentFavorite;
use App\Helpers\TransactionHelper;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    protected $postModel;
    protected $commentModel;
    protected $postFavoriteModel;
    protected $commentFavoriteModel;

    public function __construct(Post $post, PostFavorite $postFavorite, Comment $comment, CommentFavorite $commentFavorite)
    {
        $this->postModel = $post;
        $this->commentModel = $comment;
        $this->postFavoriteModel = $postFavorite;
        $this->commentFavoriteModel = $commentFavorite;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postModel->with('user', 'images', 'videos')->get();
        $dataRes = [];
        foreach ($posts as $post) {
            $images = [];
            if (count($post->images) > 0) {
                foreach ($post->images as $image) {
                    $images[] = [
                        'id' => $image->id,
                        'name' => $image->name,
                        'path' => env('APP_URL') . $image->path,
                        'size' => $image->size
                    ];
                }
            }

            $videos = [];
            if (count($post->videos) > 0) {
                foreach ($post->videos as $video) {
                    $videos[] = [
                        'id' => $video->id,
                        'name' => $video->name,
                        'path' => env('APP_URL') . $video->path,
                        'size' => $video->size,
                    ];
                }
            }

            $dataRes[] = [
                'id' => $post->id,
                'content' => $post->content,
                'total_favorites' => $post->favorites()->count(),
                'total_comments' => $post->comments()->count(),
                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                    'avatar_path' => env('APP_URL') . $post->user->avatar_path,
                ],
                'images' => $images,
                'videos' => $videos
            ];
        }

        return ResponseHelper::success('Retrieve all posts successfully!', $dataRes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        TransactionHelper::handle(function () use ($request) {

            $user = json_decode($request->header('user'));

            $data = [
                'user_id' => $user->id,
                'content' => $request->content
            ];

            $post = $this->postModel->create($data);

            if ($request->has('images')) {
                $dataImages = [];
                foreach ($request->images as $image) {
                    $fileInfo = FileHelper::uploadFile($image, 'posts/images');
                    if (!is_null($fileInfo)) {
                        $dataImages[] = [
                            'name' => $fileInfo['filename'],
                            'path' => $fileInfo['path'],
                            'size' => $fileInfo['size']
                        ];
                    }
                }

                $post->images()->createMany($dataImages);
            }

            if ($request->has('videos')) {
                $dataVideos = [];
                foreach ($request->videos as $video) {
                    $fileInfo = FileHelper::uploadFile($video, 'posts/videos');
                    if (!is_null($fileInfo)) {
                        $dataVideos[] = [
                            'name' => $fileInfo['filename'],
                            'path' => $fileInfo['path'],
                            'size' => $fileInfo['size'],
                            'durations' => $fileInfo['duration']
                        ];
                    }
                }

                $post->videos()->createMany($dataVideos);

                return $post;
            }
        });

        return ResponseHelper::success('Post published successfully.', null, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postModel->with('user', 'images', 'videos')->find($id);
        if (is_null($post)) {
            return ResponseHelper::error('Post not found!', null, 404);
        }
        $post->total_favorites = $post->favorites()->count();
        $post->total_comments = $post->comments()->count();
        return ResponseHelper::success('Retrieve post successfully!', $post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        return TransactionHelper::handle(function () use ($request, $id) {
            $post = $this->postModel->find($id);
            if (is_null($post)) {
                return ResponseHelper::error('Post not found!', null, 404);
            }

            if ($request->has('content')) {
                $post->update([
                    'content' => $request->content
                ]);
            }

            if ($request->has('images')) {
                foreach ($post->images as $image) {
                    if (is_string($image)) {
                        dd(123);
                    }
                }
                dd(465);
                if ($post->images()->count() > 0) {
                    foreach ($post->images as $image) {
                        FileHelper::deleteFile($image->path);
                    }
                    $post->images()->delete();
                }

                if (!is_null($request->images) && count($request->images) > 0) {
                    $dataImages = [];
                    foreach ($request->images as $image) {
                        $fileInfo = FileHelper::uploadFile($image, 'posts/images');
                        if (!is_null($fileInfo)) {
                            $dataImages[] = [
                                'name' => $fileInfo['filename'],
                                'path' => $fileInfo['path'],
                                'size' => $fileInfo['size']
                            ];
                        }
                    }

                    $post->images()->createMany($dataImages);
                }
            }

            if ($request->has('videos')) {
                if ($post->videos()->count() > 0) {
                    foreach ($post->videos as $video) {
                        FileHelper::deleteFile($video->path);
                    }
                    $post->videos()->delete();
                }
                if (!is_null($request->videos) && count($request->videos) > 0) {
                    $dataVideos = [];
                    foreach ($request->videos as $video) {
                        $fileInfo = FileHelper::uploadFile($video, 'posts/videos');
                        if (!is_null($fileInfo)) {
                            $dataVideos[] = [
                                'name' => $fileInfo['filename'],
                                'path' => $fileInfo['path'],
                                'size' => $fileInfo['size'],
                                'durations' => $fileInfo['duration'],
                                'post_id' => $post->id
                            ];
                        }
                    }

                    $post->videos()->createMany($dataVideos);
                }
            }
            return ResponseHelper::success('Post updated successfully.', $post, 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = $this->postModel->find($id);
        if (is_null($post)) {
            return ResponseHelper::error('Post not found!', null, 404);
        }
        if ($post->images()->count() > 0) {
            foreach ($post->images as $image) {
                FileHelper::deleteFile($image->path);
            }
            $post->images()->delete();
        }
        if ($post->videos()->count() > 0) {
            foreach ($post->videos as $video) {
                FileHelper::deleteFile($video->path);
            }
            $post->videos()->delete();
        }
        $post->delete();
        return ResponseHelper::success('Post deleted successfully.', null, 200);
    }

    public function like(string $id, Request $request)
    {
        $user = json_decode($request->header('user'));
        $post = $this->postModel->find($id);
        if (is_null($post)) {
            return ResponseHelper::error('Post not found!', null, 404);
        }
        $postFavorite = $this->postFavoriteModel->where('user_id', $user->id)->where('post_id', $id)->first();
        if (!is_null($postFavorite)) {
            $postFavorite->delete();
            $message = 'Post unliked successfully.';
            return ResponseHelper::success($message, null, 200);
        } else {
            $this->postFavoriteModel->create([
                'user_id' => $user->id,
                'post_id' => $id
            ]);
            $message = 'Post liked successfully.';
            return ResponseHelper::success($message, null, 200);
        }
    }

    public function getComment(string $id)
    {
        $comment = $this->commentModel->with('children')->find($id);
        if (is_null($comment)) {
            return ResponseHelper::error('Comment not found!', null, 404);
        }
        return ResponseHelper::success('Comment fetched successfully.', $comment, 200);
    }

    public function createComment(string $id, PostRequest $request)
    {
        return TransactionHelper::handle(function () use ($request, $id) {

            $post = $this->postModel->find($id);

            if (is_null($post)) {
                return ResponseHelper::error('Post not found!', null, 404);
            }

            if (isset($request->parent_id)) {
                $parent = $this->commentModel->find($request->parent_id);
                if (is_null($parent)) {
                    return ResponseHelper::error('Parent comment not found!', null, 404);
                }
            }

            $user = json_decode($request->header('user'));

            $data = [
                'user_id' => $user->id,
                'post_id' => $id,
                'parent_id' => $request->parent_id ?? 0,
                'content' => $request->content
            ];

            $comment = $this->commentModel->create($data);

            if ($request->has('images')) {
                $dataImages = [];
                foreach ($request->images as $image) {
                    $fileInfo = FileHelper::uploadFile($image, 'comments/images');
                    if (!is_null($fileInfo)) {
                        $dataImages[] = [
                            'name' => $fileInfo['filename'],
                            'path' => $fileInfo['path'],
                            'size' => $fileInfo['size']
                        ];
                    }
                }

                $comment->images()->createMany($dataImages);
            }

            if ($request->has('videos')) {
                $dataVideos = [];
                foreach ($request->videos as $video) {
                    $fileInfo = FileHelper::uploadFile($video, 'comments/videos');
                    if (!is_null($fileInfo)) {
                        $dataVideos[] = [
                            'name' => $fileInfo['filename'],
                            'path' => $fileInfo['path'],
                            'size' => $fileInfo['size'],
                            'durations' => $fileInfo['duration'],
                        ];
                    }
                }

                $comment->videos()->createMany($dataVideos);
            }
            return ResponseHelper::success('Comment published successfully.', null, 200);
        });
    }

    public function deleteComment(string $id)
    {
        $comment = $this->commentModel->find($id);
        if (is_null($comment)) {
            return ResponseHelper::error('Comment not found!', null, 404);
        }
        $comment->delete();
        return ResponseHelper::success('Comment deleted successfully.', null, 200);
    }

    public function likeComment(string $id, Request $request)
    {
        $user = json_decode($request->header('user'));
        $comment = $this->commentModel->find($id);
        if (is_null($comment)) {
            return ResponseHelper::error('Comment not found!', null, 404);
        }
        $commentFavorite = $this->commentFavoriteModel->where('user_id', $user->id)->where('comment_id', $id)->first();
        if (!is_null($commentFavorite)) {
            $commentFavorite->delete();
            $message = 'Comment unliked successfully.';
            return ResponseHelper::success($message, null, 200);
        } else {
            $this->commentFavoriteModel->create([
                'user_id' => $user->id,
                'comment_id' => $id
            ]);
            $message = 'Comment liked successfully.';
            return ResponseHelper::success($message, null, 200);
        }
    }
}
