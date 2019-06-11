<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——系统设置</title>
	{$Style}
</head>
<body>



<div class="title">	
	<div class="titleView">
		<h3>系统设置</h3>
		<span>修改后24小时生效</span>
	</div>
</div>

<div class="content">	
	
	<div class="form">
		<strong>前端设置</strong>

		

		<div class="name">
			<span class="desc">网站标题：</span> <el-input style="width:250px" placeholder="标题，用于鼠标经过时显示" v-model="title" show-word-limit maxlength="10" size="mini"></el-input>
		</div>

		<div class="group-switch">
			<div class="switch">
				<span class="desc">评论功能：</span>
				<el-switch
				  	v-model="disabled">
				</el-switch>
				<span class="ps">关闭评论后，所有的文章将不能评论</span>
			</div>

			<div class="switch">
				<span class="desc">前台缓存：</span>
				<el-switch
				  	v-model="disabled">
				</el-switch>
				<span class="ps">轮播图和侧边栏的内容缓存，使用cookie，当天24点失效</span>
			</div>

		</div>

	</div>

	<div class="total">
		<strong>站点统计</strong>
		<div class="left">
			<p>标签：115个</p>
			<p>文章：115</p>
			<p>访问量：115</p>
		</div>
		<div class="right">
			<p>分类：115</p>
			<p>评论：115</p>
			<p>最近更新：115</p>
		</div>
	</div>


</div>


{$Script}
</body>
</html>