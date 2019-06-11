<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——用户</title>
	{$Style}
</head>
<body>



<div class="title">	
	<div class="titleView">
		<h3>用户管理</h3>
	</div>
</div>

<div class="content">

	<div class="list">
		<div class="mainWrap">
			<div class="tableHeader">
				<div class="tableItem-1 tableItem">编号</div>
				<div class="tableItem-2 tableItem">邮箱</div>
				<div class="tableItem-3 tableItem">头像</div>
				<div class="tableItem-4 tableItem">注册时间</div>
			</div>
			<div class="tableBody">
				{foreach from=$findAll item=value key=key}
				<div class="tableBodyItem">
					<div class="tableItem-1 tableItem">{$key}</div>
					<div class="tableItem-2 tableItem">{$value->email}</div>
					<div class="tableItem-3 tableItem">
						<img src="./face/{$value->face}" alt="">
					</div>
					<div class="tableItem-4 tableItem" title="{$value->date}">{$value->smallDate}</div>
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