

new Vue({
	el:'.title',
	data:{
       
        addTimeViewVisible:false,
		form:{
			
		},
		addTimeBtn:true
	},

	methods:{
		async postNav(){
			if(this.form.content==undefined || this.form.content==''){
				this.$message({message:'请输入内容',type:'warning'});
				return;
			};
			this.addTimeBtn=false;
			let data = new FormData();
			for(let i in this.form){
				data.append(i,this.form[i]);
			}
			let res = await axios.post('?a=AdminAjax&m=addTime',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			this.addTimeBtn=true;
			console.log(res.data)
			if(res.data.state=="succ") {	//添加成功
				setTimeout(()=>{
					location.reload();
				},500)
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
		TimeData: [],
		editTimeViewVisible:false,
		editForm:{},
		editTimeBtn:true,
		page:{}
	},
	async created(){
		this._getTimeData();
	},
	methods:{
		handleDeleteTime(id){
			console.log(id)
			this.$confirm('此操作将永久删除, 是否继续?', '提示', {
	          	confirmButtonText: '确定',
	          	cancelButtonText: '取消',
	          	type: 'warning'
	        }).then( async () => {
	        	let data=new FormData();
	        	data.append('id',id);
	        	let res = await axios.post('?a=AdminAjax&m=deleteTime',data,{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
				this.$message(res.data.info);
				console.log(res.data.state)
				if(res.data.state=='succ'){
					this.TimeData.forEach((item,index)=>{
						if(item.id==id){
							this.TimeData.splice(index,1);
						}
					})
				}
	          	
	        });
		},
		handleEdit(form){
			this.editTimeViewVisible=true;
			let newData = JSON.parse(JSON.stringify(form));
			this.editForm=newData;
		},
		async editTime(){
			
			if(this.editForm.content==undefined || this.editForm.content==''){
				this.$message({message:'请输入内容',type:'warning'});
				return;
			};

			this.editTimeBtn=false;
			let data = new FormData();
			for(let i in this.editForm){
				data.append(i,this.editForm[i]);
			}
			let res = await axios.post('?a=AdminAjax&m=editTime',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});

			this.editTimeBtn=true;
			if(res.data.state=="succ") {	//修改成功
				
				setTimeout(()=>{
					location.reload();
				},500)
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
			
		},
		handleCurrentChange(pageCurrent){
			let query = Url();
			query['page']=pageCurrent;

			let str='';
			for(let i in query){
				str += '&'+i+'='+query[i]
			}
			str = str.substr(1);
			window.location.href="?"+str
			
		},
		async _getTimeData(){
			let query = Url();
			let page = query['page'] ? query['page'] : 1;
			let res = await axios.get('?a=AdminAjax&m=getTimeList',{
				params:{page}
			});
			this.TimeData=res.data.content;
			this.page.total=parseInt(res.data.total);
			this.page.size=res.data.size;
			console.log(res.data.page)
			//this.page.current=parseInt(res.data.page);

			this.$set(this.page,'current',parseInt(res.data.page))
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


