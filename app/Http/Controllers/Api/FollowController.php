<?php

namespace App\Http\Controllers\Api;

use App\Models\Follow;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Helpers\TransactionHelper;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public $followModel;

    public function __construct(Follow $follow)
    {
        $this->followModel = $follow;
    }

    public function getAll(Request $request)
    {
        $user = json_decode($request->header('user'));
        $data = $this->followModel->where('user_id', $user->id)->with('user:id,name,email,avatar_path')->get()->pluck('user');
        foreach ($data as  $value) {
            $value['avatar_path'] = env('APP_URL') . $value->avatar_path;
        }
        return ResponseHelper::success('Follow fetched successfully.', $data, 200);
    }

    public function follow(Request $request, string $user_id)
    {
        return Helpers::tryCatchHelper(function () use ($request, $user_id) {
            $user = json_decode($request->header('user'));
            $follow = $this->followModel->where('user_id', $user->id)->where('follow_id', $user_id)->first();
            if ($follow) {
                $follow->delete();
                return ResponseHelper::success('Unfollowed successfully.', null, 200);
            } else {
                $this->followModel->create([
                    'user_id' => $user->id,
                    'follow_id' => $user_id
                ]);
                return ResponseHelper::success('Followed successfully.', null, 200);
            }
        });
    }
}
