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

	private $token = "";
	private $hasSubscribe = 0;
	private $userinfo = null;
	protected function _initialize() {
		parent::_initialize();
		$this -> token = C("CAFEGAME_TOKEN");

		C('SHOW_PAGE_TRACE', false);//设置不显示trace
//		$this -> refreshWxaccount();
//		$url = $this -> getCurrentURL();
//
//		if (!is_null($this -> getWxuser($url))) {
//
//			if ($this -> hasSubscribe == 0) {
//				//未关注公众号的情况下
//				$referrer = I('referrer', 0);
//				if ($referrer > 0) {
//					addWeixinLog($referrer, "未关注！");
//					//
//				}
//			}
//			//设置分享链接
//			$shareURL = C("SITE_URL") . U('Home/Index/index', array('token' => $this -> token, 'referrer' => $this -> userinfo['id']));
//		
//			$this -> assign("shareUrl", $shareURL);
//		}

		$shareImg = C("SITE_URL") . "/Public/Home/imgs/share.png";
		$this -> assign("shareImg", $shareImg);
			
		$this -> assign("userinfo", $this -> userinfo);

		$this -> assign("token", $this -> token);
	}

	/**
	 * 首页
	 */
	public function index() {
		$this->assign("meta_title","免费喝咖啡活动-咖啡陪你武汉光谷天地店");
		$this -> theme("mobile") -> display();
	}

	protected function getCurrentURL() {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return $url;
	}

	public function getWxuser($url) {

		$this -> userinfo = null;
		if (session("?userinfo")) {
			$this -> userinfo = session("userinfo");
			$this -> openid = $this -> userinfo['openid'];
		}
		addWeixinLog($this->userinfo,"userinfo");
		if (!is_array($this -> userinfo)) {
			
			$code = I('get.code', '');
			$state = I('get.state', '');
			if (empty($code) && empty($state)) {

//				$redirect = $this -> wxapi -> getOAuth2BaseURL($url, 'HomeIndexOpenid', 'snsapi_userinfo');需要服务号
				$redirect = $this -> wxapi -> getOAuth2BaseURL($url, 'HomeIndexOpenid');
				
				redirect($redirect);
			}
			
			if ($state == 'HomeIndexOpenid') {
				$accessToken = $this -> wxapi -> getOAuth2AccessToken($code);

				$this -> openid = $accessToken['openid'];
				$result = $this -> wxapi -> getBaseUserInfo($accessToken['openid']);

				addWeixinLog($result['info'],"userinfo");
				if ($result['status']) {
					$this -> refreshWxuser($result['info']);
				} else {
					$this -> userinfo = null;
				}
			}
		}
		
		$this -> hasSubscribe = $this -> userinfo['subscribed'];
		//每次都重新从数据库中获取
		$map = array('openid' => $this -> openid, 'wxaccount_id' => $this -> wxaccount['id']);
		
		$result = apiCall('Home/Wxuser/getInfo', array($map));
		
		if ($result['status']) {
			$this -> userinfo = $result['info'];
			session("userinfo", $result['info']);
		}

		return $this -> userinfo;
	}

	/**
	 * 刷新粉丝信息
	 */
	private function refreshWxuser($userinfo) {
		$wxuser = array();
		//		$wxuser['wxaccount_id'] = intval($this -> wxaccount['id']);
		$wxuser['nickname'] = $userinfo['nickname'];
		$wxuser['province'] = $userinfo['province'];
		$wxuser['country'] = $userinfo['country'];
		$wxuser['city'] = $userinfo['city'];
		$wxuser['sex'] = $userinfo['sex'];
		$wxuser['avatar'] = $userinfo['headimgurl'];
		$wxuser['subscribe_time'] = $userinfo['subscribe_time'];

		if (!empty($this -> openid) && is_array($this -> wxaccount)) {

			$map = array('openid' => $this -> openid, 'wxaccount_id' => $this -> wxaccount['id']);

			$result = apiCall('Home/Wxuser/save', array($map, $wxuser));

			if (!$result['status']) {
				LogRecord($result['info'], "[Home/Index/refreshWxuser]" . __LINE__);
			} else {
				$result = apiCall('Home/Wxuser/getInfo', array($map));
				if ($result['status']) {
					
					$this -> userinfo = $result['info'];
					session("userinfo", $result['info']);
				}
			}

		}

	}

	/**
	 * 刷新
	 */
	private function refreshWxaccount() {
		addWeixinLog($this->token," refreshWxaccount token ");
		$result = apiCall('Weixin/Wxaccount/getInfo', array( array('token' => $this -> token)));
		if ($result['status'] && is_array($result['info'])) {
			$this -> wxaccount = $result['info'];
			$this -> wxapi = new \Common\Api\WeixinApi($this -> wxaccount['appid'], $this -> wxaccount['appsecret']);
		} else {
			exit("公众号信息获取失败，请重试！");
		}
	}

}
