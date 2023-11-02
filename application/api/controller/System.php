<?php

namespace app\api\controller;

use app\common\controller\Api;

class System extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    //获取系统配置
    public function getconfig(){
        $this->success(__("getdatasuccess"),config("site"));
    }
}