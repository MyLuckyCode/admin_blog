<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——修改样式</title>
	
	{$Style}

</head>
<body>
	
<div class="title">	
	<div class="titleView">
		<h3>添加样式</h3>
		<span @click="goShow">返回样式列表</span>
	</div>
</div>



	<div class="form">
		<div class="name">
			<span>标　题：</span> <el-input placeholder="标题" size="small" style="width:350px;" v-model="form.name" show-word-limit maxlength="50"></el-input>
		</div>
		<div class="nav">
			<span>导　航：</span>
			<el-radio-group v-model="form.pid">
				{foreach from=$findAllPattern item=value key=key}
				
			    	<el-radio :label="{$value->id}">{$value->name}</el-radio>
				
				{/foreach}
			
			</el-radio-group>
		</div>
		<div class="content">
			
		</div>

		<Gallery :galleryflag.sync="GalleryFlag" v-if="GalleryFlag" :event-type="galleryEventType" :select="GallerySelect" @confirm="galleryConfirm" ></Gallery>
		<Tailoring :tailoringflag.sync="Tailoringflag" v-if="Tailoringflag" :event-type="tailoringEventType" :src="clippingImageUrl" :clipping-info="clippingInfo" @confirm="TailoringConfirm"></Tailoring>
		<div class="submit">
			<el-button type="primary" @click="postEditPatternItem" :loading="!addArticleBth">确定</el-button>
		</div>
	</div>



<script type="text/javascript" src="./view/admin/js/wangEditor.js"></script>
<script type="text/javascript" src="./view/admin/js/format.js"></script>
{$Script}

<script type="text/javascript">

</script>

</body>
</html>