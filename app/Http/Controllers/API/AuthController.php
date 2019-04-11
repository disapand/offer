<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'account' => 'required',
            'password' => 'required|string|min:6|max:20'
        ];

        // 验证参数，验证失败则抛出 ValidationException 异常
        $params = $this->validate($request, $rules);

        // 使用 Auth 登录用户，登录成功则返回 201 和 token，登录失败则返回 400 和提示信息
        return ($token = Auth::guard('api')->attempt($params))
            ? response()->json(['token' => 'bearer ' . $token], 201)
            : response()->json(['error' => '账号或密码错误'], 400);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => '退出成功']);
    }

    /**
     * @return UserResource
     */
    public function profile()
    {
       $user =  Auth::guard('api')->user();
       return new UserResource($user);
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function profiles()
    {
        return UserResource::collection(User::all());
    }

    /**
     * @param UserRequest $userRequest
     * @return UserResource
     */
    public function store(UserRequest $userRequest)
    {
        $userRequest['password'] = bcrypt($userRequest['password']);
        return new UserResource(User::updateOrCreate($userRequest->toArray()));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, Request $request)
    {
        if ($request['password']) {
            $request['password'] = bcrypt($request['password']);
        } else {
            unset($request['password']);
        }
        $user->update($request->toArray());
        return response()->json([
            'message' => '更新成功'
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return response()->json([
                'message' => '删除成功'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => '删除账号信息出错',
                'Msg' => $exception->getMessage()
            ]);
        }
    }
}
