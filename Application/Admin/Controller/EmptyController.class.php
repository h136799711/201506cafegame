<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Admin\Controller;
use Common\Controller\BaseController;

class EmptyController extends BaseController{
    public function index(){
		$this->assign("tip","您到了一个未知领域！");
		$this->display();
    }
	
}

    