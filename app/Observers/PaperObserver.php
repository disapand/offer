<?php


namespace App\Observers;


use App\handle\handle;
use App\Models\Paper;

class PaperObserver
{
    public function retrieved(Paper $paper)
    {
        $handle = new handle();
        $paper['paperList'] = $handle->get2array($paper->paperList);
    }

    public function saving(Paper $paper) {
        $handle = new handle();
        $paper['paperList'] = $handle->save2text($paper->paperList);
    }
}
