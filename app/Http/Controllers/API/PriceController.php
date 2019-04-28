<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PriceResource;
use App\Models\Price;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    const PAGESIZE = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PriceResource::collection(Price::orderby('id', 'desc')->paginate(self::PAGESIZE));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $price = Price::create($request->toArray());
        return new PriceResource($price);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        return new PriceResource($price);
    }

    public function search($name)
    {
        $prices = Price::where('name', 'like', "%$name%")->orderby('id', 'desc')->paginate(self::PAGESIZE);
        return PriceResource::collection($prices);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Price  $price
     * @return PriceResource
     */
    public function update(Request $request, Price $price)
    {
        $price->update($request->toArray());
        return new PriceResource($price);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        try {
            $price->delete();
            return response()->json([
                'message' => '删除成功'
            ]);
        } catch (\Exception $exception) {
            return reponse()->json([
                'error' => '删除价目出错',
                'Msg' => $exception->getMessage()
            ]);
        }
    }
}
