<?php

namespace app\api\controller;

use app\common\controller\Api;

class Advtype extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    public function index(){
        $advtype = new \app\common\model\Advtype();
        $resdata = $advtype->select();
        $this->success(__("advtypelist"),$resdata);
    }
    
    public function typeinfo($advid){
        $advtype = new \app\common\model\Advtype();
        $resdata = $advtype->where(["advtype_id"=>$advid])->find();
        $this->success(__("advtypelist"),$resdata);
    }
    
}