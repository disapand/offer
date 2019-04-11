<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CustomRequest;
use App\Http\Resources\CustomResource;
use App\Models\Custom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomController extends Controller
{

    /**
     *  获取所有的客户信息
     *
     * @return CustomResource
     */
    public function index()
    {
        return new CustomResource(Custom::paginate());
    }

    /**
     *  获取指定的客户信息
     *
     * @param Custom $custom
     * @return CustomResource
     */
    public function show(Custom $custom)
    {
        return new CustomResource($custom);
    }

    /**
     *  新增客户信息
     *
     * @param CustomRequest $request
     * @return CustomResource
     */
    public function store(CustomRequest $request)
    {
        return new CustomResource(Custom::create($request->toArray()));
    }


    /**
     * 删除指定的客户信息
     * @param Custom $custom
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Custom $custom)
    {
        try {
            $custom->delete();
            return response()->json([
                'message' => '删除成功'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => '删除客户信息出错',
                'Msg' => $exception->getMessage()
            ]);
        }
    }

    /**
     * 更新指定的客户信息
     * @param Request $request
     * @param Custom $custom
     * @return CustomResource
     */
    public function update(Request $request, Custom $custom)
    {
        $custom->update($request->toArray());
        return new CustomResource($custom);
    }
}
