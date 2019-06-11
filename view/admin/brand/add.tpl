<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理——添加轮播图</title>
	{$Style}
</head>
<body>
	
	
<div class="title">	
	<div class="titleView">
		<h3>添加轮播图</h3>
		<span @click="goShow">返回轮播器列表</span>
	</div>
</div>


<div class="content">
	
	<div class="form">
		<div class="name">
			<span>标  题：</span> <el-input placeholder="标题，用于鼠标经过时显示" v-model="title" show-word-limit maxlength="10"></el-input>
		</div>
		<div class="target">
			<span>目  标：</span> <el-input placeholder="目标，用于鼠标点击时跳转" v-model="target" show-word-limit maxlength="40"></el-input>
		</div>
		<div class="pic">
			<span>图  片：</span> 
			<div class="face">
				<i class="iconfont iconadd" v-if="brandImageUrl==''"></i>
				<span v-if="brandImageUrl==''">选择图片</span>
				<img :src="brandImageUrl" v-if="brandImageUrl!=''" alt="" class="face-img">
				<div class="select">
					<span>从本地选择</span>
					<span @click="openGallery">从图库选择</span>
				</div>
			</div>
			<span style="padding-left:15px;">建议图片尺寸为 1200*360</span>
		</div>
		<div class="disabled">
			<span>启  用：</span>
			<el-switch
				v-model="disabled">
			</el-switch>
		</div>
		<Gallery :galleryflag.sync="GalleryFlag" v-if="GalleryFlag" select="single" @confirm="galleryConfirm" ></Gallery>
		<Tailoring :tailoringflag.sync="Tailoringflag" v-if="Tailoringflag" :clipping-info="clippingBoxInfo" :src="clippingImageUrl"  @confirm="TailoringConfirm"></Tailoring>
		
		<div class="submit">
			<el-button type="primary" @click="postAddBrand" :loading="!addBrandBth">添加</el-button>
		</div>

	</div>

</div>







</body>
{$Script}

</html>








