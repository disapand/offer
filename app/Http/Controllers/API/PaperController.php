<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PaperResource;
use App\Models\Custom;
use App\Models\Paper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\handle\handle;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
{
    const PAGESIZE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = Auth::guard('api')->user()->username;
        if ($username === '管理员') {
            $papers = PaperResource::collection(Paper::paginate(self::PAGESIZE));
        } else {
            $papers = PaperResource::collection(Paper::whereHas('user', function ($query) use ($username) {
                $query->where('username', 'like', "%$username%");
            })->paginate(self::PAGESIZE));
        }
        return $papers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, handle $handle)
    {
        try {
            $custom = $request->contact;
            $custom = Custom::updateOrCreate($custom);
            $user = $request->profile;

            $data = array(
                'user_id' => $user['id'],
                'custom_id' => $custom['id'],
                'paperId' => $request->paperId,
                'paperTime' => $request->paperTime,
                'paperList' => $request->paperList,
                'discount' => $request->discount,
                'shouldPay' => $request->shouldPay,
                'transformPrice' => $request->transformPrice,
            );

            Paper::create($data);
            return response()->json(['Msg' => '创建成功'], 200);
        } catch (Exception $exception) {
            return response()->json($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Paper $paper)
    {
        return new PaperResource($paper);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper $paper)
    {
        try {
            $paper->delete();
            return response()->json([
                'Msg' => '删除成功'
            ]);
        } catch (Exception $exception) {
            return reponse()->json([
                'error' => '删除报价单出错',
                'Msg' => $exception->getMessage()
            ]);
        }
    }

    public function query($company)
    {
        $papers = Paper::whereHas('custom', function ($query) use ($company) {
            $query->where('company', 'like', "%$company%");
        })->paginate(self::PAGESIZE);
        return PaperResource::collection($papers);
    }

    public function uploadPaperList(Request $request)
    {
        return response()->json($request);
    }
}
