<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——文章</title>
	{$Style}
</head>
<body>



<div class="title">	
	<div class="titleView">
		<h3>文章列表</h3>
		<span @click="goAdd">新建文章</span>
	</div>
</div>

<div class="FocusToday">
    <div class="top">
        <span class="titles">【今日焦点】</span>{$focusArticle[0]->title}
        <img class="new_icon" src="view/admin/images/new.gif" alt="">
    </div>
    <p class="bottom">
        {$focusArticle[0]->info}
    </p>
</div>


<div class="content">
	
	<div class="list">
		<div class="mainWrap">
			<div class="tableHeader">
				<div class="tableItem-1 tableItem">编号</div>
				<div class="tableItem-2 tableItem">标题</div>
				<div class="tableItem-3 tableItem">类别</div>
				<div class="tableItem-4 tableItem">标签</div>
				<div class="tableItem-5 tableItem">封面</div>
				<div class="tableItem-6 tableItem">点赞量</div>
				<div class="tableItem-7 tableItem">评论量</div>
				<div class="tableItem-8 tableItem">阅读量</div>
				<div class="tableItem-9 tableItem">来源</div>
				<div class="tableItem-10 tableItem">作者</div>
				<div class="tableItem-11 tableItem">显示</div>
				<div class="tableItem-12 tableItem">评论</div>
				<div class="tableItem-13 tableItem">置顶</div>
				<div class="tableItem-14 tableItem">创建时间</div>
				<div class="tableItem-15 tableItem">操作</div>
			</div>
			<div class="tableBody">
				{foreach from=$findAll item=value key=key}
				<div class="tableBodyItem">
					<div class="tableItem-1 tableItem">{$key}</div>
					<div class="tableItem-2 tableItem" title="{$value->title}">{$value->title}</div>
					<div class="tableItem-3 tableItem" title="{$value->NavName}">{$value->NavName}</div>
					<div class="tableItem-4 tableItem" title="{$value->label}">{$value->label}</div>
					<div class="tableItem-5 tableItem">
						<img src="?a=images&uniqueId={$value->face}" alt="">
					</div>
					<div class="tableItem-6 tableItem">{$value->fabulous}</div>
					<div class="tableItem-7 tableItem">{$value->commentCount}</div>
					<div class="tableItem-8 tableItem">{$value->readCount}</div>
					<div class="tableItem-9 tableItem">
						{if $value->source==1}
							<span style="color:#e4460f;">原创</span>
						{else}
							<span style="color:blue;">转载</span>
						{/if}
					</div>
					<div class="tableItem-10 tableItem">{$value->author}</div>
					<div class="tableItem-11 tableItem">
						{if $value->disabled==1}
							<span style="color:green;">已显示</span><a style="color:red" @click="setDisabled({$value->id},0)" href="javascript:;">关闭</a>
						{else}
							<span style="color:red;">已关闭</span><a style="color:green;" @click="setDisabled({$value->id},1)" href="javascript:;">显示</a>
						{/if}
					</div>
					<div class="tableItem-12 tableItem">
						{if $value->flagComment==1}
							<span style="color:green;">已开启</span><a style="color:red" @click="setFlagComment({$value->id},0)" href="javascript:;">关闭</a>
						{else}
							<span style="color:red;">已关闭</span><a style="color:green;" @click="setFlagComment({$value->id},1)" href="javascript:;">开启</a>
						{/if}
					</div>
					<div class="tableItem-13 tableItem">
						{if $value->roof==1}
							<span style="color:green">已开启</span><a style="color:red" @click="setRoof({$value->id},0)" href="javascript:;">关闭</a>
						{else}
							<span style="color:red">已关闭</span><a style="color:green;" @click="setRoof({$value->id},1)" href="javascript:;">开启</a>
						{/if}
					</div>
					<div class="tableItem-14 tableItem" title="{$value->date}">{$value->smallDate}</div>
					<div class="tableItem-15 tableItem">
						<div class="btn">
							<a href="?a=article&m=update&id={$value->id}&page={$pageCurrent}" target="_blank" class="edit">修改</a>
							<a href="javascript:;" class="delete" @click="deleteArticle({$value->id})">删除</a>
							<a href="javascript:;" class="focus"  @click="focusArticle({$value->id})">设为焦点</a>
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