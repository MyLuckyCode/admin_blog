<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——素材</title>
	{$Style}

</head>
<body>

<div class="title">	
	<div class="titleView">
		<h3>样式管理</h3>
		<span @click="addPatternViewVisible = true">添加分组</span>
	</div>

	<el-dialog title="添加相册" :visible.sync="addPatternViewVisible" width="380px">

	  <el-form label-width="70px" @submit.native.prevent>

	    <el-form-item label="相册名称">
	      	<el-input 
	      		type="text"
	      		v-model="form.name"
	      		maxlength="15"
	      		show-word-limit
	      	></el-input>
	    </el-form-item>

	  </el-form>

	  <div slot="footer" class="dialog-footer">
	    <el-button @click="addPatternViewVisible = false" :disabled="!addPatternBtn">取 消</el-button>
	    <el-button type="primary" @click="postPattern" :disabled="!addPatternBtn">添 加</el-button>
	  </div>
	</el-dialog>
</div>

<div class="patternList">
	<span>相 册：</span>

	{foreach from=$patternList item=value key=key}
		<span class="el-tag {if isset($tpl.get.type) && $value->id==$tpl.get.type}active{/if}" >
			<a href="?a=pattern&type={$value->id}">{$value->name} ( {$value->count} ) </a>
			
		</span>
	{/foreach}

</div>


<div class="pictureItemView">
	<div class="header">
		<div class="itemName">
			{if isset($tpl.get.type)}
				{$patternTitleInfo[0]->name}
				（{$patternTitleInfo[0]->total}）
				{if $patternTitleInfo[0]->operation=='on'}

						<el-popover
							  	placement="bottom"
							  	v-model="itemNameHeader.editFlag"
								style="padding:0"
								width="250"
							  	>
							  	<div>
									<p style="margin:10px 0 0px 10px;">请输入分组名称</p>
									<p style="margin-left:10px"><input type="text" :style="itemNameHeader.editInputStyle" v-model="itemNameHeader.postInput"></p>
							  	</div>
							  	<div style="text-align: left;padding:0 10px;">
							  		<el-button type="primary" size="medium" :loading="!itemNameHeader.editBtnFlag" @click="editPatternName({$patternTitleInfo[0]->id})" >确定</el-button>
							    	<el-button size="medium" @click="itemNameHeader.editFlag = false">取消</el-button>
							  	</div>
							  	<i class="iconfont iconbianji extra-item" style="cursor: pointer;" slot="reference"></i>
						</el-popover>

					 	<el-popover
						  	placement="bottom"
						  	v-model="itemNameHeader.deleteFlag"
						  	width="225"
							style="padding:0"
						  	>									
						  	<p style="margin:10px 0 10px 10px;">仅删除分组，不删除样式，组内样式将自动归入未分组</p>
						  	<div style="text-align: left;padding:0 10px;">
						  		<el-button type="primary" size="medium" :loading="!itemNameHeader.deleteBtnFlag" @click="deletePattern({$patternTitleInfo[0]->id})">确定</el-button>
						    	<el-button size="medium" @click="itemNameHeader.deleteFlag = false">取消</el-button>
						  	</div>
						  	<i class="iconfont iconshanchu1 extra-item" style="cursor: pointer;" slot="reference"></i>
						</el-popover>
						
						
						

				{/if}
				<a href="?a=pattern" style="font-size:15px;margin-left:50px;">返回全部分组</a>
			{else}
				全部分组
				（{$patternTitleInfo[0]->total}）
			{/if}
			

		</div>

		<div class="upButton">

			<el-button type="primary" size="medium" @click="addPatternItemView" >添加</el-button>

		</div>

		

	</div>

	<div class="body">
		{if empty($patternItemList)}
			<p>没有任何样式</p>
		{else}
			<div class="imagesList">
				<div class="bat-tips" v-if="Object.keys(checkBoxIdList).length>0">
					<div class="info">
						<span @click="checkBoxAll('tag')">
							<i class="iconfont iconweibiaoti29" v-if="Object.keys(checkBoxIdList).length<Object.keys(checkBoxIdListAll).length"></i>
							<i v-else class="iconfont icondui selected"></i>
						</span>
						

						<span>已选择{{Object.keys(checkBoxIdList).length}}项内容</span>
						<span class="operation" @click="checkBoxAll('cancelSelected')">取消选择</span>
						<span class="operation" @click="checkBoxAll('selectedAll')">全部选择</span>
					</div>
					<div class="extra">
						<el-tooltip effect="dark" content="删除" placement="top">
						    
						    <el-popover
							  	placement="bottom"
							  	v-model="bat_tips.deleteFlag"
							  	width="225"
								style="padding:0"
							  	>
							  	<p style="margin:10px 0 10px 20px;">确定删除此素材吗？</p>
							  	<div style="text-align: left;padding:0 10px;">
							  		<el-button type="primary" size="medium" :loading="!bat_tips.deleteBtnFlag" @click="handleBatTipsDelete">确定</el-button>
							    	<el-button size="medium" @click="bat_tips.deleteFlag = false">取消</el-button>
							  	</div>
							  	<i class="iconfont iconshanchu1 extra-item" slot="reference"></i>
							</el-popover>
						</el-tooltip>

						<el-tooltip effect="dark" content="移动分组" placement="top">
						    <el-popover
							  	placement="bottom"
							  	v-model="bat_tips.moveFlag"
								style="padding:0"
								width="250"
							  	>
							  	<div>
									<span v-for="(item,id) in pictureList" :key="item.id" :style="[pictureListStyle,{borderColor:item.id==pictureListSelectedId ? '#409eff' : 'transparent',color:item.id==pictureListSelectedId ? '#409eff' : '#9A9A9A'}]" @click="handleMovePicture(item.id)">{{item.name}}</span>
							  	</div>
							  	<div style="text-align: left;padding:0 10px;">
							  		<el-button type="primary" size="medium" :loading="!bat_tips.moveBtnFlag" @click="handlePostMovePicture">确定</el-button>
							    	<el-button size="medium" @click="bat_tips.moveFlag = false">取消</el-button>
							  	</div>
							  	<i class="iconfont iconly_qiehuan extra-item" slot="reference"></i>
							</el-popover>
						</el-tooltip>
						
					</div>
				</div>
				<ul>
					{foreach from=$patternItemList item=value key=key}
						<li class="item" >
								<div class="item-content" :class="{'active' : isCheckBox({$value->id},{$value->pid})}"  @click="setPictrueViewer({$key})">
									{$value->content}
								</div>
						    <div class="image-name">
						    	<input type="text" value="{$value->name}" @blur="editPatternItemName({$value->id})" style="display:none;" id="image-name-input-{$value->id}" >
								<span @click="setImageName({$value->id})" id="image-name-span-{$value->id}">{$value->name}</span>
						    </div>
						    <label class="checkbox" :class="{'active' : isCheckBox({$value->id},{$value->pid})}" :style="{display:isCheckBox({$value->id},{$value->pid}) ? 'block' : 'none'}" @click.stop="handleCheckBox({$value->id},{$value->pid})">
						    </label>
						    <i class="edit iconfont iconyyxiugai1" :style="{display:isCheckBox({$value->id},{$value->pid}) ? 'block' : 'none'}" @click.stop="handlEditPatternItem({$value->id})"></i>
						 </li>
						
					{/foreach}
				</ul>
				<el-pagination class="page"
				    @current-change="handleCurrentChange"
				    :current-page="{$pageCurrent}"
				    :page-size="{$pageSize}"
				    layout="prev, pager, next, jumper"
				    :total="{$patternTitleInfo[0]->total}">
				</el-pagination>
			</div>



			
		{/if}
	</div>

				
</div>






{$Script}

</body>
</html>