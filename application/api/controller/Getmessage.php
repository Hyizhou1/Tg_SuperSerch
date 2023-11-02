<?php

namespace app\api\controller;

use app\common\controller\Api;

class Getmessage extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        if($this->request->isPost()){
            $data = $this->request->post("message");
            $data = str_replace('&quot;','"',$data);
            $message = new \app\common\model\Getmessage();
            $arr = json_decode($data,true);
            $arr["addtime"] = date("Y-m-d H:i:s",time());
            $message->insertGetId($arr);
            $this->success("消息推送成功");
        }
    }
}