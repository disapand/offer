<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Custom extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'name', 'number', 'company', 'addr', 'email'
    ];

    /**
     *  设置软删除的字段 deleted_at 的格式为日期格式
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
}
