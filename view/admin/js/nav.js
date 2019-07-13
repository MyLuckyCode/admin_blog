

new Vue({
	el:'.title',
	data:{
       
        addNavViewVisible:false,
		form:{
			category:'web',
			disabled:false
		},
		addNavBtn:true
	},

	methods:{
		async postNav(){

			if(this.form.name==undefined || this.form.name==''){
				this.$message({message:'标题不能为空',type:'warning'});
				return;
			};
			this.addNavBtn=false;

			this.form.disabled = this.form.disabled==false ? 0 : 1;

			let data = new FormData();
			for(let i in this.form){
				data.append(i,this.form[i]);
			}
			let res = await axios.post('./api/admin/v1.0/?a=nav&m=addNav',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			this.addNavBtn=true;
			console.log(res.data)
			if(res.data.state=="succ") {	//添加成功

				this.form.date=new Date().toLocaleDateString().replace(/\//g,'-');
				this.form.id=res.data.id;
				list.navData.push(this.form);

				this.form={};
				this.$set(this.form,'category','web')
				this.$set(this.form,'disabled',false)
				this.addNavViewVisible=false;
				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 6000
		        });

			}else{
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




let list = new Vue({
	el:'#list',
	data:{
		activeName:'web',
		navData: [],
		editNavViewVisible:false,
		editForm:{},
		editNavBtn:true
	},
	async created(){
		let res = await axios.get('./api/admin/v1.0/?a=nav&m=getNavList');
		
		this.navData=res.data;
	},
	computed:{
		navDataWeb(){
			let arr = [];
			this.navData.map((item)=>{
				if(item.category=='web') arr.push(item);
			})
			return arr;
		},
		navDataLife(){
			let arr = [];
			this.navData.map((item)=>{
				if(item.category=='life') arr.push(item);
			})
			return arr;
		}
	},
	methods:{
		handleDeleteNav(id){
			console.log(id)
			this.$confirm('此操作将永久删除, 是否继续?', '提示', {
	          	confirmButtonText: '确定',
	          	cancelButtonText: '取消',
	          	type: 'warning'
	        }).then( async () => {
	        	let data=new FormData();
	        	data.append('id',id);
	        	let res = await axios.post('./api/admin/v1.0/?a=nav&m=deleteNav',data,{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
				this.$message(res.data.info);
				console.log(res.data.state)
				if(res.data.state=='succ'){
					this.navData.forEach((item,index)=>{
						if(item.id==id){
							this.navData.splice(index,1);
						}
					})
				}
	          	
	        });
		},
		handleEdit(form){
			this.editNavViewVisible=true;
			let newData = JSON.parse(JSON.stringify(form));
			newData.disabled = newData.disabled==1 ? true : false;
			this.editForm=newData;
		},
		async editNav(){
			
			if(this.editForm.name==undefined || this.editForm.name==''){
				this.$message({message:'标题不能为空',type:'warning'});
				return;
			};

			this.editNavBtn=false;
			this.editForm.disabled = this.editForm.disabled==false ? 0 : 1;
			let data = new FormData();
			for(let i in this.editForm){
				data.append(i,this.editForm[i]);
			}
			let res = await axios.post('./api/admin/v1.0/?a=nav&m=editNav',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});

			this.editNavBtn=true;
			if(res.data.state=="succ") {	//修改成功

				let newNavData = this.navData.map((item)=>{
					if(item.id==this.editForm.id) return this.editForm;
					return item;
				})
				this.navData=newNavData;

				this.editNavViewVisible=false;
				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 6000
		        });


			}else{
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