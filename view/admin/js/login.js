








let form=document.querySelector('#form');
console.log(form.user.value)



form.send.onclick=function(){
	if(form.user.value=='' || form.pass.value==''){
		document.querySelector('.info').style.display='block';
		return false;
	}
	form.submit();
}























