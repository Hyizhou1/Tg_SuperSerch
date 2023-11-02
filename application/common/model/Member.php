<?php

namespace app\common\model;

use think\Model;


class Member extends Model
{

    

    

    // 表名
    protected $name = 'member';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'ishhr_text',
        'addtime_text'
    ];
    

    
    public function getIshhrList()
    {
        return ['0' => __('Ishhr 0'), '1' => __('Ishhr 1')];
    }


    public function getIshhrTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['ishhr']) ? $data['ishhr'] : '');
        $list = $this->getIshhrList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getAddtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['addtime']) ? $data['addtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAddtimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
