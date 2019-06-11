


(function(){



var doc=document;
var link=doc.createElement("link");
link.setAttribute("rel", "stylesheet");
link.setAttribute("type", "text/css");
link.setAttribute("href", 'view/admin/components/upFileButton/index.css');

var heads = doc.getElementsByTagName("head");
if(heads.length) heads[0].appendChild(link);
else doc.documentElement.appendChild(link);


Vue.component('upFileButton',{
	template:`
			<div class="upButton">
				<el-upload
					class="upload-demo"
					action="?a=AdminAjax&m=upImg"
					:on-success="handleSuccess"
					:on-progress="handleProgres"
					:before-upload="handleBeforeUpload"
					:on-error="handleError"
					multiple
					:accept="upImage.accept"
					name="file"
					:data="upImage.data"
					:show-file-list=false
					ref="upFileBtn"
					:limit="10">
					<el-button size="small" type="primary">点击上传<i class="el-icon-upload el-icon--right"></i></el-button>
				</el-upload>

				<div class="upItem" v-if="Object.keys(upImage.fileData).length>0">
					<div class="upItem-item" v-for="(item,key) in upImage.fileData" :key="item.id">
						<span class="name">{{item.name}}</span>
						<span class="size">({{item.size}})</span>
						<span class="progress">
							<el-progress :percentage="item.progress" :stroke-width="6"  :text-inside="true"></el-progress>
						</span>
						<span class="cancel" @click="cancelUpFile(item.uid)" v-if="item.loading=='send'" >取消</span>
						<span class="abort" v-if="item.loading=='abort'" ><i class="iconfont iconquxiaoshangchuan-"></i></span>
						<span class="loading" v-else-if="item.loading=='loading'" ><i class="iconfont iconloading"></i></span>
						<span class="error" v-else-if="item.loading=='error'" ><i class="iconfont iconshangchuanshibai"></i></span>
						<span class="success" v-else-if="item.loading=='success'" ><i class="iconfont iconshangchuanchenggong"></i></span>
					</div>
				</div>
			</div>
	`,
	props:[
		'upType','upSize','upData','upAccept'
	],
	data(){
		return {
				upImage:{
					type:this.upType!=undefined ? this.upType : [],
					size:this.upSize!=undefined ? this.upSize : 5,
					data:this.data!=undefined ? this.data : {},
					accept:this.upAccept!=undefined ? this.upAccept : "image/gif, image/jpeg,image/png,image/jpg",
					fileData:{},
					fileList:[] // 组件返回的文件列表，用于 取消文件 上传
				}
			}
	},
	watch:{
		'upData'(){
			this.upImage.data=this.upData;
		}
	},
	created(){
		
	},
	methods:{
		handleSuccess(res,file,fileList){
			this.$set(this.upImage.fileData[file.uid],'loading','success');
			console.log(this.upImage.data)
			this._upFileComplete();
			console.log(res)
			
		},
		_upFileComplete(){

			//状态，出现即代表还有文件未完成
			let loadingArr = ['loading','send'];

			//是否刷新页面
			let flag=true;
			for(let i in this.upImage.fileData){
				if(loadingArr.includes(this.upImage.fileData[i].loading)){
					//当前有文件未完成，不能刷新页面
					flag=false;
					break;
				}
			}

			if(flag){
				setTimeout(()=>{
					this.upImage.fileData={};
					this.$emit('upComplete');
				},1000)
			}
		},
		handleError(res,file,fileList){
			this.$set(this.upImage.fileData[file.uid],'loading','error');
			this._upFileComplete();
		},
		cancelUpFile(uid){		//取消文件上传
			this.fileList.forEach((item,index)=>{
				if(item.uid==uid){
					this.$refs.upFileBtn.abort(item);
					this.$set(this.upImage.fileData[uid],'progress',0);
					this.$set(this.upImage.fileData[uid],'loading','abort');
				}
			})
			this._upFileComplete();
		},
		handleProgres(event,file,fileList){
			this.fileList=fileList;
			//file.uid
			//console.log(fileList)
			let loaded = event.loaded;
			let total = event.total;
			let progress = ((loaded/total)*100);
			//console.log(progress);
			//let o = JSON.parse(JSON.stringify(this.upImage.fileData[file.uid]));
			if(progress==100){
				console.log(progress);
				this.$set(this.upImage.fileData[file.uid],'loading','loading');
			}
			this.$set(this.upImage.fileData[file.uid],'progress',progress);
			//console.log(this.upImage.fileData)
		},
		_setFileSize(size){
			let result='';
			if(size/1024 >= 1000){
				result=Math.floor(size/1024/1024*100)/100+'M';
			}else {
				result=Math.floor(size/1024*100)/100+'K';
			}
			return result;
		},
		handleBeforeUpload(file){

			//判断图片类型
			if(!this.upImage.type.includes(file.type)){
				this.$notify({
		          title: '提示',
		          message: '文件格式必须是 png/jpg/gif',
		          type: 'warning',
		          duration: 6000
		        });
		        return false;
			}
			//判断图片大小
			if((file.size/1024/1024)>this.upImage.size){
				this.$notify({
		          title: '提示',
		          message: file.name+'文件大小不得超过'+this.upImage.size+'M',
		          type: 'warning',
		          duration: 6000
		        });
		        return false;
			}


			let size = this._setFileSize(file.size);

			console.log(size);
			let o={
				uid:file.uid,
				name:file.name,
				size,
				loading:'send',
				progress:0
			}
			//this.upImage.fileData[file.uid]=o;
			this.$set(this.upImage.fileData,file.uid,o);
		},
	}



})


})()



















