<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        return $this->view->fetch();
    }
    
    public function setwel($gid){
        if($this->request->isPost()){
            
        }else{
            $ginfo = Db::name("group")->where("group_id",$gid)->find();
            $this->assign("item",$ginfo);
            return $this->view->fetch();
        }
    }
    
}
