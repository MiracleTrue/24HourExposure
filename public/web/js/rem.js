
	
				window.onload = function(){
				
			    /*720代表设计师给的设计稿的宽度，你的设计稿是多少，就写多少;100代表换算比例，这里写100是
			      为了以后好算,比如，你测量的一个宽度是100px,就可以写为1rem,以及1px=0.01rem等等*/
			    getRem(750,100);
			};
			window.onresize = function(){
			    getRem(750,100)
			};
			function getRem(pwidth,prem){
			    var html = document.getElementsByTagName("html")[0];
			    var oWidth = document.body.clientWidth || document.documentElement.clientWidth;
			    html.style.fontSize = oWidth/pwidth*prem + "px";
			}
		

  /*
        //小米官网的写法
        !function(n){
            var  e=n.document,
                 t=e.documentElement,
                 i=1125,
                 d=i/100,
                 o="orientationchange"in n?"orientationchange":"resize",
                 a=function(){
                     var n=t.clientWidth||320;n>1125&&(n=1125);
                     t.style.fontSize=n/d+"px"
                 };
                 e.addEventListener&&(n.addEventListener(o,a,!1),e.addEventListener("DOMContentLoaded",a,!1))
        }(window);*/