<?php


namespace App\Observers;


use App\handle\handle;
use App\Models\Paper;

class PaperObserver
{
    public function retrieved(Paper $paper)
    {
        return response()->json('取出', $paper['paperList']);
        $handle = new handle();
        $paper['paperList'] = $handle->get2array($paper->paperList);
        return response()->json('取出前', $paper['paperList']);
    }

    public function saving(Paper $paper) {
        return response()->json('保存', $paper['paperList']);
        $handle = new handle();
        $paper['paperList'] = $handle->save2text($paper->paperList);
        return response()->json('保存前', $paper['paperList']);
    }
}
