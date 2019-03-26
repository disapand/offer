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
        return new CustomResource(Custom::all());
    }

    /**
     *  获取指定的客户信息
     *
     * @param Custom $custom
     * @return CustomResource
     */
    public function get(Custom $custom)
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
}
