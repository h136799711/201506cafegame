<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2016 杭州博也网络科技, http://www.itboye.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------

/**
 * 是否使用移动设备访问
 * @return true:是 false:否
 */
function isMobile() {

	vendor("MobileDetect.Mobile_Detect");
	$mobileDetect = new \Mobile_Detect();
	return $mobileDetect -> isMobile();
}

/**
 * 获取主题样式
 */
function getTheme() {

	if (isMobile()) {
		return "mobile";
	}

	return "mobile";
}

function make_coupon_card($uid) {
	$code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$rand = $code[rand(0, 25)] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
	for ($a = md5($rand, true), $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV', $d = '', $f = 0; $f < 8; $g = ord($a[$f]), $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F], $f++);
	
	return $d;
}
