<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 群组列管理
 *
 * @icon fa fa-group
 */
class Group extends Backend
{

    /**
     * Group模型对象
     * @var \app\common\model\Group
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\Group;
        $this->view->assign("groupTypeList", $this->model->getGroupTypeList());
        $this->view->assign("iscjList", $this->model->getIscjList());
        $this->view->assign("issearchList", $this->model->getIssearchList());
        $this->view->assign("istopList", $this->model->getIstopList());
        $this->view->assign("isshieldList", $this->model->getIsshieldList());
        $this->view->assign("isenterList", $this->model->getIsenterList());
        $this->view->assign("entertypeList", $this->model->getEntertypeList());
        $this->view->assign("isenteradvList", $this->model->getIsenteradvList());
        $this->view->assign("timeadvList", $this->model->getTimeadvList());
        $this->view->assign("timetypeList", $this->model->getTimetypeList());
        $this->view->assign("handleList", $this->model->getHandleList());
        $this->view->assign("groupStatusList", $this->model->getGroupStatusList());
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
