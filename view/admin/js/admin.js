



let side_menu = document.querySelectorAll('.side-menu li a');



for(let i=0;i<side_menu.length;i++){
	(function(j){
		side_menu[j].onclick=function(){
			for(let k=0;k<side_menu.length;k++){
				side_menu[k].classList.remove('active');
			}
			this.classList.add('active');
		}
	})(i)
}


