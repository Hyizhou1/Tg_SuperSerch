<?php

namespace app\api\controller;


use app\common\controller\Api;

class Functions extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        if($this->request->isPost()){
            $key = $this->request->post("key");
            $page = new \app\common\model\Functions();
            $data = $page->where(["key"=>$key])->find();
            $this->success(__("getdatasuccess"),$data);
        }else{
            $this->error(__("request"));
        }
    }
}