


(function(){



let doc=document;
var link=doc.createElement("link");
link.setAttribute("rel", "stylesheet");
link.setAttribute("type", "text/css");
link.setAttribute("href", 'view/admin/components/Gallery/index.css');

var heads = doc.getElementsByTagName("head");
if(heads.length) heads[0].appendChild(link);
else doc.documentElement.appendChild(link);


Vue.component('Gallery',{
	template:`
		<div id="gallery">
			<div class="Gallery-img-dialog-wrapper">
				<div class="Gallery-dialog-hd">
					<h3>选择图片</h3>
					<i class="iconfont iconguanbi Gallery-close" @click="closeGallery"></i>
				</div>
				<div class="Gallery-dialog-bd">
					<div class="Gallery-side">
						<div class="Gallery-pictureList-loading" v-if="side.pictureList.length==0"><i class="iconfont iconloading"></i></div>
						<ul>
							<li v-for="(item,key) in side.pictureList" :class="{'active':side.activeItem.id==item.id}" :key="key" @click="handleTagPicture(item)" >
								<span class="Gallery-name" >{{item.name}}</span>
								<span class="Gallery-count" >({{item.count}})</span>
							</li>
						</ul>
					</div>
					<div class="Gallery-main">
						<div class="Gallery-sub-title-bar">
							<upfilebutton
								:up-size="5"
								:up-type="['image/png','image/jpeg','image/jpg','image/gif']"
								:up-data="{pid:(pictureItem.type !=0 ? pictureItem.type : 1)}"
								@up-complete="upComplete"
							/>
						</div>
						<div class="Gallery-imgList-loading" v-if="pictureItem.list.length<=0"><i class="iconfont iconloading"></i></div>
						<div class="Gallery-img-pick-area-inner" v-else-if="pictureItem.list.length>0">

							<ul class="Gallery-imgList">
								<li class="Gallery-imgItem" v-for="item in pictureItem.list" @click="handleSelectItem(item)">
									<label>{{item.activeFlag}}

										<img class="Gallery-img" :src="'./upload/clippingImages/'+item.uniqueId" alt="" v-if="item.type=='gif'" />
										<img class="Gallery-img" :src="'?a=images&uniqueId='+item.uniqueId+'&type=small'" alt="" v-else />
										<div class="Gallery-active iconfont icondui" v-if="pictureItem.selectList.hasOwnProperty('id'+item.id)"></div>
									</label>
									<span class="Gallery-name">{{item.name}}</span>
								</li>
							</ul>
							<el-pagination class="Gallery-page" v-if="side.activeItem.count>=page.size"
								@current-change="handleCurrentChange"
							    :current-page="page.currentPage"
							    :page-size="page.size"
							    :pager-count="5"
							    layout="prev, pager, next, jumper"
							    :total="page.total">
							</el-pagination>
						</div>
						
					</div>
				</div>
				<div class="Gallery-dialog-ft">
					 	<button class="Gallery-primary Gallery-button Gallery-primary-disabled" @click="handleConfirm">确定</button>
					 	<button class="Gallery-cancel Gallery-button" @click="closeGallery" >取消</button>
	    				<div class="Gallery-num">
							已选 {{Object.keys(pictureItem.selectList).length}} 个
	    				</div>
				</div>
			</div>
		</div>
	`,
	props:[
		'galleryflag','select','eventType'
	],
	data(){
		return {
				side:{
					pictureList:[],
					activeItem:{}
				},
				pictureItem:{
					list:[],
					type:0,
					selectList:{},
					choice:this.select != undefined ? this.select : 'muitiple'		//单选还是多选 ，single 是单选 默认是多选
 				},
				page:{
					currentPage:1,
					total:20,
					size:10
				},
				ajax:[]			//存储ajax请求对象，用于取消ajax请求
			}
	},
	methods:{
		closeGallery(){
			this.$emit('update:galleryflag',false)
		},
		upComplete(){
			console.log('回调函数')
			this._getPictureList();
			this.side.pictureList.forEach(item =>{
				if(item.id==this.side.activeItem.id){
					this.side.activeItem=item;
				}
			})
			this._getPictureItem();
		},
		handleTagPicture(item){

			if(this.side.activeItem.id==item.id){
				console.log('不操作');
				return;
			}
			this.side.activeItem=item;
			console.log(this.side.activeItem.id)
			this.pictureItem.type=item.id;
			this.page.total=parseInt(item.count);
			this.page.currentPage=1;
			this._getPictureItem();
		},
		async _getPictureItem(){
			this.pictureItem.list=[];
			let data = new FormData();
			data.append('type',this.pictureItem.type);
			data.append('currentPage',this.page.currentPage);
			data.append('pageSize',this.page.size);


			if(this.ajax['getPictureItem']!=null){
				this.ajax['getPictureItem'].cancel();
			}


			var CancelToken = axios.CancelToken;
			var source = CancelToken.source();
			this.ajax['getPictureItem']=source;
			let res = await axios.post('?a=AdminAjax&m=getPictureItem',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				 cancelToken: source.token
			});
			this.ajax['getPictureItem']=null;

			this.pictureItem.list=res.data;
			console.log(res)
		},
		async _getPictureList(){
			this.side.pictureList=[];
			let res = await axios.get('?a=AdminAjax&m=getPictureList');
			this.side.pictureList=res.data;
			let count=0;
			res.data.forEach(item =>{
				count += parseInt(item.count);
			})
			let o ={name:'全部相册',count,id:0}; 
			this.side.pictureList.unshift(o);
		},
		handleCurrentChange(e){
			this.page.currentPage=e;
			this._getPictureItem();
		},
		handleSelectItem(item){
			if(this.pictureItem.selectList.hasOwnProperty('id'+item.id)){
				this.$delete(this.pictureItem.selectList,'id'+item.id)
			}else {
				if(this.pictureItem.choice=='single'){
					this.pictureItem.selectList={};
					this.$set(this.pictureItem.selectList,'id'+item.id,item)
				}else if(this.pictureItem.choice=='muitiple'){
					this.$set(this.pictureItem.selectList,'id'+item.id,item)
				}
			}

		},
		handleConfirm(){
			console.log(this.pictureItem.selectList)
			if(Object.keys(this.pictureItem.selectList).length<=0) return;
			this.closeGallery();
			this.$emit('confirm',this.pictureItem.selectList,this.eventType)
		}
	},
	async created(){
		await this._getPictureList();
		this.side.activeItem=this.side.pictureList[0]; 	//默认选择全部相册
		this.page.total=this.side.pictureList[0].count;
		this._getPictureItem();
	}



})




})()
















