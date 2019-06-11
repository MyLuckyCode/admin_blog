

new Vue({
	el:'.title',
	data:{
       
        addLabelViewVisible:false,
		form:{},
		addLabelBtn:true
	},

	methods:{
		async postLabel(){
			console.log(this.form.name)
			if(this.form.name==undefined || this.form.name==''){
				this.$message({message:'标题不能为空',type:'warning'});
				return;
			};
			this.addLabelBtn=false;
			let data = new FormData();
			for(let i in this.form){
				data.append(i,this.form[i]);
			}
			let res = await axios.post('?a=AdminAjax&m=addLabel',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			this.addLabelBtn=true;
			if(res.data.state=="succ") {	//添加成功
				
				this.form.id=res.data.id;
				list.tags.push(this.form);

				this.form={};

				this.addLabelViewVisible=false;
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
		addLabelViewVisible:false,
		editLabelViewVisible:false,
		editForm:{},
		tags: [],
		editLabelBtn:true
	},
	async created(){
		let res = await axios.get('?a=AdminAjax&m=getLabelList');
		console.log(res.data)
		this.tags=res.data;
	},

	methods:{
		handleDeleteLabel(id){
			console.log(id)
			this.$confirm('此操作将永久删除, 是否继续?', '提示', {
	          	confirmButtonText: '确定',
	          	cancelButtonText: '取消',
	          	type: 'warning'
	        }).then( async () => {
	        	let data=new FormData();
	        	data.append('id',id);
	        	let res = await axios.post('?a=AdminAjax&m=deleteLabel',data,{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
				this.$message(res.data.info);
				console.log(res.data.state)
				if(res.data.state=='succ'){
					this.tags.forEach((item,index)=>{
						if(item.id==id){
							this.tags.splice(index,1);
						}
					})
				}
	          	
	        });
		},
		handleEdit(form){
			this.editLabelViewVisible=true;
			let newData = JSON.parse(JSON.stringify(form));
			this.editForm=newData;
		},
		async editLabel(){			//修改成功
			
			if(this.editForm.name==undefined || this.editForm.name==''){
				this.$message({message:'标题不能为空',type:'warning'});
				return;
			};
			this.editLabelBtn=false;

			let data = new FormData();
			for(let i in this.editForm){
				data.append(i,this.editForm[i]);
			}
			let res = await axios.post('?a=AdminAjax&m=editLabel',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			console.log(res.data)
			this.editLabelBtn=true;
			if(res.data.state=="succ") {	//添加成功

				let newTags = this.tags.map((item)=>{
					if(item.id==this.editForm.id) return this.editForm;
					return item;
				})
				this.tags=newTags;

				this.editLabelViewVisible=false;
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