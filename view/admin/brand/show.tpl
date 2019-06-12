<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——轮播器</title>
	{$Style}
</head>
<body>



<div class="title">	
	<div class="titleView">
		<h3>首页轮播器</h3>
		<span @click="goAdd">添加brand</span>
	</div>
</div>

<div class="content">
	
	<div class="show">
		{foreach from=$findAllDisabled item=value key=key}
			<div class="item">
				<img src="?a=images&uniqueId={$value->imgUrl}" alt="">
				<div class="info">
					<span>{$value->title}</span>
					<span>{$value->target}</span>
				</div>
			</div>
		{/foreach}
		

	</div>

	<div class="list">
		<strong class="title">全部内容</strong>
		<div class="mainWrap">
			<div class="tableHeader">
				<div class="tableItem-1 tableItem">编号</div>
				<div class="tableItem-2 tableItem">标题</div>
				<div class="tableItem-3 tableItem">目标</div>
				<div class="tableItem-4 tableItem">图片</div>
				<div class="tableItem-5 tableItem">启用</div>
				<div class="tableItem-6 tableItem">创建时间</div>
				<div class="tableItem-7 tableItem">操作</div>
			</div>
			<div class="tableBody">
				{foreach from=$findAll item=value key=key}
				<div class="tableBodyItem">
					<div class="tableItem-1 tableItem">{$key}</div>
					<div class="tableItem-2 tableItem" title="{$value->title}">{$value->title}</div>
					<div class="tableItem-3 tableItem" title="{$value->target}">{$value->target}</div>
					<div class="tableItem-4 tableItem">
						<img src="?a=images&uniqueId={$value->imgUrl}" alt="">
					</div>
					<div class="tableItem-5 tableItem">
						{if $value->disabled==1}
							<span style="color:green;">启用</span>
						{else}
							<span style="color:red;">禁用</span>
						{/if}
					</div>
					<div class="tableItem-6 tableItem" title="{$value->date}">{$value->smallDate}</div>
					<div class="tableItem-7 tableItem">
						<div class="btn">
							<a href="?a=brand&m=update&id={$value->id}&page={$pageCurrent}" class="edit">修改</a>
							<a href="javascript:;" class="delete" @click="deleteBrand({$value->id})">删除</a>
						</div>
					</div>
				</div>
				{/foreach}
			</div>
			<div class="page">
				<el-pagination
				    @current-change="handleCurrentChange"
				    :current-page="{$pageCurrent}"
				    :page-size="{$pageSize}"
				    layout="prev, pager, next, jumper"
				    :total="{$total}">
				</el-pagination>
			</div>
			

		</div>
	</div>

</div>


{$Script}
</body>
</html>