<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PaperResource;
use App\Imports\TestImport;
use App\Models\Custom;
use App\Models\Paper;
use App\Models\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\handle\handle;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
            $papers = PaperResource::collection(Paper::orderby('id', 'desc')->paginate(self::PAGESIZE));
        } else {
            $papers = PaperResource::collection(Paper::whereHas('user', function ($query) use ($username) {
                $query->where('username', 'like', "%$username%");
            })->orderby('id', 'desc')->paginate(self::PAGESIZE));
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

            return response()->json($data);
            
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
        })->orderby('id', 'desc')->paginate(self::PAGESIZE);
        return PaperResource::collection($papers);
    }

    public function uploadPaperList(Request $request)
    {
        $data = Excel::toArray(new TestImport(), $request->file('file'))[0];
        $paperList = [];
        for ($i = 1; $i < count($data); $i ++) {
            $tmp['name'] = $data[$i][1];
            $tmp['type'] = $data[$i][2];
            $tmp['number'] = $data[$i][3] ? $data[$i][3] : 1;
            $price = Price::where('name', 'like', '%' . $tmp['name'] . '%')->first();
            $tmp['price'] = $price ? $price->price : '0';
            $tmp['level'] = $price ? $price->level : '';
            $tmp['range'] = $price ? $price->range : '';
            $tmp['total'] = $tmp['price'] * $tmp['number'];
            array_push($paperList, $tmp);
        }

        return response()->json(['data' => $paperList]);
    }
}
