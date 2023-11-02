<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
use think\exception\PDOException;

class Member extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function getmemberinfo(){
        if($this->request->isPost()){
            $tgid = $this->request->post("tgid");
            $member = new \app\admin\model\Member();
            $data = $member->where(["tg_id"=>$tgid])->find();
            if($data) {
                $this->success(__("getdatasuccess"), $data->toArray());
            }else{
                $this->error(__("memberdatanull"));
            }
        }else{
            $this->error(__("request"));
        }
    }
    //保存用户信息
    public function savemember(){
        if($this->request->isPost()){
            //dump($this->request->post());exit();
            $tg_id = $this->request->post("tgid");
            $username = $this->request->post("username");
            $firstname = $this->request->post("firstname");
            $lastname = $this->request->post("lastname");
            $headimg = $this->request->post("headimg");
            $up_tg_id = $this->request->post("up_tg_id");
            $arr = [
                "tg_id" => $tg_id,
                "username" => $username,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "headimg" => $headimg,
                "addtime" => datetime(time()),
            ];
            Db::startTrans();
            $member = new \app\admin\model\Member();
            try {
                if ($up_tg_id == 0) {
                    $res = $member->insertGetId($arr);
                } else {
                    $data = $member->where(["tg_id" => $up_tg_id])->find();
                    $arr["member_id"] = $data->member;
                    $res = $member->insertGetId($arr);
                    $member->where(["tg_id"=>$up_tg_id])->setInc("coin",(int)config("site")["newmember"]);
                }
                Db::commit();
                if ($res) {
                    $this->success(__("datasumitsuccess"), ["data" => $res]);
                } else {
                    $this->error(__("datasumiterror"));
                }
            }catch (PDOException $e){
                $res = $member->where(["tg_id" => $tg_id])->update(["updatetime"=>datetime(time())]);
                Db::commit();
                if ($res) {
                    $this->success(__("datasumitsuccess"), ["data" => $res],5);
                } else {
                    $this->error(__("datasumiterror"));
                }
            }
        }else{
            $this->error(__("request"));
        }
    }
    //设置token
    public function settoken(){
        if($this->request->isPost()){
            $token = $this->request->post("token");
            $mid = $this->request->post("mid");
            $member = new \app\common\model\Member();
            $member->where(["tg_id"=>$mid])->update(["utoken"=>$token]);
            $this->success(__("tokensuccess"));
        }
    }
    //邀请用户
    public function invite(){
        if($this->request->isPost()){
            $umid = $this->request->post("umid");
            $mid = $this->request->post("mid");
            $coin = $this->request->post("coin");
            $uminfo = Db::table("member")->where(["tg_id"=>$umid])->find();
            Db::name("member")->where(["tg_id"=>$mid])->update(["member_id"=>$uminfo["member"]]);
            Db::name("member")->where(["tg_id"=>$umid])->setInc("coin",(int)$coin);
            $this->success();
        }
    }
    //余额明细
    public function moneylist($userid,$page = 1){
        $userinfo = Db::name("member")->where("tg_id",$userid)->find();
        $balanlist = Db::name("balan")->where("member_id",$userinfo["member"])->paginate(20);
        $this->success("",$balanlist);
    }
}