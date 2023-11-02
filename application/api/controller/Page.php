<?php

namespace app\api\controller;

use app\common\controller\Api;

class Page extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        if($this->request->isPost()){
            $key = $this->request->post("key");
            $page = new \app\common\model\Page();
            $data = $page->where(["key"=>$key])->find();
            if($data){
                $this->success(__("getdatasuccess"),$data);
            }else{
                $this->error(__("pagenulldata"));
            }
        }else{
            $this->error(__("request"));
        }
    }
}