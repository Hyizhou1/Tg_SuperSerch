<?php

namespace app\common\model;

use think\Model;


class Sell extends Model
{

    

    

    // 表名
    protected $name = 'sell';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'type_text',
        'status_text',
        'contype_text',
        'isuse_text',
        'addtime_text'
    ];
    

    
    public function getTypeList()
    {
        return ['0' => __('Type 0'), '1' => __('Type 1')];
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1'), '2' => __('Status 2')];
    }

    public function getContypeList()
    {
        return ['0' => __('Contype 0'), '1' => __('Contype 1'), '2' => __('Contype 2'), '3' => __('Contype 3')];
    }

    public function getIsuseList()
    {
        return ['0' => __('Isuse 0'), '1' => __('Isuse 1')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getContypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['contype']) ? $data['contype'] : '');
        $list = $this->getContypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsuseTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isuse']) ? $data['isuse'] : '');
        $list = $this->getIsuseList();
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
