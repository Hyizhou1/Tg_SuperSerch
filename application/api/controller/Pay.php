<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\Order;
use think\Db;

class Pay extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    //创建订单并获取支付链接
    public function subpay(){
        if($this->request->isPost()){
            $money = (float)$this->request->post("money"); //金额
            $type = $this->request->post("type");   //支付类型
            $mid = $this->request->post("mid");   //支付类型
            $orderid = "USDT".date("YmdHis", time()) . rand(10000000, 99999999);
            $resdata = gopay($orderid, $money);
            if($resdata["status_code"] != 200){
                $this->error($resdata["message"]);
            }
            $minfo = Db::name("member")->where("tg_id",$mid)->find();
            $res = $resdata["data"];
            $arr = [
                "member_id" => $minfo["member"],
                "orderno" => $orderid,
                "trade_id" => $res["trade_id"],
                "amount" => $res["amount"],
                "actual_amount" => $res["actual_amount"],
                "token" => $res["token"],
                "payment_url" => $res["payment_url"],
                "addtime" => date("Y-m-d H:i:s",time()),
                "other" => json_encode(["content"=>"这是测试群组","url"=>"https://www.baidu.com"],JSON_UNESCAPED_UNICODE),
            ];
            if($this->saveOrder($arr)){
                $this->success(__('crateordersuccess'),$res);
            }else{
                $this->error(__("crateordererror"));
            }
        }
    }


    public function buyadv(){
        if($this->request->isPost()){
            $money = $this->request->post("money");
            $type = $this->request->post("type");
            $member_id = $this->request->post("mid");
            $minfo = Db::name("member")->where("tg_id",$member_id)->find();
            if($minfo["money"] < $money){
                $this->error("余额不足,请先充值余额后再购买广告");
            }
            $arr = [
                "advorderno" => "ADV".date("YmdHis",time()).rand(100000,999999),
                "member_id" => $minfo["member"],
                "advtype" => $type,
                "money" => $money,
                "other" => "",
                "addtime" => date("Y-m-d H:i:s",time())
            ];
            Db::name("advorder")->insertGetId($arr);            //广告订单
            Db::name("adv")->insertGetId(["member_id"=>$minfo["member"],"advtype_id"=>$type,"content"=>"广告名称","url"=>"https://www.baidu.com","addtime"=>date("Y-m-d H:i:s",time()),"endtime"=>date("Y-m-d H:i:s",time() + 2592000)]);    //写入一个月广告
            $arr2 = [
                    "member_id" => $minfo["member"],
                    "msg" => "购买广告消费".$money."USDT",
                    "money" => $money,
                    "addtime" => date("Y-m-d H:i:s",time()),
                ];
                //消费记录
            Db::name("balan")->insertGetId($arr2);
            Db::name("member")->where("member",$minfo["member"])->setDec("money",$money);
            $this->success("广告购买成功,当前广告信息为默认信息,请及时到我的广告信息处修改广告信息");
        }
    }

    //查询订单
    public function queryorder(){
        if($this->request->isPost()){
            $orderno = $this->request->post("orderno");
            $order = new Order();
            $res = $order->where(["orderno"=>$orderno])->field("orderno,amount,actual_amount,token,payment_url,status")->find()->toArray();
            if($res){
                $this->success(__("queryordersuccess"),$res);
            }else{
                $this->error(__("queryordererror"));
            }
        }
    }

    //异步通知
    public function notify(){
        //异步通知业务逻辑
        if($this->request->isPost()){
            $order_id = $this->request->post("order_id");
            $orderinfo = Db::name("order")->where(["orderno"=>$order_id])->find();
            if($orderinfo["status"] != 1){
                Db::name("order")->where(["orderno"=>$order_id])->update(["status"=>1]);
                Db::name("member")->where(["member"=>$orderinfo["member_id"]])->setInc("money",$orderinfo["actual_amount"]);
                $uinfo = Db::name("member")->where(["member"=>$orderinfo["member_id"]])->find();
                $arr = [
                    "member_id" => $orderinfo["member_id"],
                    "msg" => "充值".$orderinfo["actual_amount"]."USDT",
                    "money" => $orderinfo["actual_amount"],
                    "addtime" => date("Y-m-d H:i:s",time()),
                ];
                //充值记录
                Db::name("balan")->insertGetId($arr);
                file_get_contents(BOT_API."/index.php/index/notify.html?uid=".$uinfo["tg_id"]."&money=".$orderinfo["actual_amount"]."&orderid=".$order_id);
                echo "SUCCESS";
            }
        }
    }

    //同步通知
    public function redirect(){
        echo "success";
    }
}