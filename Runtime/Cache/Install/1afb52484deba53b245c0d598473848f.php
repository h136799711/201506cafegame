<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>系统安装</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="/github/201506cafegame/Public/cdn/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="/github/201506cafegame/Public/Install/css/install.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="/github/201506cafegame/Public/cdn/html5shiv/3.7.2/html5shiv.min.js"></script>
        <![endif]-->
        
        <script src="/github/201506cafegame/Public/cdn/jquery/1.11.0/jquery.min.js"></script>
        <script src="/github/201506cafegame/Public/cdn/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </head>
	
	
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <!-- Navbar 
        ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
        		<div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">测评系统</a>
		    </div>
		    <div class="collapse navbar-collapse" id="navbar-collapse">
			     <ul class="nav navbar-nav">
	            		
    <li class="active"><a href="javascript:;">安装协议</a></li>
    <li class="active"><a href="javascript:;">环境检测</a></li>
    <li><a href="javascript:;">创建数据库</a></li>
    <li><a href="javascript:;">安装</a></li>
    <li><a href="javascript:;">完成</a></li>

	            	</ul>
            </div>
        </div>

        <div class="jumbotron masthead">
            <div class="container">
                
    <h1>环境检测</h1>
    <table class="table">
        <caption><h2>运行环境检查</h2></caption>
        <thead>
            <tr>
                <th>项目</th>
                <th>所需配置</th>
                <th>当前配置</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($env)): $i = 0; $__LIST__ = $env;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($item[0]); ?></td>
                    <td><?php echo ($item[1]); ?></td>
                    <td><i class="ico-<?php echo ($item[4]); ?>">&nbsp;</i><?php echo ($item[3]); ?></td>       
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
	<?php if(isset($dirfile)): ?><table class="table">
        <caption><h2>目录、文件权限检查</h2></caption>
        <thead>
            <tr>
                <th>目录/文件</th>
                <th>所需状态</th>
                <th>当前状态</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($dirfile)): $i = 0; $__LIST__ = $dirfile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($item[3]); ?></td>
                    <td><i class="ico-success">&nbsp;</i>可写</td>
                    <td><i class="ico-<?php echo ($item[2]); ?>">&nbsp;</i><?php echo ($item[1]); ?></td>   
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table><?php endif; ?>
    <table class="table">
        <caption><h2>函数依赖性检查</h2></caption>
        <thead>
            <tr>
                <th>函数名称</th>
                <th>检查结果</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($func)): $i = 0; $__LIST__ = $func;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($item[0]); ?>()</td>
                    <td><i class="ico-<?php echo ($item[2]); ?>">&nbsp;</i><?php echo ($item[1]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>

            </div>
        </div>


        <!-- Footer
        ================================================== -->
        <footer class="footer navbar-fixed-bottom">
            <div class="container">
                <div>
                	
    <a class="btn btn-success btn-large" href="<?php echo U('Index/index');?>">上一步</a>
    <a class="btn btn-primary btn-large" href="<?php echo U('Install/step2');?>">下一步</a>

                </div>
            </div>
        </footer>
    </body>
</html>