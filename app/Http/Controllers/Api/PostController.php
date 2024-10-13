<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\PostImage;
use App\Models\PostVideo;
use App\Models\SavedPost;
use App\Helpers\FileHelper;
use App\Models\CommentImage;
use App\Models\CommentVideo;
use App\Models\PostFavorite;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\CommentFavorite;
use App\Helpers\TransactionHelper;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    const POST_PER_PAGE = 10;

    protected $postModel;
    protected $userModel;
    protected $savedPostModel;
    protected $commentModel;
    protected $postFavoriteModel;
    protected $commentFavoriteModel;
    protected $postImageModel;
    protected $postVideoModel;
    protected $commentImageModel;
    protected $commentVideoModel;

    public function __construct(
        Post $post,
        PostFavorite $postFavorite,
        Comment $comment,
        CommentFavorite $commentFavorite,
        SavedPost $savedPost,
        User $user,
        PostImage $postImage,
        PostVideo $postVideo,
        CommentImage $commentImage,
        CommentVideo $commentVideo,
    ) {
        $this->userModel = $user;
        $this->postVideoModel = $postVideo;
        $this->postModel = $post;
        $this->postImageModel = $postImage;
        $this->savedPostModel = $savedPost;
        $this->commentModel = $comment;
        $this->postFavoriteModel = $postFavorite;
        $this->commentFavoriteModel = $commentFavorite;
        $this->commentImageModel = $commentImage;
        $this->commentVideoModel = $commentVideo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = $this->postModel->with('user', 'images', 'videos');
        if ($request->has('keyword')) {
            $posts = $posts->where('content', 'like', '%' . $request->keyword . '%');
        }
        $posts = $posts->paginate($request->limit ? $request->limit : self::POST_PER_PAGE);
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
        $response = [
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'data' => $dataRes
        ];

        return ResponseHelper::success('Retrieve all posts successfully!', $response, 200);
    }

    public function getPostsByUser(Request $request, $id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return ResponseHelper::error('User not found!', null, 404);
        }
        $posts = $this->postModel->where('user_id', $id)->with('user', 'images', 'videos');
        if ($request->has('keyword')) {
            $posts = $posts->where('content', 'like', '%' . $request->keyword . '%');
        }
        $posts = $posts->paginate($request->limit ? $request->limit : self::POST_PER_PAGE);
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
        $response = [
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'data' => $dataRes
        ];

        return ResponseHelper::success('Retrieve all posts successfully!', $response, 200);
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
            }
        });

        return ResponseHelper::success('Post published successfully.', null, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postModel->select('id', 'content')->with('user:id,name,email,avatar_path', 'images:id,name,path,post_id', 'videos:id,name,path,post_id')->find($id);
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

            if ($request->has('keep_images') && count($request->keep_images) > 0) {
                $imagesPost = $this->postImageModel->where('post_id', $id)->whereNotIn('id', $request->keep_images)->get();
                foreach ($imagesPost as $image) {
                    FileHelper::deleteFile($image->path);
                }

                $this->postImageModel->where('post_id', $id)->whereNotIn('id', $request->keep_images)->delete();
            }

            if ($request->has('keep_videos') && count($request->keep_videos) > 0) {
                $videosPost = $this->postVideoModel->where('post_id', $id)->whereNotIn('id', $request->keep_videos)->get();
                foreach ($videosPost as $video) {
                    FileHelper::deleteFile($video->path);
                }

                $this->postVideoModel->where('post_id', $id)->whereNotIn('id', $request->keep_videos)->delete();
            }

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
            }

            return ResponseHelper::success('Post updated successfully.', null, 200);
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

    public function getListLike(Request $request)
    {
        $user = json_decode($request->header('user'));
        $dataPostId = $this->postFavoriteModel->where('user_id', $user->id)->get()->pluck('post_id');
        $data = $this->postModel->select('id', 'content');
        if ($request->has('keyword') && !is_null($request->keyword)) {
            $data = $data->where('content', 'like', '%' . $request->keyword . '%');
        }
        $data = $data->withCount('favorites')->withCount('comments')
            ->with([
                'images' => function ($query) {
                    $query->select('id', 'post_id', 'name', DB::raw("CONCAT('" . env('APP_URL') . "', path) as path"));
                },
                'videos' => function ($query) {
                    $query->select('id', 'post_id', 'name', DB::raw("CONCAT('" . env('APP_URL') . "', path) as path"));
                }
            ])->whereIn('id', $dataPostId)->paginate($request->limit ? $request->limit : self::POST_PER_PAGE);
        $response = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'data' => $data->items()
        ];
        return ResponseHelper::success('Retrieve post successfully!', $response, 200);
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

    public function getListSaved(Request $request)
    {
        $user = json_decode($request->header('user'));
        $dataPostId = $this->savedPostModel->where('user_id', $user->id)->get()->pluck('post_id');
        $data = $this->postModel->select('id', 'content');
        if ($request->has('keyword') && !is_null($request->keyword)) {
            $data = $data->where('content', 'like', '%' . $request->keyword . '%');
        }
        $data = $data->withCount('favorites')->withCount('comments')
            ->with([
                'images' => function ($query) {
                    $query->select('id', 'post_id', 'name', DB::raw("CONCAT('" . env('APP_URL') . "', path) as path"));
                },
                'videos' => function ($query) {
                    $query->select('id', 'post_id', 'name', DB::raw("CONCAT('" . env('APP_URL') . "', path) as path"));
                }
            ])->whereIn('id', $dataPostId)->paginate($request->limit ? $request->limit : self::POST_PER_PAGE);
        $response = [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'data' => $data->items()
        ];
        return ResponseHelper::success('Retrieve post successfully!', $response, 200);
    }

    public function saved(string $id, Request $request)
    {
        $user = json_decode($request->header('user'));
        $post = $this->postModel->find($id);
        if (is_null($post)) {
            return ResponseHelper::error('Post not found!', null, 404);
        }
        $postFavorite = $this->savedPostModel->where('user_id', $user->id)->where('post_id', $id)->first();
        if (!is_null($postFavorite)) {
            $postFavorite->delete();
            $message = 'Post unsaved successfully.';
            return ResponseHelper::success($message, null, 200);
        } else {
            $this->savedPostModel->create([
                'user_id' => $user->id,
                'post_id' => $id
            ]);
            $message = 'Post saved successfully.';
            return ResponseHelper::success($message, null, 200);
        }
    }

    public function getComment(string $id)
    {
        $comment =  $this->commentModel->select('id', 'content')->with('images', 'videos', 'recursiveChildren')->withCount('favorites')->find($id);
        if (is_null($comment)) {
            return ResponseHelper::error('Comment not found!', null, 404);
        }

        $data = $this->customDataResponse($comment);
        return ResponseHelper::success('Comment fetched successfully.', $data, 200);
    }

    public function customDataResponse($data)
    {
        $dataCustom = [
            'id' => $data->id,
            'content' => $data->content,
            'favorites_count' => $data->favorites_count,
            'images' => [],
            'videos' => [],
            'children' => []
        ];
        if (count($data->images) > 0) {
            foreach ($data->images as $image) {
                $dataCustom['images'][] = [
                    'id' => $image->id,
                    'name' => $image->name,
                    'path' => env('APP_URL') . $image->path
                ];
            }
        }
        if (count($data->videos) > 0) {
            foreach ($data->videos as $video) {
                $dataCustom['videos'][] = [
                    'id' => $video->id,
                    'name' => $video->name,
                    'path' => env('APP_URL') . $video->path
                ];
            }
        }
        if (count($data->recursiveChildren) > 0) {
            foreach ($data->recursiveChildren as $child) {
                $dataCustom['children'][] = $this->customDataResponse($child);
            }
        }
        return $dataCustom;
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

    public function updateComment(string $id, PostRequest $request)
    {
        return TransactionHelper::handle(function () use ($request, $id) {
            $comment = $this->commentModel->find($id);
            if (is_null($comment)) {
                return ResponseHelper::error('Comment not found!', null, 404);
            }

            if ($request->has('content')) {
                $comment->update([
                    'content' => $request->content
                ]);
            }

            if ($request->has('keep_images') && count($request->keep_images) > 0) {
                $imagesPost = $this->commentImageModel->where('comment_id', $id)->whereNotIn('id', $request->keep_images)->get();
                foreach ($imagesPost as $image) {
                    FileHelper::deleteFile($image->path);
                }

                $this->commentImageModel->where('comment_id', $id)->whereNotIn('id', $request->keep_images)->delete();
            }

            if ($request->has('keep_videos') && count($request->keep_videos) > 0) {
                $videosPost = $this->commentVideoModel->where('comment_id', $id)->whereNotIn('id', $request->keep_videos)->get();
                foreach ($videosPost as $video) {
                    FileHelper::deleteFile($video->path);
                }

                $this->commentVideoModel->where('comment_id', $id)->whereNotIn('id', $request->keep_videos)->delete();
            }

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
                            'durations' => $fileInfo['duration']
                        ];
                    }
                }

                $comment->videos()->createMany($dataVideos);
            }

            return ResponseHelper::success('Comment updated successfully.', null, 200);
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
