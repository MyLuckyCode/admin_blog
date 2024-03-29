<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——历史文章</title>
	
	{$Style}

</head>
<body>
	
<div class="title">	
	<div class="titleView">
		<h3>查看历史文章</h3>
<!-- 		<span @click="goShow">返回文章列表</span> -->
	</div>
</div>



	<div class="form">
		<div class="name">
			<span>标　题：</span> <el-input placeholder="标题" size="small" style="width:350px;" v-model="form.title" show-word-limit maxlength="50"></el-input>
		</div>
		<div class="nav">
			<span>导　航：</span>
			<el-radio-group v-model="form.nav">
				{foreach from=$findAllNav item=value key=key}
			    	<el-radio :label="{$key}">{$value}</el-radio>
				{/foreach}
			
			</el-radio-group>
		</div>
		<div class="label">
			<span>标　签：</span>
			<el-checkbox-group v-model="form.label">
			    {foreach from=$findAllLabel item=value key=key}
			    	<el-checkbox label="{$key}">{$value}</el-checkbox>
			    {/foreach}
			</el-checkbox-group>
		</div>
		<div class="keyword">
			<span>关键字：</span> <el-input style="width:400px;" placeholder="关键字，用 , 隔开，用于搜索" type="textarea" :rows="2" v-model="form.keyword" show-word-limit maxlength="50"></el-input>
		</div>
		<div class="info">
			<span>简　介：</span> <el-input style="width:450px;" placeholder="文章简介，默认获取文章前150位" type="textarea" :rows="4" v-model="form.info" show-word-limit maxlength="150"></el-input>
		</div>
		<div class="pic">
			<span>封　面：</span> 
			<div class="face">
				<i class="iconfont iconadd" v-if="articleFaceUrl==''"></i>
				<span v-if="articleFaceUrl==''">选择图片</span>
				<img :src="articleFaceUrl" v-if="articleFaceUrl!=''" alt="" class="face-img">
				<div class="select">
					<span>从本地选择</span>
					<span>从图库选择</span>
				</div>
			</div>
			<span style="padding-left:15px;">建议图片尺寸为 225*150</span>
		</div>
		<div class="content">
			
		</div>
		<div class="flagComment">
			<span>评　论：</span>
			<el-radio-group v-model="form.flagComment">
			    {foreach from=$comment item=value key=key}
			    	<el-radio :label="{$key}">{$value}</el-radio>
				{/foreach}
			</el-radio-group>
		</div>
		<div class="source">
			<span>来　源：</span>
			<el-radio-group v-model="form.source" class="radio">
			    {foreach from=$source item=value key=key}
			    	<el-radio :label="{$key}">{$value}</el-radio>
				{/foreach}
			</el-radio-group>
			<el-input placeholder="管理员或转载网站" size="small" class="input" v-model="form.author" show-word-limit maxlength="10"></el-input>
		</div>
		<div class="readCount">
			<span>阅读量：</span>
			<el-input placeholder="" style="width:100px;" v-model="form.readCount" size="mini" show-word-limit maxlength="4"></el-input>
		</div>
		<div class="fabulous">
			<span>点赞量：</span>
			<el-input placeholder="" style="width:100px;" v-model="form.fabulous" size="mini" show-word-limit maxlength="4"></el-input>
		</div>
		<div class="disabled">
			<span>启　用：</span>
			<el-switch
				v-model="form.disabled">
			</el-switch>
		</div>
	</div>



<script type="text/javascript" src="./view/admin/js/wangEditor.js"></script>
{$Script}



</body>
</html>