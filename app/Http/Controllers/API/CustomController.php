<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CustomRequest;
use App\Http\Resources\CustomResource;
use App\Models\Custom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomController extends Controller
{

    const PAGESIZE = 10;
    /**
     *  获取所有的客户信息
     *
     * @return CustomResource
     */
    public function index()
    {
        return CustomResource::collection(Custom::paginate(self::PAGESIZE));
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
        $custom = $request->toArray();
        return new CustomResource(Custom::create($custom));
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

    public function search($nameOrCompany)
    {
        $customs = Custom::where('name', 'like', "%$nameOrCompany%")->orWhere('company', 'like', "%$nameOrCompany%")->paginate(self::PAGESIZE);
        return CustomResource::collection($customs);
    }
}
