




let beforeunloadFN =function(e){
	e.returnValue="关闭数据将丢失";
};
window.addEventListener('beforeunload',beforeunloadFN)


new Vue({
	el:'.title',
	data:{

	},
	methods:{
		goShow(){
			//window.location.href="?a=article"
			window.history.go(-1);
		}
	}

})



new Vue({
	el:'.form',
	data:{
		form:{
			name:'',
			pid:1,
			content:'这是内容'
		},
		GalleryFlag:false,
		galleryEventType:'',//标识符，点击确定是会返回来，以便确定执行什么事件，比如裁剪，还是添加到编辑器
		GallerySelect:'single',	// 确定是单选还是多选  muitiple 是多选
		Tailoringflag:false,
		tailoringEventType:'',
		clippingInfo:{},
		editorImg:null,
		addArticleBth:true
	},
	methods:{
		openGallery(eventType){
			this.galleryEventType=eventType;
			if(eventType=='editor'){
				this.GallerySelect='muitiple';
			}else if(eventType=='imgReplace'){
				this.GallerySelect='single';
			}
			this.GalleryFlag=true;
		},
		openTailoring(eventType){
			this.tailoringEventType=eventType;
			if(eventType=='editorClipping'){
				this.clippingInfo={proportion:false,compute:'img'}
			}
			this.Tailoringflag=true;
		},
		galleryConfirm(list,eventType){
			
			if(eventType=='editor'){
				for(let i in list){
					if(list[i].type=='gif'){
						this.editor.cmd.do('insertHTML', `<img src="./upload/clippingImages/${list[i].uniqueId}" Lsrc="?a=images&uniqueId=${list[i].uniqueId}" style="max-width:100%;"/>`)
					}else {
						this.editor.cmd.do('insertHTML', `<img src="?a=images&uniqueId=${list[i].uniqueId}" style="max-width:100%;"/>`)
					}
				}
			}else if(eventType=='imgReplace'){
				for(let i in list){
					console.log(list[i].type)
					if(list[i].type=='gif'){
						//this.editor.cmd.do('insertHTML', `<img src="./upload/clippingImages/${list[i].uniqueId}" Lsrc="?a=images&uniqueId=${list[i].uniqueId}" style="max-width:100%;"/>`)
						this.editorImg.Lsrc='?a=images&uniqueId='+list[i].uniqueId;
						this.editorImg.src='./upload/clippingImages/'+list[i].uniqueId;
					}else {
						this.editorImg.src='?a=images&uniqueId='+list[i].uniqueId;
					}
					this.editorImg.style.width='auto';
					this.editorImg.style.height='auto';
				}
			}
		},
		TailoringConfirm(uniqueId,eventType){

			if(eventType=='editorClipping'){
				this.editorImg.src='?a=images&uniqueId='+uniqueId;
				this.editorImg.style.width='auto';
				this.editorImg.style.height='auto';
			}
			
		},
		async postAddPatternItem(){
			
			let form=this.form;
			let format = new Format();
			//form.content = format.htmlparser(this.editor.txt.html())
			form.content = this.editor.txt.html();
			if(form.content==''){
				this.$notify({title:'提示',message: '请写内容',type: 'warning'});
		        return ;
			}

			this.addArticleBth=false;

			let data = new FormData();
			for(let i in form){
				data.append(i,form[i]);
			}

			let res = await axios.post('./api/admin/v1.0/?a=pattern&m=addPatternItem',data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
			if(res.data.state=='succ'){
				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 0
		        });
				setTimeout(()=>{
					window.removeEventListener('beforeunload',beforeunloadFN)
					location.href='?a=pattern';
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
	},
	mounted(){
		let E=window.wangEditor;
		this.editor = new E('.content');

		this.editor.create();
		this.editor.addTabEvent('image',()=>{
		    console.log('执行自定义的IMG事件')
		    this.openGallery('editor');
		   // this.editor.cmd.do('insertHTML', `<img src="http://pic32.nipic.com/20130823/13339320_183302468194_2.jpg" style="max-width:100%;"/>`)
		})

		let that=this;

		this.editor.addTextElement('imgClipping',function(){


			let src = this.getAttribute('src');
			let arr = src.split('.');
            if(arr[arr.length-1] == 'gif'){
            	that.clippingImageUrl=this.getAttribute('Lsrc');
            }else {
            	that.clippingImageUrl=this.getAttribute('src');
            }
		    that.openTailoring('editorClipping');
		    that.editorImg=this;
		});

		this.editor.addTextElement('imgReplace',function(){
		     that.openGallery('imgReplace');
		     that.editorImg=this;
		});

	}
})





function offsetTop(element){
	let top = element.offsetTop;
	let parset=element.offsetParent;
	while(parset!=null){
		top+=parset.offsetTop;
		parset=parset.offsetParent;
	}
	return top;
}

// function offsetTop(element){
// 	var top=element.offsetTop;
// 	var parent=element.offsetParent;
// 	while(parent!=null){
// 		top+=parent.offsetTop;
// 		parent=parent.offsetParent;
// 	}
// 	return top;
// }
































