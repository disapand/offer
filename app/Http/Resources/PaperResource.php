<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\Resource;

class PaperResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'custom' => new CustomResource($this->custom),
            'paperId' => $this->paperId,
            'paperTime' => $this->paperTime,
            'paperList' => $this->paperList,
            'discount' => $this->discount,
            'shouldPay' => $this->shouldPay,
            'transformPrice' => $this->transformPrice,
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
