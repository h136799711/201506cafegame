<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY 杭州博也网络科技有限公司
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2016, http://www.itboye.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

class QrcodeController extends HomeController{
	
	
	protected function _initialize() {
		parent::_initialize();
		C('SHOW_PAGE_TRACE', false);
		$this->assign("token",C("CAFEGAME_TOKEN"));
	}
	
	public function index(){
		
		$this->theme($this->theme)->display();
	}
}
