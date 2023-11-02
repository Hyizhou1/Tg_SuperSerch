<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
class Keyword extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    //获取关键词列表
    public function index($page = 1){
        if($this->request->isPost()){
            $number = $this->request->post("number");
            $key = new \app\common\model\Keyword();
            $data = $key->field("title,keyword_id")->paginate($number)->toArray();
            if($data){
                $this->success(__("getdatasuccess"),$data);
            }else{
                $this->error(__("datanull"));
            }
        }else{
            $this->error(__("request"));
        }
    }
    
    //添加关键词
    public function write($key){
        $key1 = new \app\common\model\Keyword();
        $arr = [
            "title" => $key,
            "money" => 10,
            "addtime" => date("Y-m-d H:i:s",time()),
        ];
        try{
            $res = $key1->insertGetId($arr);
            $this->success(__("getdatasuccess"),$res);
        }catch(\think\exception\PDOException $e){
            $res = $key1->where(["title"=>$key])->find();
            $this->success(__("getdatasuccess"),$res->keyword_id);
        }
    }
    
    //查询关键词
    public function querykey($keyid){
        $keyinfo = Db::name("keyword")->where("keyword_id",$keyid)->find();
        $weightcount = Db::name("weight")->where("keyword_id",$keyid)->count();
        $old = Db::name("oldmoney")->where("keyword_id",$keyid)->order("money desc")->find();
        $weightnoadv = Db::name("weight")->where(["keyword_id"=>$keyid,"payadv"=>0])->count();
        if($old == null){
            $money = $keyinfo["money"];
        }else{
            $money = $old["money"];
        }
        $arr = [
            "name" => $keyinfo["title"],
            "money" => $money,
            "weightcount" => $weightcount,
            "weightadv" => $weightcount - $weightnoadv,
            "sea" => $keyinfo["sea"],
        ];
        $this->success("",$arr);
    }
    
    //购买关键词
    public function buykey($keyid,$groupid,$userid){
        $keyinfo = Db::name("keyword")->where("keyword_id",$keyid)->find();
        $old = Db::name("oldmoney")->where("keyword_id",$keyid)->order("money desc")->find();
        $m = config("site")["addmoney"];
        if($old == null){
            $money = $keyinfo["money"] + $m;
        }else{
            $money = $old["money"] + $m;
        }
        $minfo = Db::name("member")->where("tg_id",$userid)->find();
        if($minfo["money"] - $money < 0){
            $this->error("余额不足,请先充值余额");
        }
        $ginfo = Db::name("group")->where("tggroup_id",$groupid)->find();
        $weightinfo = Db::name("weight")->where(["keyword_id"=>$keyid])->order("payadv desc")->find();
        $payadv = $weightinfo["payadv"] + 1;
        $list = Db::name("weight")->where(["keyword_id"=>$keyid,"group_id"=>$ginfo["group_id"]])->find();
        if($list){
            Db::name("weight")->where(["keyword_id"=>$keyid,"group_id"=>$ginfo["group_id"]])->update(["payadv"=>$payadv]);
        }else{
            $arr = [
                "group_id" => $ginfo["group_id"],
                "keyword_id" => $keyid,
                "sort" => 0,
                "payadv" => $payadv,
                "addtime" => date("Y-m-d H:i:s",time())
            ];
            Db::name("weight")->insertGetId($arr);
        }
        Db::name("oldmoney")->insertGetId(["keyword_id"=>$keyid,"money"=>$money,"addtime"=>date("Y-m-d H:i:s",time()),"group_id"=>$ginfo["group_id"]]);
        $minfo = Db::name("member")->where("tg_id",$userid)->setDec("money",$money);
        $this->success("购买成功,扣除".$money." USDT");
    }
    
    //查询关键词历史价格
    public function seeoldmoney($keyid,$page = 1){
        $oldinfo = Db::name("oldmoney")->where("keyword_id" , $keyid)->order("old_id desc")->paginate(20);
        $this->success("",$oldinfo);
    }
    
    //设置标签
    public function setlable($group,$lable){
        $ginfo = Db::name("group")->where("tggroup_id",$group)->find();
        $key = explode(",",$lable);
        Db::name("weight")->where("group_id",$ginfo["group_id"])->delete();
        for($i = 0;$i<count($key);$i++){
            $keyinfo = Db::name("keyword")->where("title",$key[$i])->find();
            if($keyinfo){
                $keyid = $keyinfo["keyword_id"];
            }else{
                $keyid = Db::name("keyword")->insertGetId(["title"=>$key[$i],"money" => 10,"sea"=>0,"addtime"=>date("Y-m-d H:i:s",time())]);
            }
            $arr = [
                "group_id" => $ginfo["group_id"],
                "keyword_id" => $keyid,
                "addtime" => date("Y-m-d H:i:s",time())
            ];
            Db::name("weight")->insertGetId($arr);
        }
        $this->success("添加成功");
    }
}