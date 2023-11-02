<?php

namespace app\api\controller;

use app\common\controller\Api;

class Adv extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        if($this->request->isPost()){
            $type = (int)$this->request->post("advtype");
            $adv = new \app\common\model\Adv();
            $res = $adv->where(["advtype_id" => $type])->where("endtime", ">=", date("Y-m-d H:i:s"))->select();
            $this->success(__('advlistsuccess'),$res);
        }
    }

    public function getcjadv($page = 1){
        $adv = new \app\common\model\Adv();
        $res = $adv->where(["advtype_id" => 3])->where("endtime", ">=", date("Y-m-d H:i:s"))->paginate(10);
        $this->success(__("getcjadvsuccess"),$res);
    }
    //获取用户广告
    public function getuseradv($userid,$page = 1){
        $member = new \app\admin\model\Member();
        $data = $member->where(["tg_id"=>$userid])->find()->toArray();
        $adv = new \app\common\model\Adv();
        $res = $adv->where(["member_id" => $data["member"]])->where("endtime", ">=", date("Y-m-d H:i:s"))->select();
        $this->success("",$res);
    }
    //获取广告详细信息
    public function getadvinfo($advid){
        $adv = new \app\common\model\Adv();
        $res = $adv->join("advtype","fa_adv.advtype_id = advtype.advtype_id")->where(["adv_id" => $advid])->find();
        $this->success("",$res);
    }
    //更新广告内容
    public function edit($advid){
        if($this->request->isPost()){
            $arr = [
                "content" => $this->request->post("content"),
                "url" => $this->request->post("url"),
            ];
            $adv = new \app\common\model\Adv();
            $res = $adv->where(["adv_id"=>$advid])->update($arr);
            $this->success(__("adveditsuccess"),null);
        }
    }
}