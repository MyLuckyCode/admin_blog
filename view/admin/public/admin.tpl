<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title>后台管理</title>
	<link rel="stylesheet" href="view/admin/style/admin.css">
	<link rel="stylesheet" href="view/admin/style/basic.css">
	<link rel="stylesheet" href="//at.alicdn.com/t/font_1173901_1wxndzk73f9.css">
</head>
<body>


<div class="body">

	<div class="left">
		<div class="logo">
			<a href="###">
				<img src="./view/admin/images/logo2.png" alt="" />
			</a>
		</div>
		<div class="side-menu">
			<ul>
				<li><a href="?a=nav" target="in"><i class="iconfont iconfont-20 iconnavigation"></i>导航管理</a></li>
				<li><a href="?a=label" target="in"><i class="iconfont iconfont-20 iconiconset0169"></i>标签管理</a></li>
				<li><a href="?a=article" target="in"><i class="iconfont iconfont-20 iconwenzhang"></i>文章管理</a></li>
				<li><a href="?a=comment" target="in"><i class="iconfont iconfont-20 iconcomment1"></i>评论管理</a></li>
				<li><a href="?a=time" target="in"><i class="iconfont iconfont-20 icontime2"></i>时光管理</a></li>
				<li><a href="?a=brand" target="in"><i class="iconfont iconfont-20 iconpinpaibiaozhibrand2"></i>横幅管理</a></li>
				<li><a href="?a=works" target="in"><i class="iconfont iconfont-20 iconzuopinzhanshi"></i>个人案例</a></li>
				<li><a href="?a=picture" target="in"><i class="iconfont iconfont-20 icontupian"></i>图片管理</a></li>
				<li><a href="?a=pattern" target="in"><i class="iconfont iconfont-20 iconxtgl6"></i>样式管理</a></li>
				<li><a href="?a=user" target="in"><i class="iconfont iconfont-20 iconyonghu"></i>用户管理</a></li>
				<!-- <li><a href="?a=setting" target="in"><i class="iconfont iconfont-20 iconsettings-"></i>系统设置</a></li> -->
			</ul>
		</div>
	</div>

	<div class="right">
		<div class="right-header">
			<h2>网站后台管理系统</h2>
			<div class="user">
				<span>
					<i class="iconfont iconfont-20 iconadmin"></i>
					当前用户：
				</span>
				<div class="admin" >{$tpl.cookie.user}
					<i class="iconfont iconfont-20 iconicon-xiasanjiao"></i>
					<div class="userOperation">
						<ul>
							<li><a href="">修改密码</a></li>
							<li><a href="?a=login&m=outlogin">退出登录</a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
		<div class="main">
			<iframe name="in" frameborder="0"></iframe>
		</div>
	</div>

</div>

<script type="text/javascript" src="view/admin/js/admin.js" ></script>

</body>
</html>