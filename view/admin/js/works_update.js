




new Vue({
	el:'.title',
	data:{

	},
	methods:{
		goShow(page){
			window.location.href="?a=works&page="+page
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
	async created(){
		let query=Url();
		let res = await axios.get('?a=AdminAjax&m=getWorksOne',{
			params:{
				id:query['id']
			}
		});
		this.title=res.data[0].title;
		this.info=res.data[0].info;
		this.target=res.data[0].target;
		this.disabled=(res.data[0].disabled==1 ? true : false);
		this.uniqueId=res.data[0].imgUrl;
		this.brandImageUrl='?a=images&uniqueId='+res.data[0].imgUrl;
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
		          	message: '请选择图片',
		          	type: 'warning'
		        });
		        return false;
			}
			this.addBrandBth=false;
			let query=Url();
			let data = new FormData();
			data.append('title',this.title);
			data.append('target',this.target);
			data.append('info',this.info);
			data.append('imgUrl',this.uniqueId);
			data.append('id',query['id']);
			data.append('disabled',this.disabled ? 1 : 0);
			let res = await axios.post('?a=AdminAjax&m=editWorks',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			if(res.data.state=='succ'){

				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 0
		        });
				setTimeout(()=>{
					location.href='?a=works&page='+query['page'];
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












function Url(){
	let search = window.location.search.substr(1);
	let query=[];
	let temp=[];
	temp=search.split('&');
	for(let i=0;i<temp.length;i++){
		let q = temp[i].split('=');
		query[q[0]]=q[1];
	}
	return query;
}



























