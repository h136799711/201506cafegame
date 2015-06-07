<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY 杭州博也网络科技有限公司
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2016, http://www.itboye.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;

/*
 * 官网首页
 */
class IndexController extends HomeController {
	
	protected function _initialize(){
		parent::_initialize();
		
	}
	
	/**
	 * 首页
	 */
	public function index(){
		
		$this->theme("mobile")->display();
	}
	
	
}

