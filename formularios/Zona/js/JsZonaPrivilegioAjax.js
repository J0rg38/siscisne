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


function AjaxGastoDocumento (url,capa,valores){
	 
          var ajax=creaAjax();
          var capaContenedora = document.getElementById(capa);

			ajax.open ('POST', url, true);
         ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
			capaContenedora.innerHTML='<table width="100%" height="100%"><tr><td align="center" valign="middle"><img src="imagenes/cargar.gif"></td></tr></table>';
         }
         else if (ajax.readyState==4){
                   if(ajax.status==200)
                   {
		
						document.getElementById(capa).innerHTML=ajax.responseText;
						document.getElementById('CapGastoDocumentoAccion').innerHTML = "Listo";
						
						FncGastoDocumentoListar();
						
                   }
                   else if(ajax.status==404)
                                             {

                            capaContenedora.innerHTML = "La direccion no existe";
                                             }
                           else
                                             {
                            capaContenedora.innerHTML = "Error: " + ajax.status;
                                             }
                                    }
                  }
         ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
         ajax.send(valores);
         return;


} 



function AjaxGastoDocumentoListar (url,capa,valores){
	 
          var ajax=creaAjax();
          var capaContenedora = document.getElementById(capa);

			ajax.open ('POST', url, true);
         ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
			capaContenedora.innerHTML='<table width="100%" height="100%"><tr><td align="center" valign="middle"><img src="imagenes/cargar.gif"></td></tr></table>';
         }
         else if (ajax.readyState==4){
                   if(ajax.status==200)
                   {
		
						document.getElementById(capa).innerHTML=ajax.responseText;
						document.getElementById('CapGastoDocumentoAccion').innerHTML = "Listo";
						
                   }
                   else if(ajax.status==404)
                                             {

                            capaContenedora.innerHTML = "La direccion no existe";
                                             }
                           else
                                             {
                            capaContenedora.innerHTML = "Error: " + ajax.status;
                                             }
                                    }
                  }
         ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
         ajax.send(valores);
         return;


} 



function AjaxGastoDocumentoEliminar (url,capa,valores){
	 
          var ajax=creaAjax();
          var capaContenedora = document.getElementById(capa);

			ajax.open ('POST', url, true);
         ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
			capaContenedora.innerHTML='<table width="100%" height="100%"><tr><td align="center" valign="middle"><img src="imagenes/cargar.gif"></td></tr></table>';
         }
         else if (ajax.readyState==4){
                   if(ajax.status==200)
                   {
		
					document.getElementById(capa).innerHTML='';
					document.getElementById('CapGastoDocumentoAccion').innerHTML = "Eliminado";
	
					FncGastoDocumentoListar();
					
                   }
                   else if(ajax.status==404)
                                             {

                            capaContenedora.innerHTML = "La direccion no existe";
                                             }
                           else
                                             {
                            capaContenedora.innerHTML = "Error: " + ajax.status;
                                             }
                                    }
                  }
         ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
         ajax.send(valores);
         return;


} 