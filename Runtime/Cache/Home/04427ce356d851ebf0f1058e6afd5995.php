<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo ((isset($meta_title) && ($meta_title !== ""))?($meta_title):'标题'); ?></title>
		<meta name="keywords" content="<?php echo ((isset($seo["keywords"]) && ($seo["keywords"] !== ""))?($seo["keywords"]):" "); ?>" />
		<meta name="description" content="<?php echo ((isset($seo["description"]) && ($seo["description"] !== ""))?($seo["description"]):" "); ?>" />
		<meta name="author" content="ITBOYE" />
	    <meta content="yes" name="apple-mobile-web-app-capable" />
	    <meta content="yes" name="apple-touch-fullscreen" />
	    <meta content="telephone=no,email=no" name="format-detection" />
	    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
		
	

	</head>
	
	<body class="theme-default">
		
		
	
	<div class="cafegame">
		
		cafegame
		
	</div>
	

		
		
		<footer data-am-widget="footer" class="am-footer am-footer-default" data-am-footer="{  }">
	<div class="am-footer-switch">
	</div>
	<div class="am-footer-miscs ">
		<p>{__RUNTIME__}</p>
	</div>
</footer>

<div data-am-widget="gotop" class="am-gotop am-gotop-fixed">
	<a href="#top" title="回到顶部">
		<span class="am-gotop-title">顶部</span>
		<i class="am-gotop-icon am-icon-chevron-up"></i>
	</a>
</div>
		
		<script type="text/javascript" data-main="index" src="/github/201506cafegame/Public/amdcdn/require/2.1.18/require.js"></script>
		<script type="text/javascript">
			requirejs.config({
			   urlArgs: "bust=" +  (new Date()).getTime(),
			  // 别名配置
			  alias: {
			    'jquery': '/github/201506cafegame/Public/cdn/jquery/1.11.0/jquery.min'
			  },
			
			  // 路径配置
			  paths: [
			  	window.$ || window.jQuery ? '' :'jquery',
			  ],
//			  },
			
			  // 变量配置
			  vars: {
			    'locale': 'zh-cn'
			  },
			
			  // 映射配置
			  map: [
                [ /^(\.(?:css|js))(?:.*)$/i, '$1?1433691250' ]
			  ],
			
			  // 预加载项
			  preload: [
			  ],
			
			  // 调试模式
			  debug: true,
			
			  // Sea.js 的基础路径
			  base: '/github/201506cafegame/Public/Seajs/app.home/',
				
			  // 文件编码
			  charset: 'utf-8'
			  
			});
		</script>
		
		
		<script type="text/javascript" src="/github/201506cafegame/Public/requirejs/app.home/index.js" >
</script>
	

	</body>

</html>