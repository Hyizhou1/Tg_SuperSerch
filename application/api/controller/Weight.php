<?php

namespace app\api\controller;

use app\common\controller\Api;

class Weight extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function write($group_id,$keyword_id,$sort){
        $weight = new \app\common\model\Weight();
        $winfo = $weight->where(["group_id"=>$group_id,"keyword_id"=>$keyword_id])->find();
        if(!$winfo){
            $arr = [
                "group_id" => $group_id,
                "keyword_id" => $keyword_id,
                "sort" => $sort,
                "addtime" => date("Y-m-d H:i:s",time()),
            ];
            $res = $weight->insertGetId($arr);
            if($res){
                $this->success("");
            }else{
                $this->error("");
            }
        }else{
            $this->error("");
        }
    }
}