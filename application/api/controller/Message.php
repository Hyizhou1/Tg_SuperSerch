<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
class Message extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        if($this->request->isPost()){
            $msg = $this->request->post("msg");
            $member_id = $this->request->post("memberid");
            //开始事务
            Db::startTrans();
            $message = new \app\common\model\Message();
            $data = $message->where(["msg"=>$msg])->find();
            if($data){
                $this->error(__("existencemsg"));
            }
            $data = [
                "member_id" => $member_id,
                "msg" =>  str_replace('&quot;','"',$msg),
                "addtime" => date("Y-m-d H:i:s",time())
            ];
            $res = $message->insertGetId($data);
            //提交事务
            Db::commit();
            if($res){
                $this->success(__("msgwritesuccess"),$res);
            }else{
                $this->error(__("msgwriteerror"));
            }
        }
    }
}