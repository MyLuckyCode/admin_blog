<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——评论</title>
	{$Style}
</head>
<body>



<div class="title">	
	<div class="titleView">
		<h3>全部留言</h3>
		<span>可根据评论内容进行删除</span>
	</div>
</div>

<div class="content">
	

	<div class="list">
		<div class="mainWrap">
			<div class="tableHeader">
				<div class="tableItem-1 tableItem">编号</div>
				<div class="tableItem-2 tableItem">评论内容</div>
				<div class="tableItem-3 tableItem">邮箱</div>
				<div class="tableItem-4 tableItem">昵称</div>
				
				<div class="tableItem-5 tableItem">文章标题</div>
				<div class="tableItem-6 tableItem">评论时间</div>
				<div class="tableItem-7 tableItem">操作</div>
				<div class="tableItem-8 tableItem">ip</div>
				<div class="tableItem-9 tableItem">地址</div>
			</div>
			<div class="tableBody">
				{foreach from=$findAll item=value key=key}
				<div class="tableBodyItem">
					<div class="tableItem-1 tableItem">{$key}</div>
					<div class="tableItem-2 tableItem">{$value->content}</div>
					<div class="tableItem-3 tableItem">{$value->email}</div>
					<div class="tableItem-4 tableItem">
						{$value->name}
					</div>
					
					<div class="tableItem-5 tableItem">{$value->content_id}</div>
					<div class="tableItem-6 tableItem" title="{$value->date}">{$value->smallDate}</div>
					<div class="tableItem-7 tableItem">
						<div class="btn">
							<!-- <a href="?a=brand&m=update&id={$value->id}&page={$pageCurrent}" class="edit">修改</a> -->
							<a href="javascript:;" class="delete" @click="deleteBrand({$value->id})">删除</a>
						</div>
					</div>
					<div class="tableItem-8 tableItem">
						{if isset($value->user_ip) && $value->user_ip!=''}
							{$value->user_ip}
						{/if}
					</div>
					<div class="tableItem-9 tableItem">
						{if isset($value->url) && $value->url!=''}
							<a href="{$value->url}">{$value->url}</a>
						{/if}
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