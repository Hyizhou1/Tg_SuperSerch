<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 * 提现列管理
 *
 * @icon fa fa-circle-o
 */
class Cash extends Backend
{

    /**
     * Cash模型对象
     * @var \app\common\model\Cash
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\Cash;
        $this->view->assign("statusList", $this->model->getStatusList());
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
     
     public function edit($ids = null){
        $row = $this->model->get(['cash_id' => $ids]);
 
        if(!$row){
            $this->error(_('找不到！'));
        }
        if ($this->request->isAjax()) {
            $params = $this->request->post("row/a");
            if($params){
                if($params["status"] == 0){
                    $this->error("请选择状态");
                }
                if($params["status"] == -1){
                    Db::name("member")->where("member",$params["member_id"])->setInc("money",$params["actualmoney"]);
                }
                $this->model->where('cash_id', $ids)->update($params);
                $minfo = Db::name("member")->where("member",$params["member_id"])->find();
                $url = BOT_API."/index.php/index/sendtx.html?ids=".$ids."&uid=".$minfo["tg_id"];
                echo $url;
                file_get_contents($url);
                $this->success();
            }
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

}
