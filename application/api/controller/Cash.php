<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Request;
use think\Db;

class Cash extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    private $cash;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->cash = new \app\common\model\Cash();
    }
    //获取我的所有提现记录
    public function index(){
        if($this->request->isPost()){
            $mid = $this->request->post("mid");
            $data = $this->cash->where(["member_id"=>$mid])->order("cash_id desc")->paginate(20);
        }
    }
    //提现
    public function tx(){
        if($this->request->isPost()){
            //用户id
            $mid = $this->request->post("mid");
            //提现金额
            $money = $this->request->post("money");
            $minfo = new \app\common\model\Member();
            $m = $minfo->where(["tg_id"=>$mid])->find();
            if($m->utoken == "" || $m->utoken == null){
                $this->error(__("utokennull"),null,-1);
            }
            $surplus = $m->money - $money;
            if($surplus < 0){
                $this->error(__("eebz"));
            }
            $bfn = $money * config("site")["cashsx"];
            $gm = $money - $bfn;
            $arr = [
                "member_id" => $m->member,
                "money" => $gm,
                "actualmoney" => $money,
                "surplus" => $surplus,
                "utoken" => $m->utoken,
                "addtime" => date("Y-m-d H:i:s",time()),
            ];
            $this->cash->insertGetId($arr);
            $minfo->where(["tg_id"=>$mid])->setDec("money",$money);
            $this->success(__("actionsuccess"),$arr);
        }
    }
    
    public function querycash($ids){
        $d = Db::name("cash")->where("cash_id",$ids)->find();
        $this->success("",$d);
    }
}