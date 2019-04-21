<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'user_id', 'custom_id', 'paperId', 'paperTime', 'paperList', 'discount', 'shouldPay', 'transformPrice'
    ];

    public function custom()
    {
        return $this->belongsTo(Custom::class, 'custom_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
