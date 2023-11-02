<?php

namespace app\common\model;

use think\Model;


class Group extends Model
{

    

    

    // 表名
    protected $name = 'group';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'group_type_text',
        'iscj_text',
        'issearch_text',
        'istop_text',
        'isshield_text',
        'isenter_text',
        'entertype_text',
        'isenteradv_text',
        'timeadv_text',
        'timetype_text',
        'handle_text',
        'group_status_text',
        'addtime_text'
    ];
    

    
    public function getGroupTypeList()
    {
        return ['0' => __('Group_type 0'), '1' => __('Group_type 1')];
    }

    public function getIscjList()
    {
        return ['0' => __('Iscj 0'), '1' => __('Iscj 1')];
    }

    public function getIssearchList()
    {
        return ['0' => __('Issearch 0'), '1' => __('Issearch 1')];
    }

    public function getIstopList()
    {
        return ['0' => __('Istop 0'), '1' => __('Istop 1')];
    }

    public function getIsshieldList()
    {
        return ['0' => __('Isshield 0'), '1' => __('Isshield 1'), '2' => __('Isshield 2')];
    }

    public function getIsenterList()
    {
        return ['0' => __('Isenter 0'), '1' => __('Isenter 1'), '2' => __('Isenter 2')];
    }

    public function getEntertypeList()
    {
        return ['0' => __('Entertype 0'), '1' => __('Entertype 1'), '2' => __('Entertype 2')];
    }

    public function getIsenteradvList()
    {
        return ['0' => __('Isenteradv 0'), '1' => __('Isenteradv 1')];
    }

    public function getTimeadvList()
    {
        return ['0' => __('Timeadv 0'), '1' => __('Timeadv 1'), '2' => __('Timeadv 2')];
    }

    public function getTimetypeList()
    {
        return ['0' => __('Timetype 0'), '1' => __('Timetype 1'), '2' => __('Timetype 2')];
    }

    public function getHandleList()
    {
        return ['0' => __('Handle 0'), '1' => __('Handle 1')];
    }

    public function getGroupStatusList()
    {
        return ['0' => __('Group_status 0'), '1' => __('Group_status 1')];
    }


    public function getGroupTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['group_type']) ? $data['group_type'] : '');
        $list = $this->getGroupTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIscjTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['iscj']) ? $data['iscj'] : '');
        $list = $this->getIscjList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIssearchTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['issearch']) ? $data['issearch'] : '');
        $list = $this->getIssearchList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIstopTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['istop']) ? $data['istop'] : '');
        $list = $this->getIstopList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsshieldTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isshield']) ? $data['isshield'] : '');
        $list = $this->getIsshieldList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsenterTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isenter']) ? $data['isenter'] : '');
        $list = $this->getIsenterList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getEntertypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['entertype']) ? $data['entertype'] : '');
        $list = $this->getEntertypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsenteradvTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isenteradv']) ? $data['isenteradv'] : '');
        $list = $this->getIsenteradvList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTimeadvTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['timeadv']) ? $data['timeadv'] : '');
        $list = $this->getTimeadvList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTimetypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['timetype']) ? $data['timetype'] : '');
        $list = $this->getTimetypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getHandleTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['handle']) ? $data['handle'] : '');
        $list = $this->getHandleList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getGroupStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['group_status']) ? $data['group_status'] : '');
        $list = $this->getGroupStatusList();
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
