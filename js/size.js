var x=document.getElementById("container");
			var w=window.screen.availWidth ;
			var h=window.screen.availHeight;
			if(w>h){	
					x.setAttribute("style","font-size:3vw");
				}
			else{	
					x.setAttribute("style","font-size:3vh");
			}