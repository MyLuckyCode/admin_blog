<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——修改作品</title>
	{$Style}
</head>
<body>
	
	
<div class="title">	
	<div class="titleView">
		<h3>修改作品</h3>
		<span @click="goShow({$tpl.get.page})">返回作品列表</span>
	</div>
</div>


<div class="content">
	<div class="form">
		<div class="name">
			<span>名  称：</span> <el-input placeholder="标题，用于鼠标经过时显示" v-model="title" show-word-limit maxlength="10"></el-input>
		</div>
		<div class="target">
			<span>地  址：</span> <el-input placeholder="目标，用于鼠标点击时跳转" v-model="target" show-word-limit maxlength="40"></el-input>
		</div>
		<div class="target">
			<span>介  绍：</span> <el-input type="textarea" :autosize="{ minRows: 2, maxRows: 4}" placeholder="目标，用于鼠标点击时跳转" v-model="info" show-word-limit maxlength="190"></el-input>
		</div>
		<div class="pic">
			<span>封  面：</span> 
			<div class="face">
				<i class="iconfont iconadd" v-if="brandImageUrl==''"></i>
				<span v-if="brandImageUrl==''">选择图片</span>
				<img :src="brandImageUrl" v-if="brandImageUrl!=''" alt="" class="face-img">
				<div class="select">
					<span>从本地选择</span>
					<span @click="openGallery">从图库选择</span>
				</div>
			</div>
			<span style="padding-left:15px;">建议图片尺寸为 345*200</span>
		</div>
		<div class="disabled">
			<span>启  用：</span>
			<el-switch
				v-model="disabled">
			</el-switch>
		</div>
		<Gallery :galleryflag.sync="GalleryFlag" v-if="GalleryFlag" select="single" @confirm="galleryConfirm" ></Gallery>
		<Tailoring :tailoringflag.sync="Tailoringflag" v-if="Tailoringflag" :src="clippingImageUrl"  :clipping-info="clippingBoxInfo" @confirm="TailoringConfirm"></Tailoring>
		
		<div class="submit">
			<el-button type="primary" @click="postAddBrand" :loading="!addBrandBth">修改</el-button>
		</div>

	</div>

</div>







</body>
{$Script}

</html>








