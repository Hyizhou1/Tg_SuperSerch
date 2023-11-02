<?php

namespace app\common\model;

use think\Model;


class Weight extends Model
{

    

    

    // 表名
    protected $name = 'weight';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







    public function keyword()
    {
        return $this->belongsTo('Keyword', 'weight_id', 'keyword_id', [], 'LEFT')->setEagerlyType(0);
    }


    public function group()
    {
        return $this->belongsTo('Group', 'group_id', 'group_id', [], 'LEFT')->setEagerlyType(0);
    }
}
