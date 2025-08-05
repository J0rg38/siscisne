// JavaScript Document



function creaAjax(){
         var objetoAjax=false;
         try {
         // Para navegadores distintos a internet explorer
          objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
          try {
                 // Para explorer
                   objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
                   }
                   catch (E) {
                   objetoAjax = false;
          }
         }

         if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
          objetoAjax = new XMLHttpRequest();
         }
         return objetoAjax;
}


function AjaxSesion (url,capa,valores){
	 
          var ajaxxx=creaAjax();
          var capaContenedora = document.getElementById(capa);


			ajaxxx.open ('POST', url, true);
         ajaxxx.onreadystatechange = function() {
         if (ajaxxx.readyState==1) {
			capaContenedora.innerHTML='<table width="100%" height="100%"><tr><td align="center" valign="middle"><img src="imagenes/cargar.gif"></td></tr></table>';
         }
         else if (ajaxxx.readyState==4){
                   if(ajaxxx.status==200)
                   {
                        document.getElementById(capa).innerHTML=ajaxxx.responseText;						
						
                   }
                   else if(ajaxxx.status==404)
                                             {

                            capaContenedora.innerHTML = "La direccion no existe";
                                             }
                           else
                                             {
                            capaContenedora.innerHTML = "Error: " + ajaxxx.status;
                                             }
                                    }
                  }
         ajaxxx.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
         ajaxxx.send(valores);
         return;


} 



function AjaxSesionRenovar (url,capa){
	 
          var ajaxxx=creaAjax();
          var capaContenedora = document.getElementById(capa);

		ajaxxx.open ('POST', url, true);
         ajaxxx.onreadystatechange = function() {
         if (ajaxxx.readyState==1) {
			capaContenedora.innerHTML='Renovando sesion por inactividad...';
         }
         else if (ajaxxx.readyState==4){
                   if(ajaxxx.status==200)
                   {

                        document.getElementById(capa).innerHTML="Sesion renovada";
						//setTimeout('document.getElementById(capa).innerHTML="";',2000);
						
                   }
                   else if(ajaxxx.status==404)
                                             {

                            capaContenedora.innerHTML = "La direccion no existe";
                                             }
                           else
                                             {
                            capaContenedora.innerHTML = "Error: " + ajaxxx.status;
                                             }
                                    }
                  }
         ajaxxx.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
         ajaxxx.send("a=a");
         return;


} 