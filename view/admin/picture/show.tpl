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
		<h3>相册管理</h3>
		<span @click="addPictureViewVisible = true">添加相册</span>
	</div>

	<el-dialog title="添加相册" :visible.sync="addPictureViewVisible" width="380px">

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
	    <el-button @click="addPictureViewVisible = false" :disabled="!addPictureBtn">取 消</el-button>
	    <el-button type="primary" @click="postPicture" :disabled="!addPictureBtn">添 加</el-button>
	  </div>
	</el-dialog>
</div>

<div class="pictureList">
	<span>相 册：</span>

	{foreach from=$pictureList item=value key=key}
		<span class="el-tag {if isset($tpl.get.type) && $value->id==$tpl.get.type}active{/if}" >
			<a href="?a=picture&type={$value->id}">{$value->name} ( {$value->count} ) </a>
			
		</span>
	{/foreach}

</div>


<div class="pictureItemView">
	<pictrueviewer :pictrueviewerflag.sync="pictrueViewerFlag" v-show="pictrueViewerFlag" :check-box-id-list-all="checkBoxIdListAll" :index="checkBoxIdListAllIndex" ></pictrueviewer>
	<div class="header">
		<div class="itemName">
			{if isset($tpl.get.type)}
				{$pictureTitleInfo[0]->name}
				（{$pictureTitleInfo[0]->total}）
				{if $pictureTitleInfo[0]->operation=='on'}

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
							  		<el-button type="primary" size="medium" :loading="!itemNameHeader.editBtnFlag" @click="editPictureItemName({$pictureTitleInfo[0]->id})" >确定</el-button>
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
						  	<p style="margin:10px 0 10px 10px;">仅删除分组，不删除图片，组内图片将自动归入未分组</p>
						  	<div style="text-align: left;padding:0 10px;">
						  		<el-button type="primary" size="medium" :loading="!itemNameHeader.deleteBtnFlag" @click="deletePicture({$pictureTitleInfo[0]->id})">确定</el-button>
						    	<el-button size="medium" @click="itemNameHeader.deleteFlag = false">取消</el-button>
						  	</div>
						  	<i class="iconfont iconshanchu1 extra-item" style="cursor: pointer;" slot="reference"></i>
						</el-popover>
						
						
						

				{/if}
				<a href="?a=picture" style="font-size:15px;margin-left:50px;">返回全部图片</a>
			{else}
				全部图片
				（{$pictureTitleInfo[0]->total}）
			{/if}
			

		</div>
		
		<div class="upButton">

			<upfilebutton
				:up-size="5"
				:up-type="['image/png','image/jpeg','image/jpg','image/gif']"
				:up-data="{pid:{$pid}}"
				@up-complete="upComplete"
			/>

		</div>

	</div>

	<div class="body">
		{if empty($imgList)}
		<p>没有任何图片</p>
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
					{foreach from=$imgList item=value key=key}
						<li class="item" @click="setPictrueViewer({$key})" >
							{if $value->type=='gif'}	
						    	<i class="item-image" :class="{'active' : isCheckBox({$value->id},{$value->pid},'{$value->uniqueId}')}" style="background-image:url(./upload/clippingImages/{$value->uniqueId})"></i>
							{else}
								<i class="item-image" :class="{'active' : isCheckBox({$value->id},{$value->pid},'{$value->uniqueId}')}" style="background-image:url(?a=images&uniqueId={$value->uniqueId}&type=small)"></i>
							{/if}
						    <div class="image-name" @click.stop>
						    	<input type="text" value="{$value->name}" @blur="editImageName({$value->id})" style="display:none;" id="image-name-input-{$value->id}" >
								<span @click="setImageName({$value->id})" id="image-name-span-{$value->id}">{$value->name}</span>
						    </div>
						    <label class="checkbox" :class="{'active' : isCheckBox({$value->id},{$value->pid})}" :style="{display:isCheckBox({$value->id},{$value->pid}) ? 'block' : 'none'}" @click.stop="handleCheckBox({$value->id},{$value->pid})">
						    </label>
						 </li>
						
					{/foreach}
				</ul>
				<el-pagination class="page"
				    @current-change="handleCurrentChange"
				    :current-page="{$pageCurrent}"
				    :page-size="{$pageSize}"
				    layout="prev, pager, next, jumper"
				    :total="{$pictureTitleInfo[0]->total}">
				</el-pagination>
			</div>



			
		{/if}
	</div>

				
</div>







{$Script}

</body>
</html>