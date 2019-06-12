



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
			let query = Url();
			query['page'] = query['page']==undefined ? 1 : query['page'];
			window.location.href="?a=article&page="+query['page']
		}
	}

})



new Vue({
	el:'.form',
	data:{
		form:{
			title:'',
			nav:null,
			label:[],
			keyword:'',
			info:'',
			face:'',
			content:'',
			flagComment:1,
			source:1,
			author:'',
			readCount:0,
			fabulous:0,
			disabled:false
		},
		GalleryFlag:false,
		galleryEventType:'',//标识符，点击确定是会返回来，以便确定执行什么事件，比如裁剪，还是添加到编辑器
		GallerySelect:'single',	// 确定是单选还是多选  muitiple 是多选
		Tailoringflag:false,
		tailoringEventType:'',
		clippingInfo:{width:225,height:150,proportion:true,compute:'info'},
		clippingImageUrl:'',
		articleFaceUrl:'',
		editorImg:null,
		addArticleBth:true
	},
	methods:{
		openGallery(eventType){
			this.galleryEventType=eventType;
			if(eventType=='clipping'){
				this.GallerySelect='single';
			}else if(eventType=='editor'){
				this.GallerySelect='muitiple';
			}else if(eventType=='imgReplace'){
				this.GallerySelect='single';
			}
			this.GalleryFlag=true;
		},
		openTailoring(eventType){
			this.tailoringEventType=eventType;
			if(eventType == 'face'){
				this.clippingInfo = {width:225,height:150,proportion:true,compute:'info'};
			}else if(eventType=='editorClipping'){
				this.clippingInfo={proportion:false,compute:'img'}
			}
			this.Tailoringflag=true;
		},
		galleryConfirm(list,eventType){
			
			if(eventType=='clipping'){
				this.openTailoring('face');
				for(let i in list){
					this.clippingImageUrl='?a=images&uniqueId='+list[i].uniqueId;
				}
			}else if(eventType=='editor'){
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
			console.log(eventType)
			if(eventType=='face'){
				this.form.face=uniqueId;
				this.articleFaceUrl='?a=images&uniqueId='+uniqueId;
			}else if(eventType=='editorClipping'){
				this.editorImg.src='?a=images&uniqueId='+uniqueId;
				this.editorImg.style.width='auto';
				this.editorImg.style.height='auto';
			}
			
		},
		async postAddBrand(){
			
			let form=this.form;
			form.content = this.editor.txt.html()
			form.content = form.content.replace(/<br>/gm, '&#10;')
			if(form.title==''){
				this.$notify({title:'提示',message: '请输入标题',type: 'warning'});
		        return ;
			}
			if(form.nav==null){
				this.$notify({title:'提示',message: '请选择导航',type: 'warning'});
		        return ;
			}
			if(form.label.length<=0){
				this.$notify({title:'提示',message: '请选择标签',type: 'warning'});
		        return ;
			}
			if(form.keyword==''){
				this.$notify({title:'提示',message: '请填写关键字',type: 'warning'});
		        return ;
			}
			if(form.face==''){
				this.$notify({title:'提示',message: '请选择封面',type: 'warning'});
		        return ;
			}
			if(form.content==''){
				this.$notify({title:'提示',message: '请写内容',type: 'warning'});
		        return ;
			}
			if(form.info==''){
				form.info=this.editor.txt.text().substr(0,150);
			}
			this.addArticleBth=false;
			form.label=form.label.join(',');
			let id = form.id;
			let data = new FormData();
			for(let i in form){
				data.append(i,form[i]);
			}
			data.append('disabled',form.disabled ? 1 : 0);
			delete form.id
			let res = await axios.post('?a=AdminAjax&m=editArticle&id='+id,data,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}});

			if(res.data.state=='succ'){
				this.$notify({
		          title: '提示',
		          message: res.data.info,
		          type: 'success',
		          duration: 0
		        });
				setTimeout(()=>{
					window.removeEventListener('beforeunload',beforeunloadFN);

					let query = Url();
					query['page'] = query['page']==undefined ? 1 : query['page'];
					window.location.href="?a=article&page="+query['page']
				},1000)
			}else {
				this.addArticleBth=true;
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
		    this.openGallery('editor');
		   // this.editor.cmd.do('insertHTML', `<img src="http://pic32.nipic.com/20130823/13339320_183302468194_2.jpg" style="max-width:100%;"/>`)
		})
		
		

		this.editor.txt.html(this.form.content);
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

	},
	async created(){
		let query=Url();
		let res = await axios.get('?a=AdminAjax&m=getArticleOne',{
			params:{
				id:query['id']
			}
		});
		let data=res.data;
		if(data.state=='succ'){
			for(let i in data.data){
				this.form[i]=data.data[i]
			}
		}
		this.form.label=this.form.label.split(',');
		this.form.nav=parseInt(this.form.nav);
		this.form.flagComment=parseInt(this.form.flagComment);
		this.form.source=parseInt(this.form.source);
		this.articleFaceUrl='?a=images&uniqueId='+this.form.face;
		this.form.disabled=(this.form.disabled==1 ? true : false);
		this.editor.txt.html(this.form.content);
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

























