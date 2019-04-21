<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Custom extends Model
{
    use SoftDeletes;


    /**
     * 可填充字段，只有设置在 fillable 中的字段才可以通过程序新增
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'company', 'addr', 'email', 'notice'
    ];

    /**
     *  设置软删除的字段 deleted_at 的格式为日期格式
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    public function papers()
    {
        return $this->hasMany(Paper::class, 'custom_id', 'id');
    }
}
