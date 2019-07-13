




new Vue({
	el:'.title',
	data:{

	},
	methods:{
		goShow(){
			window.location.href="?a=works"
		}
	}

})



new Vue({
	el:'.content',
	data:{
		GalleryFlag:false,
		Tailoringflag:false,
		clippingBoxInfo:{width:345,height:200,proportion:true,compute:'info'},
		clippingImageUrl:'',
		brandImageUrl:'',
		title:'',
		target:'',
		info:'',
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
		          	message: '请输入链接',
		          	type: 'warning'
		        });
		        return false;
			}
			if(this.brandImageUrl==''){
				this.$message({
		          	message: '请选择封面',
		          	type: 'warning'
		        });
		        return false;
			}
			
			this.addBrandBth=false;
			let data = new FormData();
			data.append('title',this.title);
			data.append('target',this.target);
			data.append('info',this.info);
			data.append('imgUrl',this.uniqueId);
			data.append('disabled',this.disabled ? 1 : 0);
			let res = await axios.post('./api/admin/v1.0/?a=works&m=addWorks',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			if(res.data.state=='succ'){

				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 0
		        });
				setTimeout(()=>{
					location.href='?a=works';
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







































