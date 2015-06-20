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
	private $subscribe = 0;
	private $userinfo = null;
	private $wxapi = null;
	private $wxaccount = null;
	private $openid = '';
	private $referrer = '';
	
	
	private $conditionAmount = 350;// 达到条件毫升数
	private $genMinML = 50;// 最小倒入毫升数
	private $genMaxML = 70;// 最大倒入毫升数
	private $maxCntEachDay = 1;// 每人一天3次
	
	protected function _initialize() {
		parent::_initialize();
		$this -> token = C("CAFEGAME_TOKEN");

		C('SHOW_PAGE_TRACE', false);
		//设置不显示trace
		$debug = false;
		$this -> refreshWxaccount();
		$referrer = I('get.referrer', 0);
		$shareImg = C("SITE_URL") . "/Public/Home/imgs/share.png";
		
		if ($debug) {
			
			$this->userinfo = array(
				'id'=>70,
				'avatar'=>C("SITE_URL") . "/Public/Home/imgs/share.png",
				'nickname'=>'nickname',
				'openid'=>'oqqbAtwICnxr8XTse-pHcjvi9BCE',
				'current_coffee'=>301,
				'coupons'=>'6PRETI79',
				'coupons_status'=>1,
			);
			
			$this-> referrer = array(
			);
//			$this-> referrer = array(
//				'id'=>0,
//				'avatar'=>C("SITE_URL") . "/Public/Home/imgs/share.png",
//				'nickname'=>'referrer',
//				'openid'=>'oqqbAt8x7G1dxJJcR207Gy7exHjk',
//				'current_coffee'=>100,
//				'coupons'=>'6PRETI79',
//				'coupons_status'=>1,
//			);
			$this -> assign("userinfo", $this -> userinfo);
			$this -> assign("referrer", $this -> referrer);
			
		} else {

			$url = $this -> getCurrentURL();

			if (!is_null($this -> getWxuser($url))) {
				
				//设置分享链接
				$shareURL = C("SITE_URL") . U('Home/Index/index', array('token' => $this -> token, 'referrer' => $this -> userinfo['id']));

				$this -> assign("shareUrl", $shareURL);
			}
			
			$result = apiCall("Home/Wxuser/getInfo", array( array("id" => $referrer)));
			
			if (!$result['status']) {
				$this -> error($result['info']);
			}
			
			if($referrer == $this->userinfo['id']){
				//自己点自己的推广链接
				$this->referrer = array();
			}else{
				$this->referrer = $result['info'];
			}
		
		}
		
		
		$this -> assign("shareImg", $shareImg);
		//来源人
		$this -> assign("referrer", $this->referrer);
		//		dump($this->wxaccount);
		$this -> assign("wxaccount", $this -> wxaccount);
		$this -> assign("userinfo", $this -> userinfo);
		$this -> assign("token", $this -> token);
		$this->assign("maxAmount",$this->conditionAmount);
	}

	/**
	 * 首页
	 */
	public function index() {
		$this -> assign("meta_title", "免费喝咖啡活动-咖啡陪你武汉光谷天地店");
//		$result = $this->pourcoffee();
//		
//		if(!$result['status']){
//			$this->assign("error",$result['info']);
//		}

		$this->assign("coupons","");
//		dump($this->userinfo);
		if($this->userinfo['current_coffee'] >= $this->conditionAmount){
			if(empty($this->referrer) || $this->referrer['id'] == $this->userinfo['id']){
				//满足条件，则生成优惠券
				if(empty($this->userinfo['coupons'])){
					$this->generateCoupons($this->userinfo['id']);
				}
				
				$this->assign("coupons_status",$this->userinfo['coupons_status']);
				$this->assign("coupons",$this->userinfo['coupons']);
			}
			$expireDate = strtotime("2015-07-05 21:30:00");
			
			if(time() > $expireDate){
				$this->assign("coupons_status",3);//已过期
			}
		}
		$this -> theme("mobile") -> display();
	}
	
	/**
	 * 倒入咖啡
	 */
	public function pour(){
		
		addWeixinLog(I('get.')," pour ");
		$result = $this->pourcoffee();
		
		if($result['status']){
			$this->success($result['info']);
		}
		
		$this->error($result['info']);
		
	}
	
	
	public function useCoupons(){
		addWeixinLog("useCoupons");
		$coupons = I("get.coupons",'');
		$id = $this->userinfo['id'];
		
		$password = I("post.pwd");
		$truePwd =  C('COUPONS_USE_PWD');
		
		if($password != $truePwd){
			$this->error("消费密码错误!");
		}
		
		
		
		$result = apiCall("Home/Wxuser/saveByID", array($id,array('coupons_status'=>2)));
		
		if(!$result['status']){
			$this->error($result['info']);
		}
		
		$this->success("成功消费优惠券!");
	}
	
	
	/**
	 * 列出帮助我的人的信息
	 */
	public function list_helper(){
		$id = $this->userinfo['id'];
		
		$result = apiCall("Home/Cafegame/queryInfo", array($id));
		
		if(!$result['status']){
			$this->error($result['info']);
		}
		$this->assign("meta_title","看看都有谁帮了我!");
		$this->assign("list",$result['info']);
		$this->theme($this->theme)->display();
	}
	
	
	//***********************私有、保护方法
		
	
	/*
	 *
	 * 倒入咖啡
	 */
	private function pourcoffee(){
		
		
		$curuser = $this->userinfo;
		$referrer = $this->referrer;
		$say = I('post.say','');
		
		if($referrer['id'] == $curuser['id']){
			return array('status'=>false,'info'=>"不能帮自己倒!");
		}
		addWeixinLog($referrer,"referrer");
		addWeixinLog($curuser,"curuser");
		
		if(!empty($referrer) && !empty($curuser)){
			$time = strtotime(date("Y-m-d",time()));
			$today = array(array('gt',$time-1),array('lt',$time+24*3600+1)) ;
			//统计当前用户给$referrer投了几票  在今天之内,
			$result = apiCall("Home/Cafegame/count", array(array('uid'=>$referrer['id'],"help_uid"=>$curuser['id'],'create_time'=>$today)));
			
			if(!$result['status']){
				return array('status'=>false,'info'=>$result['info']);
			}
			
			$count = $result['info'];
			if($count >= $this->maxCntEachDay){				
				return array('status'=>false,'info'=>"今天已经给".$referrer['nickname']."倒了".$this->maxCntEachDay."次,请明天再来.");
			}
			
			
			//有来源的情况
			$ml = rand($this->genMinML,$this->genMaxML);
			if(empty($say)){
				$say = $this->randomSay($ml);
			}
			
			$entity = array(
				'uid'=>$referrer['id'],
				'openid'=>$referrer['openid'],
				'help_uid'=>$curuser['id'],
				'help_openid'=>$curuser['openid'],
				'amount'=>$ml,
				'say'=>$say,
				'wxaccount_id'=>$this->wxaccount['id'],
			);
			
			$result = apiCall("Home/Cafegame/add", array($entity));
			
			if($result['status']){
				
				$result=	apiCall("Home/Wxuser/setInc", array(array('id'=>$referrer['id']), "current_coffee", $ml));
				if(!$result['status']){
					LogRecord($result['info'],__FILE__.__LINE__);
				}
				
				$this->generateCoupons($referrer['id']);
				
				return array('status'=>true,'info'=>"成功帮助他人倒入".$ml."毫升!");
			}else{
				return array('status'=>false,'info'=>"倒入失败,请重新试一遍!");
			}
			
		}else{
			//其它情况不能生产
			if(empty($referrer)){
				return array('status'=>false,'info'=>"不能给自己倒!");
			}else{
				return array('status'=>false,'info'=>"未知情况!");
			}
		}
	}
	
	
	/**
	 * 生成优惠券
	 */
	private function generateCoupons($id){
		
		$coupons =  make_coupon_card();
		
		$result = apiCall("Home/Wxuser/saveByID", array($id,array("coupons"=>$coupons)));
		
		if(!$result['status']){
			LogRecord($result['info'],__FILE__.__LINE__);
		}else{
			$this->userinfo['coupons'] = $coupons;
		}
		
	}
	
	
	/**
	 * 随机产生一句话
	 */
	private function randomSay($ml){
		$say_arr = array(
			'什么也不说了!',
			'好基友，不顶你顶谁!',
			'勉勉强强帮你一下下了!',
			'好基友，不顶你顶谁!',
			'什么也不说了!',
		);
		if($ml > 45){
			return "不感谢我吗!";
		}
		
		if($ml < 35){
			return "勉强感谢我一下下吧!";
		}
		
		$ind = rand(0,count($say_arr));
		
		return $say_arr[$ind];
		
	}

	protected function getCurrentURL() {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return $url;
	}

	protected function getWxuser($url) {
		$referrer = I("get.referrer", 0);
		$this -> userinfo = null;
		if (session("?userinfo") && IS_AJAX) {
			$this -> userinfo = session("userinfo");
			$this -> openid = $this -> userinfo['openid'];
		}
		
//		addWeixinLog($this -> userinfo, "userinfo getWxuser");

		if (!is_array($this -> userinfo)) {

			$code = I('get.code', '');
			$state = I('get.state', '');
			if (empty($code) && empty($state)) {

//				$redirect = $this -> wxapi -> getOAuth2BaseURL($url, 'HomeIndexOpenid', 'snsapi_userinfo');
				//需要服务号
								$redirect = $this -> wxapi -> getOAuth2BaseURL($url, 'HomeIndexOpenid');

				redirect($redirect);
			}

			if ($state == 'HomeIndexOpenid') {
				$accessToken = $this -> wxapi -> getOAuth2AccessToken($code);

				$this -> openid = $accessToken['openid'];
				$result = $this -> wxapi -> getBaseUserInfo($accessToken['openid']);

				addWeixinLog($result['info'], "userinfo getBaseUserinfo");
				if ($result['status']) {
					$this -> refreshWxuser($referrer, $result['info']);
				} else {
					$this -> userinfo = null;
				}
			}
		}

		$this -> subscribe = $this -> userinfo['subscribe'];

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
	 * 如果不存在表中，则插入，否则更新信息
	 */
	private function refreshWxuser($referrer, $userinfo) {
		$wxuser = array();
		
		$wxuser['subscribed'] = $userinfo['subscribe'];
		
		addWeixinLog($userinfo,"userinfo = ".date("Y-m-d H:i:s",time()));
		if (!empty($this -> openid) && is_array($this -> wxaccount)) {
			
			$map = array('openid' => $this -> openid, 'wxaccount_id' => $this -> wxaccount['id']);
			addWeixinLog($map,"map = ".date("Y-m-d H:i:s",time()));

			$result = apiCall('Home/Wxuser/getInfo', array($map));
			
			addWeixinLog($result,"wxusergetinfo = ".date("Y-m-d H:i:s",time()));
			if (!$result['status']) {
				LogRecord($result['info'], "[Home/Index/refreshWxuser]" . __LINE__);
				$this -> error($result['info']);
			}

			if (is_array($result['info'])) {
				
				if($userinfo['subscribe'] == 1){
					//更新的时候，只有 [已关注] 才更新数据，[未关注] 只更新关注字段
					$wxuser['nickname'] = $userinfo['nickname'] ? $userinfo['nickname'] : "未知";
					$wxuser['province'] = $userinfo['province'] ? $userinfo['province'] : "";
					$wxuser['country'] = $userinfo['country'] ? $userinfo['country'] : "";
					$wxuser['city'] = $userinfo['city'] ? $userinfo['city'] : "";
					$wxuser['sex'] = $userinfo['sex'] ? $userinfo['sex'] : "";
					$wxuser['avatar'] = $userinfo['headimgurl'] ? $userinfo['headimgurl'] : "";
					$wxuser['subscribe_time'] = $userinfo['subscribe_time'] ? $userinfo['subscribe_time'] : "";
				}
				//更新
				$result = apiCall('Home/Wxuser/save', array($map, $wxuser));
				if (!$result['status'] && $result['info']) {
					//操作失败
					LogRecord($result['info'], "[Home/Index/refreshWxuser]" . __LINE__);
				}

			} else {

				//新增的时候，只有 [已关注] 才更新数据，[未关注] 只更新关注字段
				$wxuser['nickname'] = $userinfo['nickname'] ? $userinfo['nickname'] : "未知";
				$wxuser['province'] = $userinfo['province'] ? $userinfo['province'] : "";
				$wxuser['country'] = $userinfo['country'] ? $userinfo['country'] : "";
				$wxuser['city'] = $userinfo['city'] ? $userinfo['city'] : "";
				$wxuser['sex'] = $userinfo['sex'] ? $userinfo['sex'] : 0;
				$wxuser['avatar'] = $userinfo['headimgurl'] ? $userinfo['headimgurl'] : "#";
				$wxuser['subscribe_time'] = $userinfo['subscribe_time'] ? $userinfo['subscribe_time'] : time();
					
				$wxuser['wxaccount_id'] = intval($this -> wxaccount['id']);
				$wxuser['openid'] = $userinfo['openid'];
				$wxuser['referrer'] = $referrer;
				//插入
				$result = apiCall('Home/Wxuser/add', array($wxuser));
				if (!$result['status']) {
					//操作失败
					LogRecord($result['info'], "[Home/Index/refreshWxuser]" . __LINE__);
					$this -> error($result['info']);
				}
			}

		}

	}

	/**
	 * 检测推荐人是否合法
	 * @param $referrer 推荐人
	 * @param $id 当前用户ID
	 */
	private function checkReferrer($curID, $family) {
		if ($curID == 0) {
			return true;
		}
		if ($curID == $family['wxuserid']) {
			//不能自己推荐自己
			return false;
		}

		return true;
	}

	/**
	 * 刷新
	 */
	private function refreshWxaccount() {
//		addWeixinLog($this -> token, " refreshWxaccount token ");
		$result = apiCall('Weixin/Wxaccount/getInfo', array( array('token' => $this -> token)));
		if ($result['status'] && is_array($result['info'])) {
			$this -> wxaccount = $result['info'];
			$this -> wxapi = new \Common\Api\WeixinApi($this -> wxaccount['appid'], $this -> wxaccount['appsecret']);
		} else {
			exit("公众号信息获取失败，请重试！");
		}
	}

}
