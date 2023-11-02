<?php

namespace app\api\controller;

use app\common\controller\Api;

class Kf extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index($url){
        $sell = new \app\admin\model\Sell();
        $datar = $sell->where(["url"=>$url])->find();
        if($datar == null){
            $isuse = 1;
        }else{
            $isuse = $datar->isuse;
        }
        $arr = config("site");
        $data = [
            "version" => $arr["serversion"],
            "tgkf1" => $arr["tgkf1"],
            "tgkf2" => $arr["tgkf2"],
            "qqkf1" => $arr["qqkf1"],
            "qqfk2" => $arr["qqkf2"],
            "demogroup" => $arr["demogroup"],
            "demobot" => $arr["demobot"],
            "salesgroup" => $arr["salesgroup"],
            "workman" => $arr["workman"],
            "isuse" => $isuse,
            "dbisuse" => $arr["dbisuse"],
        ];
        $this->success("获取成功",$data);
    }
}