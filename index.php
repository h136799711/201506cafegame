<?php
// .-----------------------------------------------------------------------------------
// | 
// | WE TRY THE BEST WAY
// | Site: http://www.gooraye.net
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2012-2014, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

define('BOYE_SYS_NAME',true);

// 是否调试模式
define('APP_DEBUG',true);

// 运行时文件
define("APP_PATH","./Application/");

require_once(APP_PATH.'/Common/Conf/appmeta.php');

define('HTML_PATH',      './Html/'); // 应用静态目录

// 框架目录
define("THINK_PATH",realpath("./Core/").'/');

// 运行时文件
define("RUNTIME_PATH","./Runtime/");

// 第三方类库目录
//define("VENDOR_PATH","./Vendor/");

// 加载
require "./Core/ThinkPHP.php";