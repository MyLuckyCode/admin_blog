


(function(){



let doc=document;
var link=doc.createElement("link");
link.setAttribute("rel", "stylesheet");
link.setAttribute("type", "text/css");
link.setAttribute("href", 'view/admin/components/Tailoring/index.css');

var heads = doc.getElementsByTagName("head");
if(heads.length) heads[0].appendChild(link);
else doc.documentElement.appendChild(link);



Vue.component('Tailoring',{
	template:`
		<div id="Tailoring">
			<div class="img-dialog-wrapper">
				<div class="dialog-hd">
					<h3>裁剪图片</h3>
					<i class="iconfont iconguanbi close" @click="closeTailoring"></i>
				</div>
				<div class="dialog-bd">
					<div class="side">
						<div class="img-frame">
							<div class="bg_img" :style="style.bgImgStyle">
								<img :src="src" alt="" v-if="loadingImage" />
								<div class="mask" v-if="loadingImage" ></div>
								<div class="load" v-if="!loadingImage" ><i class="iconfont iconloading"></i></div>
							</div>
							<div class="work" :style="style.bgImgStyle" v-if="loadingImage">
								<div class="clippingBox" :style="style.clippingBoxStyle">
									<img :src="src" alt="" ondragstart="return false;" :style="style.clippingBoxImgStyle" />
									<div class="jcrop-hline top"></div>
									<div class="jcrop-hline right"></div>
									<div class="jcrop-hline bottom"></div>
									<div class="jcrop-hline left"></div>
								</div>
								<div class="clippingControlBox" :style="style.clippingBoxStyle" @mousedown.stop="setImageSize('_clippingControlBox',$event)" >
									<div class="jcrop-dragbar top" @mousedown.stop="setImageSize('_dragbarTop',$event)"></div>
									<div class="jcrop-dragbar right" @mousedown.stop="setImageSize('_dragbarRight',$event)"></div>
									<div class="jcrop-dragbar bottom" @mousedown.stop="setImageSize('_dragbarBottom',$event)"></div>
									<div class="jcrop-dragbar left" @mousedown.stop="setImageSize('_dragbarLeft',$event)"></div>
									<div class="jcrop-dragbarBox topLeft" @mousedown.stop="setImageSize('_dragTopLeft',$event)"></div>
									<div class="jcrop-dragbarBox topRight" @mousedown.stop="setImageSize('_dragTopRight',$event)"></div>
									<div class="jcrop-dragbarBox bottomLeft" @mousedown.stop="setImageSize('_dragBottomLeft',$event)"></div>
									<div class="jcrop-dragbarBox bottomRight" @mousedown.stop="setImageSize('_dragBottomRight',$event)"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="main">
						<div class="imgView">
							<img :src="newUrl" alt="" v-if="loadingImage" />
							<div class="load" v-if="!loadingImage"><i class="iconfont iconloading"></i></div>
						</div>
					</div>
				</div>
				<div class="dialog-ft">
				 	<el-button class="primary button" :loading="!confirmBtnFlag" style="padding-top:0;" @click="postClippingImage" >确定</el-button>
				 	<button class="cancel button" @click="closeTailoring" >取消</button>
				</div>
			</div>
		</div>
	`,
	props:[
		'tailoringflag','src','clippingInfo','eventType'
	],
	data(){
		return {
				newUrl:'',
				loadingImage:false,
				style:{
					bgImgStyle:{},
					clippingBoxStyle:{},
					clippingBoxImgStyle:{}
				},
				size:{
					clippingBoxSize:{}
				},
				confirmBtnFlag:true,
				clippingBoxInfo:this.clippingInfo!=undefined ? this.clippingInfo : {width:1,height:2,proportion:false,compute:'img'},	//img 表示图片本身大小来计算 
				tempInfo:{}		//用于存储临时的信息 left,top,width,height
			}
	},
	watch:{
		'clippingInfo'(){
			this.clippingBoxInfo=this.clippingInfo;
		}
	},
	methods:{
		closeTailoring(){
			this.$emit('update:tailoringflag',false)
		},
		async postClippingImage(){
			this.confirmBtnFlag=false;
			let imgInfo = await this._loadingImage(this.src);
			let tempInfo = this.tempInfo;
			
			let largeHeight,largeWidth,newWidth,newHeight,x,y;

			if(this.clippingBoxInfo.compute=='img'){

				//  采用这种算法，则图片的大小是按原图来计算的，不是按 clippingBoxInfo 里面的 大小，而是按 clippingBoxInfo 的比例
				largeHeight = imgInfo.largeHeight;
				largeWidth = imgInfo.largeWidth;

				newWidth = tempInfo.width*imgInfo.proportion;
				newHeight = tempInfo.height*imgInfo.proportion;
				
				x = tempInfo.left*imgInfo.proportion;
				y = tempInfo.top*imgInfo.proportion; 
			}else {

				largeWidth = (imgInfo.width/tempInfo.width)*this.clippingBoxInfo.width;
				largeHeight = (imgInfo.height/tempInfo.height)*this.clippingBoxInfo.height;
			
				newWidth = this.clippingBoxInfo.width;
				newHeight = this.clippingBoxInfo.height;

				x = (tempInfo.left/tempInfo.width)*this.clippingBoxInfo.width;
				y = (tempInfo.top/tempInfo.height)*this.clippingBoxInfo.height;
			}
			

			let o = {largeWidth,largeHeight,newWidth,newHeight,x,y,url:this.src};
			console.log(this.src)
			let data = new FormData();

			for(let i in o){
				data.append(i,o[i]);
			}
			console.log(data)

			let res = await axios.post('?a=AdminAjax&m=postClippingImage',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			if(res.data.state=='succ'){

				this.$emit('confirm',res.data.uniqueId,this.eventType);
				this.closeTailoring();
			}else {
				this.$notify({
		          	title: '提示',
		          	message: res.data.info,
		          	type: 'warning',
		          	duration: 2000
		        });
		        this.confirmBtnFlag=true;
			}

		},
		async _getClippingImage(){	//获取裁剪后的图片
			let canvas = document.createElement('canvas')
      		let ctx = canvas.getContext('2d')
      		let imgInfo = await this._loadingImage(this.src);
      		let tempInfo = this.tempInfo;
	        canvas.width = tempInfo.width;
	        canvas.height = tempInfo.height;
	        ctx.drawImage(imgInfo.file, -tempInfo.left,-tempInfo.top, imgInfo.width, imgInfo.height)
	        this.newUrl = canvas.toDataURL('image/jpeg',1);
		},

		_loadingImage(src){		//加载一张图片并获取其在容器的宽高
			let that=this;
			return new Promise((resolve,reject)=>{
				let img = new Image();
				img.onload=function(){
					let largeWidth = this.width;
					let largeHeight = this.height;
					let width=0;
					let height=0;
					if(this.height>this.width){
						width = this.width*(226/this.height); 
						height=226
					}else if(this.height<this.width){
						height = this.height*(245/this.width);
						width=245;
					}else if(this.height==this.width){
						width=226;
						height=226;
					}
					let proportion = this.width/width;
					that.loadingImage=true
					resolve({width,height,file:this,largeWidth,largeHeight,proportion})
				}
				img.src=src;
			})
			
		},
		setImageSize(type,evt){
			let _left=evt.clientX;
			let _top=evt.clientY;
			document.onmousemove=(evt)=>{
				let _offsetX = evt.clientX-_left;
				let _offsetY = evt.clientY-_top;
				if(this[type]!=undefined){
					this[type](_offsetX,_offsetY);
				}
			}

			//if(type=='top') this._top();
		},
		_setTempInfo(obj){
			this.$set(this.tempInfo,'left',obj.left);	
			this.$set(this.tempInfo,'top',obj.top);	
			this.$set(this.tempInfo,'width',obj.width);	
			this.$set(this.tempInfo,'height',obj.height);
			this._getClippingImage();	
		},
		_setClippingBoxSize(){
			this.$set(this.size.clippingBoxSize,'left',this.tempInfo.left);
			this.$set(this.size.clippingBoxSize,'top',this.tempInfo.top);
			this.$set(this.size.clippingBoxSize,'width',this.tempInfo.width);
			this.$set(this.size.clippingBoxSize,'height',this.tempInfo.height);
		},
		_setClippingBoxStyle(obj){
			this.$set(this.style.clippingBoxStyle,'left',obj.left+'px');
			this.$set(this.style.clippingBoxStyle,'top',obj.top+'px');
			this.$set(this.style.clippingBoxStyle,'width',obj.width+'px');
			this.$set(this.style.clippingBoxStyle,'height',obj.height+'px');

			this.$set(this.style.clippingBoxImgStyle,'left',-(obj.left)+'px');
			this.$set(this.style.clippingBoxImgStyle,'top',-(obj.top)+'px');
		},
		_clippingControlBox(_offsetX,_offsetY){
			let {left,top,width,height} = this.size.clippingBoxSize;
			left = left+_offsetX;
			top = top+_offsetY;
			top = top<=0 ? 0 : (top+height)>=this.size.bgImgSize.height ? (this.size.bgImgSize.height-height) : top;
			left = left<=0 ? 0 : (left+width)>=this.size.bgImgSize.width ? (this.size.bgImgSize.width-width) : left;

			
			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});
			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});
		},
		_dragbarTop(_offsetX,_offsetY){

			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;

			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;
				
			if(_offsetY>=(height-10)){
				top=top+height-10;
				height=10;
			} else {
				let latheight = top+height
				top = height+(-_offsetY) >= latheight ? 0 :  top+_offsetY;
				height = height+(-_offsetY) >= latheight ? latheight :  height+(-_offsetY);	
			}


			if(this.clippingBoxInfo.proportion){	//按比例缩放
				let step = (-_offsetY)>=tempTop ? tempTop : (-_offsetY);
				
				
				if(tempWidth>tempHeight){
					width = width + (step/proportion)

					
				}else if(tempHeight>tempWidth){
					width = width + (step*proportion)
					
				}else if(tempHeight==tempWidth){
					width=width+step;
				}

				if(width>=(bgImgSize.width-left)){
					width = (bgImgSize.width-left);
					height = tempHeight + ((width-tempWidth)/tempWidth)*tempHeight
					top = bgImgSize.height-height-(bgImgSize.height-tempHeight-tempTop)
					left=tempLeft;
				}
			}

			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});
			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});

		},
		_dragbarLeft(_offsetX,_offsetY){

			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;
			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;
				
			if(_offsetX>=(width-10)){
				left=left+width-10;
				width=10;
			} else {
				let latwidth = left+width
				left = width+(-_offsetX) >= latwidth ? 0 :  left+_offsetX;
				width = width+(-_offsetX) >= latwidth ? latwidth :  width+(-_offsetX);
				
			}
				
			if(this.clippingBoxInfo.proportion){	//按比例缩放
				let step = (-_offsetX)>=tempLeft ? tempLeft : (-_offsetX);
				
				if(tempWidth>tempHeight){
					height = height + (step*proportion)
				}else if(tempHeight>tempWidth){
					height = height + (step/proportion)
				}else if(tempHeight==tempWidth){
					height=height+step;
				}


				if(height>=(bgImgSize.height-top)){
					height = (bgImgSize.height-top);
					top=tempTop;
					width = tempWidth + ((height-tempHeight)/tempHeight)*tempWidth
					left = bgImgSize.width-width-(bgImgSize.width-tempWidth-tempLeft);
				}

			}


			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});
			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});

		},
		_dragbarRight(_offsetX,_offsetY){

			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;
			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;
				
			let latwidth = bgImgSize.width-left;
			width = width+_offsetX >= latwidth ? latwidth :  width+_offsetX;
			if(width<=10) width=10;


			if(this.clippingBoxInfo.proportion){	//按比例缩放
				let step = (_offsetX)>=(bgImgSize.width-left-tempWidth) ? (bgImgSize.width-left-tempWidth) : (_offsetX);
				
				if(tempWidth>tempHeight){
					height = height + (step*proportion)
					console.log(step)
				}else if(tempHeight>tempWidth){
					height = height + (step/proportion)
				}else if(tempHeight==tempWidth){
					height=height+step;
				}

				if(height>=(bgImgSize.height-top)){

					height = (bgImgSize.height-top);
					top=tempTop;
					left =tempLeft;
					width = tempWidth + ((height-tempHeight)/tempHeight)*tempWidth
					console.log(top,left);
				}
			}


			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});
			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});

		},
		_dragbarBottom(_offsetX,_offsetY){

			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;
			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;


			let latheight = bgImgSize.height-top;
			height = height+_offsetY >= latheight ? latheight :  height+_offsetY;
			if(height<=10) height=10;

			if(this.clippingBoxInfo.proportion){
				let step = (_offsetY)>=(bgImgSize.height-tempTop-tempHeight) ? (bgImgSize.height-tempTop-tempHeight) : (_offsetY);
				
				
				if(tempWidth>tempHeight){
					width = width + (step/proportion)

				}else if(tempHeight>tempWidth){
					width = width + (step*proportion)
					
				}else if(tempHeight==tempWidth){
					width=width+step;
				}

				if(width>=(bgImgSize.width-left)){
					width = (bgImgSize.width-left);
					height = tempHeight + ((width-tempWidth)/tempWidth)*tempHeight
					top = tempTop
					left=tempLeft;
				}
			}

			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});
			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});

		},
		_dragTopLeft(_offsetX,_offsetY){
			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;

			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;

			if(this.clippingBoxInfo.proportion){

					if(_offsetY>=(height-10)){
						top=top+height-10;
						height=10;
					} else {
						let latheight = top+height
						top = height+(-_offsetY) >= latheight ? 0 :  top+_offsetY;
						height = height+(-_offsetY) >= latheight ? latheight :  height+(-_offsetY);	
					}

					let step = (-_offsetY)>=tempTop ? tempTop : (-_offsetY);
				
					if(tempWidth>tempHeight){
						width = width + (step/proportion)

					}else if(tempHeight>tempWidth){
						width = width + (step*proportion)
						
					}else if(tempHeight==tempWidth){
						width=width+step;
					}
	
					left = bgImgSize.width-width-(bgImgSize.width-tempWidth-tempLeft);
					left = left <=0 ? 0 : left;
					if(width>=(bgImgSize.width-left-(bgImgSize.width-tempWidth-tempLeft))){
						width = bgImgSize.width-left-(bgImgSize.width-tempWidth-tempLeft);
						height = tempHeight + ((width-tempWidth)/tempWidth)*tempHeight;
						left = bgImgSize.width-width-(bgImgSize.width-tempWidth-tempLeft);
						top= bgImgSize.height-height-(bgImgSize.height-tempHeight-tempTop)
					}			
				
			}else{
				if(_offsetY>=(height-10)){
					top=top+height-10;
					height=10;
				} else {
					let latheight = top+height
					top = height+(-_offsetY) >= latheight ? 0 :  top+_offsetY;
					height = height+(-_offsetY) >= latheight ? latheight :  height+(-_offsetY);	
				}

				if(_offsetX>=(width-10)){
					left=left+width-10;
					width=10;
				} else {
					let latwidth = left+width
					left = width+(-_offsetX) >= latwidth ? 0 :  left+_offsetX;
					width = width+(-_offsetX) >= latwidth ? latwidth :  width+(-_offsetX);
				}

			}

			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});

			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});

		},
		_dragTopRight(_offsetX,_offsetY){
			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;

			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;


			if(this.clippingBoxInfo.proportion){
				
				if(_offsetY>=(height-10)){
					top=top+height-10;
					height=10;
				} else {
					let latheight = top+height
					top = height+(-_offsetY) >= latheight ? 0 :  top+_offsetY;
					height = height+(-_offsetY) >= latheight ? latheight :  height+(-_offsetY);	
				}

				let step = (-_offsetY)>=tempTop ? tempTop : (-_offsetY);
			
				if(tempWidth>tempHeight){
					width = width + (step/proportion)

				}else if(tempHeight>tempWidth){
					width = width + (step*proportion)
					
				}else if(tempHeight==tempWidth){
					width=width+step;
				}
				if(width>=(bgImgSize.width-left)){
					width = bgImgSize.width-left;
					height = tempHeight + ((width-tempWidth)/tempWidth)*tempHeight;
					top= bgImgSize.height-height-(bgImgSize.height-tempHeight-tempTop)
				}	

			}else{

				if(_offsetY>=(height-10)){
					top=top+height-10;
					height=10;
				} else {
					let latheight = top+height
					top = height+(-_offsetY) >= latheight ? 0 :  top+_offsetY;
					height = height+(-_offsetY) >= latheight ? latheight :  height+(-_offsetY);	
				}

				if(_offsetX>=(width-10)){
					left=left+width-10;
					width=10;
				} else {
					let latwidth = bgImgSize.width-left;
					width = width+_offsetX >= latwidth ? latwidth :  width+_offsetX;
					if(width<=10) width=10;
					
				}
			}

			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});

			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});
		},
		_dragBottomLeft(_offsetX,_offsetY){
			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;

			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;

			if(this.clippingBoxInfo.proportion){

				let latheight = bgImgSize.height-top;
				height = height+_offsetY >= latheight ? latheight :  height+_offsetY;
				if(height<=10) height=10;

				let step = (_offsetY)>=tempTop ? tempTop : (_offsetY);
				console.log(step)
				if(tempWidth>tempHeight){
					width = width + (step/proportion)

				}else if(tempHeight>tempWidth){
					width = width + (step*proportion)
					
				}else if(tempHeight==tempWidth){
					width=width+step;
				}

				left = bgImgSize.width-width-(bgImgSize.width-tempWidth-tempLeft);
				left = left <=0 ? 0 : left;
				if(width>=(bgImgSize.width-left-(bgImgSize.width-tempWidth-tempLeft))){
					width = bgImgSize.width-left-(bgImgSize.width-tempWidth-tempLeft);
					height = tempHeight + ((width-tempWidth)/tempWidth)*tempHeight;
					left = bgImgSize.width-width-(bgImgSize.width-tempWidth-tempLeft);
				}
				
			}else{

				if(_offsetX>=(width-10)){
					left=left+width-10;
					width=10;
				} else {
					let latwidth = left+width
					left = width+(-_offsetX) >= latwidth ? 0 :  left+_offsetX;
					width = width+(-_offsetX) >= latwidth ? latwidth :  width+(-_offsetX);	
				}

				let latheight = bgImgSize.height-top;
				height = height+_offsetY >= latheight ? latheight :  height+_offsetY;
				if(height<=10) height=10;

			}

			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});

			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});
		},
		_dragBottomRight(_offsetX,_offsetY){
			let bgImgSize = this.size.bgImgSize;

			let {left,top,width,height,proportion} = this.size.clippingBoxSize;

			let tempHeight=height,tempWidth=width,tempTop=top,tempLeft=left;


			if(this.clippingBoxInfo.proportion){

				let latheight = bgImgSize.height-top;
				height = height+_offsetY >= latheight ? latheight :  height+_offsetY;
				if(height<=10) height=10;

				let step = (_offsetY)>=tempTop ? tempTop : (_offsetY);

				if(tempWidth>tempHeight){
					width = width + (step/proportion)

				}else if(tempHeight>tempWidth){
					width = width + (step*proportion)
					
				}else if(tempHeight==tempWidth){
					width=width+step;
				}

				if(width>=(bgImgSize.width-left)){
					width = bgImgSize.width-left;
					height = tempHeight + ((width-tempWidth)/tempWidth)*tempHeight;
					
				}
				
			}else{

				let latwidth = bgImgSize.width-left;
				width = width+_offsetX >= latwidth ? latwidth :  width+_offsetX;
				if(width<=10) width=10;

				let latheight = bgImgSize.height-top;
				height = height+_offsetY >= latheight ? latheight :  height+_offsetY;
				if(height<=10) height=10;
				

			}

			//设置大小位置样式
			this._setClippingBoxStyle({width,height,left,top});

			//临时存储，用于鼠标松开时用
			this._setTempInfo({width,height,top,left});
		}


	},
	async created(){
		document.addEventListener('mouseup',()=>{
			this._setClippingBoxSize();
			document.onmousedown=null;
			document.onmousemove=null;
		});

		//this.src= 'http://localhost/smarty/admin_blog/upload/images/20190510/15574618466Pvg.png';
		let imgInfo = await this._loadingImage(this.src);
		this.style.bgImgStyle={
			width:imgInfo.width+'px',
			height:imgInfo.height+'px',
			left:(245-imgInfo.width)/2+'px',
			top:(226-imgInfo.height)/2+'px'
		}
		this.size.bgImgSize={
			width:imgInfo.width,
			height:imgInfo.height
		}


		//获取裁剪框比例计算裁剪框的大小，
		let box=this.clippingBoxInfo;
		if(box.height==undefined) box.height=imgInfo.largeHeight
		if(box.width==undefined) box.width=imgInfo.largeWidth
		let boxs={};
		if(box.width > box.height){

			boxs.height=(box.height/box.width)*imgInfo.width;
			if(boxs.height>imgInfo.height){
				boxs.width=(box.width/box.height)*imgInfo.height;
				boxs.height=imgInfo.height;
				boxs.proportion=(box.height/box.width);
			}else{
				boxs.height=(box.height/box.width)*imgInfo.width;
				boxs.width=imgInfo.width;
				boxs.proportion=(box.height/box.width);
			}


		
		}else if(box.height > box.width){
			
			boxs.width=(box.width/box.height)*imgInfo.height;
			if(boxs.width>imgInfo.width){
				boxs.width=(box.width/box.height)*imgInfo.height;
				boxs.height=imgInfo.height;
				boxs.proportion=(box.width/box.height);
			}else {
				boxs.width=(box.width/box.height)*imgInfo.height;
				boxs.height=imgInfo.height;
				boxs.proportion=(box.width/box.height);
			}

		}else if(box.height==box.width){
			boxs.proportion=1;
			if(imgInfo.width>imgInfo.height){
				boxs.width=boxs.height=imgInfo.height;
			}else {
				boxs.width=boxs.height=imgInfo.width;
			}
		}


		this.style.clippingBoxStyle={
			width:boxs.width+'px',
			height:boxs.height+'px',
			left:(imgInfo.width-boxs.width)/2+'px',
			top:(imgInfo.height-boxs.height)/2+'px'
		}

		this.style.clippingBoxImgStyle={
			width:imgInfo.width+'px',
			height:imgInfo.height+'px',
			left:-(imgInfo.width-boxs.width)/2+'px',
			top:-(imgInfo.height-boxs.height)/2+'px'
		}

		this.size.clippingBoxSize={
			width:boxs.width,
			height:boxs.height,
			left:(imgInfo.width-boxs.width)/2,
			top:(imgInfo.height-boxs.height)/2,
			proportion:boxs.proportion
		}

		this.tempInfo={
			width:boxs.width,
			height:boxs.height,
			left:(imgInfo.width-boxs.width)/2,
			top:(imgInfo.height-boxs.height)/2
		}

		this._getClippingImage();

	}



})




})()
















