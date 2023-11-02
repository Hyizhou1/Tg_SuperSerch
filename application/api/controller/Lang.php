<?php

namespace app\api\controller;

use app\common\controller\Api;

class Lang extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        $this->success("",$this->getLang());
        //echo json_encode($this->getLang(),JSON_UNESCAPED_UNICODE);
    }
    
    private function getLang(){
        $arr = [
            "USDTm" => "USDT/月",
            "zdyje" => "自定义金额",
            "orderid" => "订单号",
            "ordermoney" => "订单金额",
            "zftoken" => "支付token",
            "trcadd" => "TRC20收款地址",
            "setting" => "设置",
            "grouptype" => "群类型",
            "group" => "群组",
            "pindao" => "频道",
            "groupnick" => "名称",
            "groupid" => "群id",
            "grouplink" => "群链接",
            "biaoqian" => "标签",
            "popcount" => "总人数",
            "secount" => "被搜索次数",
            "seaction" => "搜索功能",
            "topadv" => "置顶广告",
            "weladv" => "进群广告",
            "timeadv" => "定时广告",
            "setzdybq" => "设置自定义标签(以小写逗号隔开)",
            "zdywel" => "自定义欢迎",
            "zdytime" => "自定义定时",
            "zdytop" => "自定义置顶",
            "zdyadvkey" => "自定义广告频闭",
            "deletegroup" => "删除群组",
            "updategroup" => "更新群组",
            "deletesuccess" => "删除成功!",
            "nonextpage" => "没有下一页了",
            "thisonepage" => "已经是第一页了",
            
        ];
        return $arr;
    }
    
}