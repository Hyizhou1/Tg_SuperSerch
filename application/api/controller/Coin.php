<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Request;
use think\Db;
class Coin extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index($page = 1){
        if($this->request->isPost()){
            $uid = $this->request->post("uid");
            $userinfo = Db::name("member")->where("tg_id",$uid)->find();
            $data = Db::name("coin")->where("member_id",$userinfo["member"])->order("coin_id desc")->paginate(20);
            $this->success(__("actionsuccess"),$data);
        }
    }
    
    public function duihuan($uid){
        $userinfo = Db::name("member")->where("tg_id",$uid)->find();
        $coin = (int)$userinfo["coin"];
        $k = config("site")["bili"];
        $USDTb = $coin / $k;
        $USDT = (int)$USDTb;
        if($USDT == 0){
            $this->success("积分不足,无法兑换");
        }
        $kcoin = $USDT * $k;
        Db::name("member")->where("tg_id",$uid)->setInc("money",$USDT);
        Db::name("member")->where("tg_id",$uid)->setDec("coin",$kcoin);
        $arr = [
            "member_id" => $userinfo["member"],
            "type" => 0,
            "number" => $kcoin,
            "msg" => "兑换{$kcoin}".config("site")["membercoin"],
            "status" => 1,
            "addtime" => date("Y-m-d H:i:s",time()),
        ];
        Db::name("coin")->insertGetId($arr);
        $this->success("成功".$arr["msg"].",成功到账".$USDT."USDT,请到余额中查看");
    }
    
}