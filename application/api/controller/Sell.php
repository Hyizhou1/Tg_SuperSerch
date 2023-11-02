<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\model\Group;
use think\Db;
use think\exception\PDOException;

class Sell extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    //记录客户访问时间以及访问的域名,客户重新搭建后依旧可以获取相关数据
    public function index(){
        if($this->request->isPost()){
            Db::startTrans();
            $sell = new \app\admin\model\Sell();
            $url = $this->request->post("url");
            if($url == null){
                $this->error(__("musterror"));
            }
            try {
                $arr = [
                    "url" => $url,
                    "addtime" => datetime(time()),
                    "apiurl" => $url."/api/sell/getgroup.html",
                ];
                $data = $sell->insertGetId($arr);
                Db::commit();
                if ($data) {
                    $this->success(__("writesuccess"), ["id" => $data]);
                }
            }catch(PDOException $e){
                $data = $sell->where(["url"=>$url])->update(["updatetime"=>time()]);
                Db::commit();
                if ($data) {
                    $this->success(__("updatesuccess"), ["id" => $data]);
                }
            }
        }else{
            $this->error(__("request"));
        }
    }
    //提供群组采集
    public function getgroup($page = 1){
        if($this->request->isPost()) {
            $number = $this->request->post("number");
            $group = new Group();
            $data = $group->field("tggroup_id,group_username,group_nick,group_content,group_count")->paginate($number);
            $this->success(__("getdatasuccess"),$data->toArray());
        }else{
            $this->error(__("request"));
        }
    }
    //获取售出列表
    public function get_sell_list(){
        $sell = new \app\common\model\Sell();
        $data = $sell->field("apiurl")->select();
        $this->success(__("getsellsuccess"),$data);
    }

    //关键词监控
    public function monitor(){
        if($this->request->isPost()){
            $key = $this->request->post("key");   //搜索关键词
            $member = $this->request->post("member"); //搜索者TGid
            $username = $this->request->post("username"); //搜索者用户名
            $nick = $this->request->post("nick");  //搜索者昵称
            $string = $this->request->post("string"); //说明
            $this->success(__("seachinfow"));
        }
    }
}