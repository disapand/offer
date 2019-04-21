<?php

namespace App\Http\Controllers\API;

use App\Models\Custom;
use App\Models\Paper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\handle\handle;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                'paperList' => $handle->save2text($request->paperList),
                'discount' => $request->discount,
                'shouldPay' => $request->shouldPay,
                'transformPrice' => $request->transformPrice,
            );

            Paper::create($data);
            return response()->json($handle->get2array($data['paperList']));
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
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
