


(function(){



let doc=document;
var link=doc.createElement("link");
link.setAttribute("rel", "stylesheet");
link.setAttribute("type", "text/css");
link.setAttribute("href", 'view/admin/components/Format/index.css');

var heads = doc.getElementsByTagName("head");
if(heads.length) heads[0].appendChild(link);
else doc.documentElement.appendChild(link);


Vue.component('Format',{
	template:`
		<div id="Format">
			<div class="Format-img-dialog-wrapper">
				<div class="Format-dialog-hd">
					<h3>选择版式</h3>
					<i class="iconfont iconguanbi Format-close" @click="closeFormat"></i>
				</div>
				<div class="Format-dialog-bd">
					<div class="Format-side">
						<div class="Format-pictureList-loading" v-if="side.pictureList.length==0"><i class="iconfont iconloading"></i></div>
						<ul>
							<li v-for="(item,key) in side.pictureList" :class="{'active':side.activeItem.id==item.id}" :key="key" @click="handleTagPicture(item)" >
								<span class="Format-name" >{{item.name}}</span>
								<span class="Format-count" >({{item.count}})</span>
							</li>
						</ul>
					</div>
					<div class="Format-main">
						<div class="Format-sub-title-bar">
						</div>
						<div class="Format-imgList-loading" v-if="pictureItem.list.length<=0"><i class="iconfont iconloading"></i></div>
						<div class="Format-img-pick-area-inner" v-else-if="pictureItem.list.length>0">

							<ul class="Format-imgList">
								<li class="Format-imgItem" v-for="item in pictureItem.list" @click="handleSelectItem(item)">
									<div class="Format-imgItem-content" v-html="item.content"></div>
									<div class="Format-active iconfont icondui" v-if="pictureItem.selectList.hasOwnProperty('id'+item.id)"></div>
								</li>
							</ul>
							<el-pagination class="Format-page" v-if="side.activeItem.count>=page.size"
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
				<div class="Format-dialog-ft">
					 	<button class="Format-primary Format-button Format-primary-disabled" @click="handleConfirm">确定</button>
					 	<button class="Format-cancel Format-button" @click="closeFormat" >取消</button>
	    				<div class="Format-num">
							已选 {{Object.keys(pictureItem.selectList).length}} 个
	    				</div>
				</div>
			</div>
		</div>
	`,
	props:[
		'formatflag','select','eventType'
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
					size:9
				},
				ajax:[]			//存储ajax请求对象，用于取消ajax请求
			}
	},
	methods:{
		closeFormat(){
			this.$emit('update:formatflag',false)
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
			let res = await axios.post('./api/admin/v1.0/?a=pattern&m=getPatternItem',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				 cancelToken: source.token
			});
			this.ajax['getPictureItem']=null;

			this.pictureItem.list=res.data;
			console.log(res)
		},
		async _getPictureList(){
			this.side.pictureList=[];
			let res = await axios.get('./api/admin/v1.0/?a=pattern&m=getPatternList');
			this.side.pictureList=res.data;
			let count=0;
			res.data.forEach(item =>{
				count += parseInt(item.count);
			})
			let o ={name:'全部版式',count,id:0}; 
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
			this.closeFormat();
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
















