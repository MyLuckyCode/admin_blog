


(function(){



let doc=document;
var link=doc.createElement("link");
link.setAttribute("rel", "stylesheet");
link.setAttribute("type", "text/css");
link.setAttribute("href", 'view/admin/components/PictrueViewer/index.css');

var heads = doc.getElementsByTagName("head");
if(heads.length) heads[0].appendChild(link);
else doc.documentElement.appendChild(link);


Vue.component('pictrueviewer',{
	template:`
		<div id="PictrueViewer" @click="closePictrueView" >
			
			<div class="PictrueViewer-c" @click.stop>
				<div class="upper a" @click="upper"><i class="iconfont icontubiaozhizuo- "></i></div>
				<div style="position: relative;height:765px;width:1000px;" >
					<div class="close" @click.stop="closePictrueView"><i class="iconfont iconguanbi "></i></div>
					<div class="content">
						<img :src="imgSrc" :style="cImgStyle" alt="" @mousedown.stop="handMouseImg($event)">
					</div>
					<div class="loading" v-show="imgLoading">
						<i class="iconfont iconloading "></i>
					</div>
					<div class="operation">
						<a href="javascript:;" @click="enLarge($event)"><i class="iconfont iconfangda "></i></a>
						<a href="javascript:;" @click="narrow"><i class="iconfont iconsuoxiao "></i></a>
					</div>
				</div>	
				<div class="next a" @click="next"><i class="iconfont icontubiaozhizuo-1 "></i></div>   
			</div>
			                                                                                     
			 
		</div>
	`,
	props:{
		checkBoxIdListAll:{
			type:Object
		},
		index:{
			type:Number,
			default:0
		},
		pictrueviewerflag:{
			type:Boolean
		}
		
	},
	data(){
		return {
			imgArray:[],
			imgIndex:this.index,
			imgSrc:'',
			imgLoading:true,
			imgScale:1,
			cImgStyle:{
				transform:'scale(1)',
				top:0,
				left:0
			},
			cImgSize:{
				top:0,
				left:0
			},
			tempInfo:{
				top:0,
				left:0
			}
		}
	},
	watch:{
		index(){
			console.log(this.index);
			this.imgIndex=this.index;
			this._loadImg();
		}
	},
	methods:{
		closePictrueView(){
			this.$emit('update:pictrueviewerflag',false);
		},
		enLarge(e){
			this.imgScale+=(this.imgScale*0.15);
			if(this.imgScale>10) this.imgScale=10;
			this.$set(this.cImgStyle,'transform','scale('+this.imgScale+')');

		},
		narrow(){
			this.imgScale-=(this.imgScale*0.15);
			if(this.imgScale<0.2) this.imgScale=0.2;
			this.$set(this.cImgStyle,'transform','scale('+this.imgScale+')');
		},
		upper(){
			let index = this.imgIndex;
			this.imgIndex = index<=0 ? (this.imgArray.length-1) : (index-1);
			this._loadImg();
		},
		next(){
			let index = this.imgIndex;
			this.imgIndex = index>=(this.imgArray.length-1) ? 0 : (index+1);
			this._loadImg();
		},
		handMouseImg(evt){
			evt.preventDefault()
			let _left=evt.clientX;
			let _top=evt.clientY;
			document.onmousemove=(evt)=>{
				let _offsetX = evt.clientX-_left;
				let _offsetY = evt.clientY-_top;
				if(this['_MouseImg']!=undefined){
					this['_MouseImg'](_offsetX,_offsetY);
				}
			}
		},
		_setCImgSize(){
			this.$set(this.cImgSize,'left',this.tempInfo.left);
			this.$set(this.cImgSize,'top',this.tempInfo.top);
		},
		_MouseImg(_offsetX,_offsetY){
			let {left,top} = this.cImgSize;
			left = left+_offsetX;
			top = top+_offsetY;
			
			this.$set(this.cImgStyle,'left',left+'px');
			this.$set(this.cImgStyle,'top',top+'px');
			
			this.$set(this.tempInfo,'left',left);	
			this.$set(this.tempInfo,'top',top);	
			
		},
		_loadImg(){
			this._initial();
			this.imgSrc = '?a=images&uniqueId='+this.imgArray[this.imgIndex].uniqueID+'&type=small';
			let imgType = this.imgArray[this.imgIndex].uniqueID.split('.');
			let srcs = '';
			if(imgType[imgType.length-1]=='gif'){
				srcs='./upload/clippingImages/'+this.imgArray[this.imgIndex].uniqueID;
			}else {
				srcs = '?a=images&uniqueId='+this.imgArray[this.imgIndex].uniqueID;
			}

			let img = new Image();
			img.onload=() => {
				this.imgSrc = srcs;
				this.imgLoading = false;
			}
			img.src = srcs;
		},
		_initial(){
			this.imgScale=1;
			this.imgLoading = true;
			this.cImgStyle={
				transform:'scale(1)',
				top:0,
				left:0
			},
			this.cImgSize={
				top:0,
				left:0
			},
			this.tempInfo={
				top:0,
				left:0
			}
		}
		
	},
	created(){
		document.addEventListener('mouseup',()=>{
			document.onmousedown=null;
			document.onmousemove=null;
			this._setCImgSize();
		});
		for(let i in this.checkBoxIdListAll){
			this.imgArray.push(this.checkBoxIdListAll[i])
		}
		this.imgArray.reverse();
		this.imgSrc = '?a=images&uniqueId='+this.imgArray[this.imgIndex].uniqueID+'&type=small';
		this._loadImg();
		console.log(this.imgArray)
	}


})




})()
















