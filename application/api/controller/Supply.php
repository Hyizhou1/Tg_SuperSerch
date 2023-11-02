<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
class Supply extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function add($mid = null){
        if(!$mid){
            $this->error();
        }
        if($this->request->isPost()){
            $title = $this->request->post("title");
            $content = $this->request->post("content");
            $type = $this->request->post("type");
            $money = $this->request->post("money");
            $image = $this->request->post("image");
            $messid = $this->request->post("messid");
            $dusuid = $this->request->post("desuid");
            $tinfo = Db::name("member")->where("tg_id",$mid)->find();
            $arr = [
                "member_id" => $tinfo["member"],
                "title" => $title,
                "content" => $content,
                "moneyqj" => $money,
                "image" => $image,
                "messid" => $messid,
                "desu_id" => $dusuid,
                "type" => $type,
                "addtime" => date("Y-m-d H:i:s",time())
            ];
            $res = Db::name("supply")->insertGetId($arr);
            Db::name("member")->where("member",$tinfo["member"])->setDec("money",config("site")["supply"]);
            $this->success("",["data"=>$res]);
        }
    }
    
    public function querym($mid){
        $tinfo = Db::name("member")->where("tg_id",$mid)->find();
        $c = Db::name("supply")->where("member_id",$tinfo["member"])->count();
        $this->success($c);
    }
}