<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Db;
use think\exception\PDOException;

class Group extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    //索引群组，如果关键词中没有该群组则模糊查询群组
    public function index($page = 1){
        if($this->request->isPost()){
            $key = $this->request->post("key");
            $group = new \app\common\model\Group();
            $keyword = new \app\common\model\Keyword();
            $data = $keyword->where(["title"=>$key])->find();
            if($data){
                $keyword->where(["title"=>$key])->setInc("sea",1);
                $res = $group->join('weight','fa_weight.group_id = fa_group.group_id')->where(["fa_weight.keyword_id" => $data->keyword_id])->order("fa_weight.payadv desc")->order("fa_weight.sort desc")->paginate(20);
            }else{
                $res = $group->whereLike("group_nick","%".$key."%")->order("group_id desc")->paginate(20);
            }
            $this->success(__("getdatasuccess"),$res->toArray());
        }else{
            $this->error(__("request"));
        }
    }
    //查询某个群组
    public function getgroup(){
        if($this->request->isPost()) {
            $groupid = $this->request->post("groupid");
            $group = new \app\common\model\Group();
            $data = $group->where(["tggroup_id" => $groupid])->find();
            if ($data) {
                $this->success(__("getdatasuccess"), $data->toArray());
            }else{
                $this->error(__("groupnull"));
            }
        }else{
            $this->error(__("request"));
        }
    }
    //写入群组信息
    public function writegroup($iscj = 1){
        if($this->request->isPost()) {
            $userid = $this->request->post("userid");
            $member = new \app\admin\model\Member();
            $data = $member->where(["tg_id"=>$userid])->find();
            if(!$data){
                $this->error(__("memberdatanull"));
            }
            $arr = [
                "member_id"      => $data->member,                                 //用户id
                "tggroup_id"     => $this->request->post("groupid"),            //群组id
                "group_username" => $this->request->post("username"),           //群组用户名
                "group_nick"     => filter_Emoji($this->request->post("nick")),               //群组名称
                "group_content"  => filter_Emoji($this->request->post("content")),            //群组介绍
                "group_count"    => $this->request->post("count"),              //群组人数
                "group_type"    => $this->request->post("type"),              //群组类型
                "group_img"    => $this->request->post("img"),              //群组头像
                "iscj"         => $iscj,
                "addtime"     => date("Y-m-d H:i:s",time()),
            ];
            Db::startTrans();
            $group = new \app\common\model\Group();
            try {
                $res = $group->insertGetId($arr);
                Db::commit();
                if ($res) {
                    $this->success(__("crategroupsuccess"), ["data" => $res]);
                } else {
                    $this->error(__("crategrouperror"));
                }
            }catch(PDOException $e){
                Db::rollback();
                $this->error(__("groupnullerror"));
            }
        }else{
            $this->error(__("request"));
        }
    }
    //获取用户下所有群组列表
    public function getusergroup(){
        if($this->request->isPost()) {
            $tgid = $this->request->post("tgid");
            $member = new \app\admin\model\Member();
            $memberInfo = $member->where(["tg_id"=>$tgid])->find();
            $group = new \app\common\model\Group();
            $data = $group->where(["member_id" => $memberInfo->member])->paginate(5);
            if ($data) {
                $this->success(__("getdatasuccess"), $data);
            }else{
                $this->error(__("groupnull"));
            }
        }else{
            $this->error(__("request"));
        }
    }
    
    //获取所有不是采集的群组
    public function getiscj($iscj = 0){
        $group = new \app\common\model\Group();
        $data = $group->where(["iscj" => $iscj,"timeadv" => 2])->paginate(20);
        $this->success(__("getdatasuccess"),$data);
    }
    
        //获取不是采集的群组并且开启置顶广告的群组
    public function gettopadv($page = 1){
        $group = new \app\common\model\Group();
        $data = $group->where(["iscj" => 0,"istop" => 1])->paginate(20);
        $this->success(__("getdatasuccess"),$data);
    }
    
    //获取还未处理的群组,一次只取1个
    public function gethenlno(){
        $group = new \app\common\model\Group();
        $data = $group->where(["handle" => 0])->find();
        $this->success(__("getdatasuccess"),$data);
    }
    
    //设置该群组处理完成
    public function henlok($group_id){
        $data = Db::name("group")->where(["group_id"=>$group_id])->update(["handle" => 1]);
        $this->success(__("getdatasuccess"),$data);
    }
    
    //修改内容配置
    public function edit(){
        if($this->request->isPost()){
            $group_id = $this->request->post("groupid");
            
            $text = $this->request->post("text");
            $res = Db::name("group")->where(["tggroup_id"=>$group_id])->find();
            if($res[$text] == 1){
                $k = 0;
            }else{
                $k = 1;
            }
            Db::name("group")->where(["tggroup_id"=>$group_id])->update([$text=>$k]);
            $this->success();
        }
    }
    
    //获取我的关键词
    public function getkeyword(){
        if($this->request->isPost()){
            $group_id = $this->request->post("gid");
            $ginfo = Db::name("group")->where("tggroup_id",$group_id)->find();
            $res = Db::table("fa_weight")->join("fa_keyword","fa_keyword.keyword_id = fa_weight.keyword_id")->where(["fa_weight.group_id"=>$ginfo["group_id"]])->select();
            $this->success("",$res);
        }
    }
    
    //删除群组
    public function delete(){
        if($this->request->isPost()){
            $group_id = $this->request->post("gid");
            Db::name("group")->where("tggroup_id",$group_id)->delete();
            $this->success();
        }
    }
    
    //获取定时任务信息
    public function gettime($groupid = null){
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/time/".$groupid.".txt")){
            return file_get_contents($_SERVER['DOCUMENT_ROOT']."/time/".$groupid.".txt");
        }else{
            $arr = [
                "entertype" => "",
                "entertext" => "",
                "fileurl" => "",
                "button" => ""
            ];
            $this->success("",$arr);
        }
    }
    
    //设置定时任务信息
    public function settime($groupid){
        if($this->request->isPost()){
            $arr = [
                "entertype" => $this->request->post("entertype"),
                "entertext" => $this->request->post("entertext"),
                "fileurl" => $this->request->post("fileurl"),
                "button" => $this->request->post("button")
            ];
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/time/".$groupid.".txt",json_encode($arr,JSON_UNESCAPED_UNICODE));
            $this->success("保存成功");
        }
    }

    //获取置顶广告
    public function gettopadvl($groupid){
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/topadv/".$groupid.".txt")){
            return file_get_contents($_SERVER['DOCUMENT_ROOT']."/topadv/".$groupid.".txt");
        }else{
            $arr = [
                "entertype" => "",
                "entertext" => "",
                "fileurl" => "",
                "button" => ""
            ];
            $this->success("",$arr);
        }
    }
    
    //设置置顶广告
    public function settopadv($groupid){
        if($this->request->isPost()){
            $arr = [
                "entertype" => $this->request->post("entertype"),
                "entertext" => $this->request->post("entertext"),
                "fileurl" => $this->request->post("fileurl"),
                "button" => $this->request->post("button")
            ];
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/topadv/".$groupid.".txt",json_encode($arr,JSON_UNESCAPED_UNICODE));
            $this->success("保存成功");
        }
    }
    
    //设置进群欢迎
    public function setwelcome($groupid){
        if($this->request->isPost()){
            $arr = [
                "entertype" => $this->request->post("entertype"),
                "entertext" => $this->request->post("entertext"),
                "fileurl" => $this->request->post("fileurl"),
                "button" => $this->request->post("button")
            ];
            Db::name("group")->where("tggroup_id",$groupid)->update($arr);
            $this->success("保存成功");
        }
    }
    
}