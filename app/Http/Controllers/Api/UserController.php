<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Helpers\TransactionHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    const USER_LIMIT = 10;
    public $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userModel;
        if (isset($request->keyword)) {
            $users = $users->where('name', 'like', '%' . $request->q . '%')
                ->orWhere('email', 'like', '%' . $request->q . '%');
        }
        $users = $users->select('id', 'name', 'email', DB::raw("CONCAT('" . env('APP_URL') . "', avatar_path) as avatar_path"))->paginate($request->limit ?? self::USER_LIMIT);

        $response = [
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'data' => $users->items()
        ];
        return ResponseHelper::success('Users fetched successfully.', $response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userModel->select('id', 'name', 'email', DB::raw("CONCAT('" . env('APP_URL') . "', avatar_path) as avatar_path"))->find($id);
        if (is_null($user)) {
            return ResponseHelper::error('User not found!', null, 404);
        }
        return ResponseHelper::success('User fetched successfully.', $user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'avatar_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return TransactionHelper::handle(function () use ($request, $id) {
            $user = $this->userModel->select('id', 'name', 'email', DB::raw("CONCAT('" . env('APP_URL') . "', avatar_path) as avatar_path"))->find($id);
            if (is_null($user)) {
                return ResponseHelper::error('User not found!', null, 404);
            }

            $data = [];

            if ($request->hasFile('avatar_path')) {
                if ($user->avatar_path) {
                    FileHelper::deleteFile($user->avatar_path);
                }
                $fileInfo = FileHelper::uploadFile($request->avatar_path, 'users/avatar');
                if (!is_null($fileInfo)) {
                    $data['avatar_path'] = $fileInfo['path'];
                }
            }

            if ($request->has('name')) {
                $data['name'] = $request->name;
            }

            if ($request->has('email')) {
                $data['email'] = $request->email;
            }

            if ($request->has('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return ResponseHelper::success('User updated successfully!', $user, 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return TransactionHelper::handle(function () use ($id) {
            $user = $this->userModel->find($id);
            if (is_null($user)) {
                return ResponseHelper::error('User not found!', null, 404);
            }

            if ($user->avatar_path) {
                FileHelper::deleteFile($user->avatar_path);
            }
            $user->delete();
            return ResponseHelper::success('User deleted successfully!', null, 200);
        });
    }
}
