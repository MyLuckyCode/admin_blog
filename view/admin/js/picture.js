

new Vue({
	el:'.title',
	data:{
       
        addPictureViewVisible:false,
		form:{},
		addPictureBtn:true
	},

	methods:{
		async postPicture(){
			console.log(this.form.name)
			if(this.form.name==undefined || this.form.name==''){
				this.$message({message:'标题不能为空',type:'warning'});
				return;
			};
			this.addPictureBtn=false;
			let data = new FormData();
			for(let i in this.form){
				data.append(i,this.form[i]);
			}
			let res = await axios.post('?a=AdminAjax&m=addPicture',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			this.addPictureBtn=true;
			console.log(res.data)
			if(res.data.state=="succ") {	//添加成功

				setTimeout(()=>{
					location.reload();
				},1000)

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


new Vue({
	el:'.pictureList',
	data:{
		
	}
})



let pictureItemView = new Vue({
	el:'.pictureItemView',
	async created(){
		let res = await axios.get('?a=AdminAjax&m=getPictureList');

		let query = Url();
		let type = query['type'] ? query['type'] : 1;
		res.data.forEach((item)=>{
			if(item.id!=type){
				this.pictureList.push(item);
			}else {
				this.itemNameHeader.postInput=item.name
				this.itemNameHeader.initialInput=item.name
			}
		})

	},
	data:{
		pictureList:[],
		pictureListSelectedId:null,
		pictureListStyle:{
			border:'1px solid transparent',
			lineHeight:'30px',
			color:'#9A9A9A',
			borderRadius:'15px',
			padding:'2px 15px',
			cursor:'pointer',
			display:'inline-block',
			verticalAlign:'top',
			marginRight:'10px',
			marginBottom:'10px'
		},
		checkBoxIdList:{},
		checkBoxIdListAll:{},
		checkBoxIdListAllIndex:0,
		bat_tips:{
			deleteFlag:false,
			moveFlag:false,
			deleteBtnFlag:true,
			moveBtnFlag:true
		},
		itemNameHeader:{
			deleteFlag:false,
			editFlag:false,
			deleteBtnFlag:true,
			editBtnFlag:true,
			editInputStyle:{
				display:'inline-block',
				width:'100%',
				height:'30px',
				padding:'10px',
				border:'1px solid rgba(64,158,255,.5)',
				outline:'none',
				borderRadius:'3px',
				margin:'10px 0'
			},
			initialInput:'',
			postInput:''
		},
		pictrueViewerFlag:false
	},
	methods:{
		setPictrueViewer(key){
			this.checkBoxIdListAllIndex=key;
			this.pictrueViewerFlag=true;
		},
		upComplete(){
			location.reload();
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
		handleCheckBox(id,pid){

			 if(this.checkBoxIdList.hasOwnProperty(id)){
			 	this.$delete(this.checkBoxIdList,id)
			 }else {
			 	this.$set(this.checkBoxIdList,id,{id,pid})
			 }

		},
		isCheckBox(id,pid,uniqueID){

			// 获取当前页面图片的全部ID，用于做全部选择或取消选择
			if(!this.checkBoxIdListAll.hasOwnProperty(id)){ 
				//console.log(this.checkBoxIdListAll);
				this.checkBoxIdListAll[id]={id,pid,uniqueID}
			}
			return this.checkBoxIdList.hasOwnProperty(id);
		},

		// type是类型，tag代表切换，selectedAll 选择全部，cancelSelected 取消全部选择
		checkBoxAll(type){
			if(type=='tag'){
				if(Object.keys(this.checkBoxIdList).length==Object.keys(this.checkBoxIdListAll).length){
					this.checkBoxIdList={};
				}else {
					//console.log(JSON.parse(this.checkBoxIdListAll))
					this.checkBoxIdList = JSON.parse(JSON.stringify(this.checkBoxIdListAll));
				}
			}else if(type=='cancelSelected'){
				this.checkBoxIdList={};
			}else if(type=='selectedAll'){
				this.checkBoxIdList = JSON.parse(JSON.stringify(this.checkBoxIdListAll));
			}
			
		},
		handleMovePicture(id){
			this.pictureListSelectedId=id;
			
		},
		async handlePostMovePicture(){
			if(this.pictureListSelectedId==null) return;

			this.bat_tips.moveBtnFlag=false;
			let arr = this.checkBoxIdList;

			let o = {};
			for(let i in arr){
				if(Array.isArray(o[arr[i].pid])){
					o[arr[i].pid].push(i);
				}else {
					o[arr[i].pid]=[i];
				}
			}

			let data = new FormData();
			data.append('moveData',JSON.stringify(o));
			data.append('newPid',this.pictureListSelectedId);
			let res = await axios.post('?a=AdminAjax&m=movePictureItem',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			console.log(res.data);
			this._batExtraComplete(res.data);

		},
		async handleBatTipsDelete(){
			this.bat_tips.deleteBtnFlag=false;
			let arr = this.checkBoxIdList;

			let o = {};
			for(let i in arr){
				if(Array.isArray(o[arr[i].pid])){
					o[arr[i].pid].push(i);
				}else {
					o[arr[i].pid]=[i];
				}
			}

			let data = new FormData();
			data.append('deleteData',JSON.stringify(o));
			let res = await axios.post('?a=AdminAjax&m=deletePictureItem',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			//pictureList.tags=res.data;
			console.log(res.data)
			this._batExtraComplete(res.data);
			
		},
		_batExtraComplete(data){
			if(data.state=='succ'){
				this.$notify({
		          	title: '提示',
		          	message: data.info,
		          	type: 'success',
		          	duration: 2000
		        });
			}else{
				this.$notify({
		          	title: '提示',
		          	message: data.info,
		          	type: 'warning',
		          	duration: 2000
		        });
			}
			setTimeout(()=>{
				location.reload();
			},1000)
		},

		setImageName(id){
			document.querySelector('#image-name-span-'+id).style.display='none';
			let input = document.querySelector('#image-name-input-'+id);
			input.style.display='block';
			input.select();
		},
		async editImageName(id){
			let span = document.querySelector('#image-name-span-'+id);
			let input = document.querySelector('#image-name-input-'+id);

			input.style.display='none';
			span.style.display='block';

			if(span.innerHTML == input.value){
				console.log('没有任何修改')
				return;
			} 

			span.innerHTML = input.value;
			
			let data = new FormData();
			data.append('id',id);
			data.append('name',input.value);
			let res = await axios.post('?a=AdminAjax&m=editImageName',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});

			if(res.data.state=='succ'){
				this.$message({
		          	message: res.data.info,
		          	type: 'success'
		        });
			}else {
				this.$message({
		          	message: res.data.info,
		          	type: 'warning'
		        });
			}
		},
		async editPictureItemName(id){

			if(this.itemNameHeader.postInput==this.itemNameHeader.initialInput) return;

			this.itemNameHeader.editBtnFlag=false;

			let data = new FormData();
			data.append('id',id);
			data.append('name',this.itemNameHeader.postInput);
			let res = await axios.post('?a=AdminAjax&m=editPicture',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			console.log(res.data)
			if(res.data.state=='succ'){
				this.$message({message: res.data.info,type: 'success'});
		        setTimeout(()=>{
					location.reload();
				},1000)
			}else {
				this.itemNameHeader.editBtnFlag=true;
				this.$message({message: res.data.info,type: 'warning'});
			}
		},
		async deletePicture(id){
			this.itemNameHeader.deleteBtnFlag=false;

			let data = new FormData();
			data.append('id',id);
			let res = await axios.post('?a=AdminAjax&m=deletePicture',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			console.log(res.data);
			if(res.data.state=='succ'){
				this.$message({message: res.data.info,type: 'success'});
			}else {
				this.itemNameHeader.deleteBtnFlag=true;
				this.$message({message: res.data.info,type: 'warning'});
			}
			setTimeout(()=>{
				window.location.href='?a=picture&type=1';
			},1000)
		}

	},

	computed:{

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
