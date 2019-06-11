<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——作品</title>
	{$Style}
</head>
<body>



<div class="title">	
	<div class="titleView">
		<h3>作品管理</h3>
		<span @click="goAdd">添加作品</span>
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
				<div class="tableItem-4 tableItem">封面</div>
				<div class="tableItem-5 tableItem">介绍</div>
				<div class="tableItem-6 tableItem">启用</div>
				<div class="tableItem-7 tableItem">创建时间</div>
				<div class="tableItem-8 tableItem">操作</div>
			</div>
			<div class="tableBody">
				{foreach from=$findAll item=value key=key}
				<div class="tableBodyItem">
					<div class="tableItem-1 tableItem">{$key}</div>
					<div class="tableItem-2 tableItem">{$value->title}</div>
					<div class="tableItem-3 tableItem">{$value->target}</div>
					<div class="tableItem-4 tableItem">
						<img src="?a=images&uniqueId={$value->imgUrl}" alt="">
					</div>
					<div class="tableItem-5 tableItem">
						{if isset($value->info)}
							{$value->info}
						{/if}
					</div>
					<div class="tableItem-6 tableItem">
						{if $value->disabled==1}
							<span style="color:green;">启用</span>
						{else}
							<span style="color:red;">禁用</span>
						{/if}
					</div>
					<div class="tableItem-7 tableItem" title="{$value->date}">{$value->smallDate}</div>
					<div class="tableItem-8 tableItem">
						<div class="btn">
							<a href="?a=works&m=update&id={$value->id}&page={$pageCurrent}" class="edit">修改</a>
							<a href="javascript:;" class="delete" @click="deleteWorks({$value->id})">删除</a>
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