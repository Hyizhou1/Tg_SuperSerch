<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

class Invite extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        if($this->request->isPost()){
            $mid = $this->request->post("mid");
            $number = trim($this->request->post("number"));
            $msg = trim($this->request->post("msg"));
            $minfo = Db::name("member")->where(["tg_id"=>$mid])->find();
            $arr = [
                "member_id" => $minfo["member"],
                "number" => $number,
                "msg" => $msg,
                "addtime" => date("Y-m-d H:i:s",time())
            ];
            Db::name("coin")->insertGetId($arr);
            $this->success();
        }
    }
}