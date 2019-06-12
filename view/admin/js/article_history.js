






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
		articleFaceUrl:''
	},
	methods:{
		
	},
	mounted(){
		let E=window.wangEditor;
		this.editor = new E('.content');

		this.editor.create();


		

		this.editor.txt.html(this.form.content);

	},
	async created(){
		let query=Url();
		let res = await axios.get('?a=AdminAjax&m=getArticleHistoryOne',{
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

























