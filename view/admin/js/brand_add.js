




new Vue({
	el:'.title',
	data:{

	},
	methods:{
		goShow(){
			window.location.href="?a=brand"
		}
	}

})



new Vue({
	el:'.content',
	data:{
		GalleryFlag:false,
		Tailoringflag:false,
		clippingBoxInfo:{width:1200,height:360,proportion:true,compute:'info'},
		clippingImageUrl:'',
		brandImageUrl:'',
		title:'',
		target:'',
		uniqueId:'',
		disabled:true,
		addBrandBth:true
	},
	methods:{
		openGallery(){
			this.GalleryFlag=true;
		},
		galleryConfirm(list){
			this.Tailoringflag=true;
			console.log(list)
			for(let i in list){
				this.clippingImageUrl='?a=images&uniqueId='+list[i].uniqueId;
			}
		},
		TailoringConfirm(uniqueId){
			this.uniqueId=uniqueId;
			this.brandImageUrl='?a=images&uniqueId='+uniqueId;
		},
		async postAddBrand(){
			
			if(this.title==''){
				this.$message({
		          	message: '请输入标题',
		          	type: 'warning'
		        });
		        return false;
			}
			if(this.target==''){
				this.$message({
		          	message: '请输入跳转目标的链接',
		          	type: 'warning'
		        });
		        return false;
			}
			if(this.brandImageUrl==''){
				this.$message({
		          	message: '请选择图片',
		          	type: 'warning'
		        });
		        return false;
			}
			this.addBrandBth=false;
			let data = new FormData();
			data.append('title',this.title);
			data.append('target',this.target);
			data.append('imgUrl',this.uniqueId);
			data.append('disabled',this.disabled ? 1 : 0);
			let res = await axios.post('?a=AdminAjax&m=addBrand',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			if(res.data.state=='succ'){

				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 0
		        });
				setTimeout(()=>{
					location.href='?a=brand';;
				},1000)
			}else {
				this.addBrandBth=true;
				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'warning',
		          duration: 0
		        });

			}
			
		}
	}
})







































