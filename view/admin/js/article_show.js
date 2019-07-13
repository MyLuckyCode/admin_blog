




new Vue({
	el:'.title',
	data:{

	},
	methods:{
		goAdd(){
			//window.open("?a=article&m=add"); 
			window.location.href="?a=article&m=add"
		}
	}

})




new Vue({
	el:'.content',
	data:{
		searchContent:''
	},
	methods:{
		 deleteArticle(id){
			this.$confirm('此操作将永久删除该信息, 是否继续?', '提示', {
		        confirmButtonText: '确定',
		        cancelButtonText: '取消',
		        type: 'warning'
		    }).then(async () => {
		    	let res = await axios.get('./api/admin/v1.0/?a=article&m=deleteArticle',{
		    		params:{id}
		    	})
		    	if(res.data.state=='succ'){
		    		window.location.reload();
		    	}else {
		    		this.$notify.error({
				        title: '错误',
				        message: res.data.info
				    });
		    	}
		    	

	        });
		},
		async focusArticle(id){
			let res = await axios.get('./api/admin/v1.0/?a=article&m=setArticleFocus',{
		    		params:{id}
		    	})
			console.log(res)
			if(res.data.state=='succ'){
		    		window.location.reload();
		    	}else {
		    		this.$notify.error({
				        title: '错误',
				        message: res.data.info
				    });
		    	}
		},
		async setDisabled(id,value){
			let res = await axios.get('./api/admin/v1.0/?a=article&m=setArticleDisabled',{
		    		params:{id,value}
		    	})

			if(res.data.state=='succ'){
		    		window.location.reload();
		    	}else {
		    		this.$notify.error({
				        title: '错误',
				        message: res.data.info
				    });
		    	}
		},
		async setRoof(id,value){
			let res = await axios.get('./api/admin/v1.0/?a=article&m=setArticleRoof',{
		    		params:{id,value}
		    	})

			if(res.data.state=='succ'){
		    		window.location.reload();
		    	}else {
		    		this.$notify.error({
				        title: '错误',
				        message: res.data.info
				    });
		    	}
		},
		async setFlagComment(id,value){
			let res = await axios.get('./api/admin/v1.0/?a=article&m=setArticleFlagComment',{
		    		params:{id,value}
		    	})
			if(res.data.state=='succ'){
		    		window.location.reload();
		    	}else {
		    		this.$notify.error({
				        title: '错误',
				        message: res.data.info
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
		goSearch(){
			if(this.searchContent=='' || this.searchContent.split(' ').join("")=='') return false;
			window.location.href="?a=article&s="+this.searchContent;
		}
	},
	created(){
		let query = Url();
		if(decodeURI(query['s']) != 'undefined'){
			this.searchContent=decodeURI(query['s']);
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




























