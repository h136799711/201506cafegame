<?php
return array(
	'SESSION_PREFIX'=>'HOME',//Home前缀,不与后台共通
	
	'SHOW_PAGE_TRACE'=>false,
    
	'DEFAULT_THEME'=>"default",
	
	'TMPL_PARSE_STRING'  =>array(
     	'__CDN__' => __ROOT__.'/Public/cdn', // 更改默认的/Public 替换规则
		'__JS__'     => __ROOT__.'/Public/'.MODULE_NAME.'/js', // 增加新的JS类库路径替换规则
     	'__CSS__'     => __ROOT__.'/Public/'.MODULE_NAME.'/css', // 增加新的JS类库路径替换规则
     	'__IMG__'     => __ROOT__.'/Public/'.MODULE_NAME.'/imgs', // 增加新的JS类库路径替换规则	
     
	),	
	
	'HTML_CACHE_ON'     =>    false, // 开启静态缓存
	'HTML_CACHE_TIME'   =>    864000,   // 全局静态缓存有效期（秒） ,默认10天
	'HTML_FILE_SUFFIX'  =>    '.html', // 设置静态缓存文件后缀
	'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
     	'Reporter:view'=>array('Home/Reporter/view/{$_GET.eval_type}_{$_GET.id}_{$_SERVER.REQUEST_URI|md5}','1296000')
	)
	,
	'CAFEGAME_TOKEN'=>'modwvbtg1433857632',//咖啡token
	'COUPONS_USE_PWD'=>'hebidu',//消费密码
);