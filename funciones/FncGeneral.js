
var ImagenAjaxCargar = '<table width="100%" height="100%"><tr><td align="center"><img src="imagenes/cargar.gif" border="0"></td></tr></table>';
var ImagenGuardadoSi = "<img src='imagenes/estado/estado_guardado_si.png' width='25' height='25' >";
var ImagenGuardadoNo = "<img src='imagenes/estado/estado_guardado_si.png' width='25' height='25' >";
var ImagenGuardadoError = "<img src='imagenes/estado/estado_guardado_error.png' width='25' height='25' >";
var ImagenGuardadoCargando = "<img src='imagenes/estado/cargando_accion.gif' width='25' height='25' >";


//ValidarEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/;
ValidarEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
ValidarNumero = /^([0-9])*$/;
 
 
   function convertDateFormat(string) {
        var info = string.split('/').reverse().join('-');
        return info;
   }
   
   
   
function FncSumarDias(fecha, dias){
	
	var fecha2 =  convertDateFormat(fecha)
	var tomorrow = new Date();
	
	console.log("fecha: "+fecha);
	console.log("fecha2: "+fecha2);
	
	console.log("dias: "+dias);
	//
//	var ms = Date.parse(fecha2);
//	
//	console.log("ms: "+ms);
	
	var nfecha = new Date(fecha2);
	
	console.log("nfecha1: "+nfecha );
	
	
	
tomorrow.setDate(nfecha.getDate() + parseInt(dias)+1);
//	
console.log("tomorrow: "+tomorrow);
//	

	
	//var dt = new Date(fecha);
//
//	dt.setDate(dt.getDate() + dias);
//	
//	
	
	
//var st = fecha;
//var pattern = /(\d{2})\/(\d{2})\/(\d{4})/;
//
//var dt = new Date(st.replace(pattern,'$3-$2-$1'));
//
//var fechahoy =dt.toLocaleFormat('%d/%m/%Y'); //30-Dec-2011
//
//
//console.log("a"+fechahoy);
//
//
//
//dt.setDate(dt.getDate() + dias);
//
//console.log("FncSumarDias");
//
//console.log("b"+dt);
  
  
  

var day = tomorrow.getDate();
var month = tomorrow.getMonth()+1;
var year = tomorrow.getFullYear();

var nnfecha  = day + '/' + month + '/' + year;


console.log("nnfecha: "+nnfecha);

  return nnfecha;
}

function FncValidarFecha(Cadena){  
 	
	if(Cadena=="00/00/0000"){
		  var validador = false;
	}else{
		
			
		
		 var Fecha= new String(Cadena)   // Crea un string  
		 var RealFecha= new Date()   // Para sacar la fecha de hoy  
		 // Cadena Año  
		var Ano= new String(Fecha.substring(Fecha.lastIndexOf("/")+1,Fecha.length))  
		 // Cadena Mes  
		 var Mes= new String(Fecha.substring(Fecha.indexOf("/")+1,Fecha.lastIndexOf("/")))  
		 // Cadena Día  
		 var Dia= new String(Fecha.substring(0,Fecha.indexOf("/")))  
	   
	   var validador = true;
	   
		 // Valido el año  
		 if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){  
			 //alert('Año inválido')  
			 validador = false;
			 //return false  
		 }  
		 // Valido el Mes  
		 if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){  
			 //alert('Mes inválido')  
			validador = false;
			// return false  
		 }  
		 // Valido el Dia  
		 if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){  
			 //alert('Día inválido')  
			 validador = false;
			 //return false  
		 }  
		 if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
	
			 if (Mes==2 && Dia > 29 || Dia>30) {  
				 //alert('Día inválido')  
				// return false  
				validador = false;
			 }  
		 }  
		 
	}
	
       
   //para que envie los datos, quitar las  2 lineas siguientes  
  // alert("Fecha correcta.")  
   return validador    
}  

function FncValidarCelular(val) {
	
	console.log("FncValidarCelular");
	
	var respuesta = false;
	
	if(ValidarNumero.test(val)==true){
		if(val.length>=9){
			respuesta = true;
		}
		
		if(val=="000000000"){
			respuesta = false;
		}
		
		if(val.slice(0, 1)!="9"){
			respuesta = false;
		}
		
		
	
	}
	
	
	
	return respuesta;
	
	
}

function FncValidarTelefono(val) {
	
	console.log("FncValidarTelefono");
	
	var respuesta = false;
	
	if(ValidarNumero.test(val)==true){
		if(val.length>=8){
			respuesta = true;
		}
	}
	
	return respuesta;
}

function FncValidarEmail(oval) {

	console.log("FncValidarEmail4");
	
	var respuesta2 = false;
	
	if(ValidarEmail.test(oval)){
		respuesta2 = true;
	}
	
	if(oval=="notiene@correo.com"){
			respuesta2 = false;
	}
	
	if(oval=="notiene@hotmail.com"){
			respuesta2 = false;
	}
	
	if(oval=="notiene@gmail.com"){
			respuesta2 = false;
	}
	
	return respuesta2;
}

//function IsNumeric(val) {
//    //return Number(parseFloat(val)) === val;
//	
//	var respuesta = false;
//	
//	if(isNaN(val)){
//		respuesta = true;
//	}
//
//	return respuesta;
//	
//}

function JnObjeto(valor, dato) {
    this.Valor = valor;
    this.Dato = dato;
 
}

//runOnLoad(Dropdown.initialise);



function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}



  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }



//jQuery.fn.rotate = function(degrees) {
//    $(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
//                 '-moz-transform' : 'rotate('+ degrees +'deg)',
//                 '-ms-transform' : 'rotate('+ degrees +'deg)',
//                 'transform' : 'rotate('+ degrees +'deg)'});
//};



/*
 * Url preview script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */
 
this.screenshotPreview = function(){	
	$("img.tooltip").thumbPopup({
	  imgSmallFlag: "_thumb2",
	  imgLargeFlag: "_thumb"
	});
};



function FncImprimirObjeto(o) {
  var out = '';
  for (var p in o) {
    out += p + ': ' + o[p] + '\n';
  }
  alert(out);
}


var nav4 = window.Event ? true : false;


$().ready(function() {

	$('.EstFormularioCajaFecha').keypress(function(e) {
	
		var code = (e.keyCode ? e.keyCode : e.which);
	
		if(code!==8){
			var Fecha = $(this).val();
			if($(this).val().length=="2"){
				$(this).val(Fecha + "/");
			}else if ($(this).val().length=="5"){
				$(this).val(Fecha + "/");
			}
		}
	
	});
	
	
	$('.EstFormularioCajaHora').keypress(function(e) {
	
		var code = (e.keyCode ? e.keyCode : e.which);
		
		if(code!==8){
			var Hora = $(this).val();
			if($(this).val().length=="2"){
				$(this).val(Hora + ":");
			}else if ($(this).val().length=="5"){
				$(this).val(Hora + ":");
			}
		}
	
	});
	
	//$('.EstFormularioSoloNumero').keypress(function(e) {
//
//		IsNumber(e);
//
//	});	

});

//function IsNumber(evt){
//
//	var key = nav4 ? evt.which : evt.keyCode;
//
//	alert(key);
//	if((key <= 13 || (key >= 48 && key <= 57) || key == 46)){
//		return false;
//	}else{
//		return false;
//	}
//	return false;
//}



//
//function FncSoloNumeros(evt){
//alert("xd");
//		var code = (evt.which) ? evt.which : evt.keyCode;
//        if(code==8)
//        {
//            //backspace
//            return true;
//        }
//        else if(code>=48 && code<=57)
//        {
//            //is a number
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//
//
//
////	var keynum = window.event ? window.event.keyCode : e.which;
////	alert(keynum);
////	if ((keynum == 8) || (keynum == 46))
////	return true;
////	return /\d/.test(String.fromCharCode(keynum));
//
//}

//function FncCargarVentanaLink(oUrl){
//	
//	//var Ancho = $( document ).width();
//	var Ancho = $( window ).width();
//	var Alto = $( window ).height();
//	
//	//var Alto = 620;
//	
//	Ancho = Ancho - (Ancho*(0.2));
//	Alto = Alto - (Alto*(0.1));
//	//Ancho = 800;
//	//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);		
//	
//	tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true',this.rel);		
//	
//	
//}

//
//function FncCargarVentanaNuevo(oRuta,oIframe,oModal,oTitulo){
//	
//	//var Ancho = $( document ).width();
//	var Ancho = $( window ).width();
//	var Alto = $( window ).height();
//	
//	//var Alto = 620;
//	
//	Ancho = Ancho - (Ancho*(0.2));
//	Alto = Alto - (Alto*(0.1));
//	//Ancho = 800;
//	//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);		
//	
//	//'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true'
//	
//	tb_show(oTitulo,oRuta+'&placeValuesBeforeTB_=savedValues&TB_iframe='+oIframe+'&width='+Ancho+'&height='+Alto+'&modal='+oModal,'');		
//	//tb_show(oTitulo,oRuta+'&placeValuesBeforeTB_=savedValues&width='+Ancho+'&height='+Alto,'');		
//	
//	//tb_show(oTitulo,oRuta+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=800&modal=true',this.rel);
//}


function isDate(string) { 
        var ExpReg = /^([0][1-9]|[12][0-9]|3[01])(\/|-)([0][1-9]|[1][0-2])\2(\d{4})$/
        return (ExpReg.test(string));
       }
	   
	   
function FncCargarVentana(oMod,oForm,Id){
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	var Alto = $( window ).height();
	
	//var Alto = 620;
	
	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.1));
	//Ancho = 800;
	//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);		
	
	tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true',this.rel);	
	//console.log('principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true');	
	
	
}

function FncCargarVentanaFull(oMod,oForm,oVariables){
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	var Alto = $( window ).height();
	
	//var Alto = 620;
	
	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.1));
	//Ancho = 800;
	//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);		
	
	tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&'+oVariables+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true',this.rel);		
	//console.log('principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&'+oVariables+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true');
	
}










function FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	
	var Ancho = $( window ).width();
	var Alto = $( window ).height();
	
	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.1));
	
	switch(oModo){
		
		case "Simple":
		
			tb_show("",oRuta+'?height='+Alto+'&width='+Ancho+'&'+oVariables,"");	
			//formularios/TallerPedido/DiaAlmacenMovimientoListado.php?height=440&width=850&FinId=<?php echo $dat->FinId?>
		break;
		
		case "Avanzado":
		
			tb_show(oTitulo,oRuta+'&'+oVariables+'&placeValuesBeforeTB_='+oValues+'&TB_iframe='+oIframe+'&width='+Ancho+'&height='+Alto+'&modal='+oModal,'');	
			//console.log(oRuta+'&'+Variables+'&placeValuesBeforeTB_='+oValues+'&TB_iframe='+oIframe+'&width='+Ancho+'&height='+Alto+'&modal='+oModal);
			
			//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true',this.rel);		
	
	
		break;
		
	}
	
	//tb_show("",'formularios/AlmacenStock/DiaProductoReemplazoBuscar.php?height=440&width=850&ProductoCodigoOriginal='+oProductoCodigoOriginal,"");		
	//console.log(oRuta+'&placeValuesBeforeTB_='+oValues+'&TB_iframe='+oIframe+'&width='+Ancho+'&height='+Alto+'&modal='+oModal);
}

function FncCargarVentanaFullv3(oRaiz,oMod,oForm,oVariables){
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	var Alto = $( window ).height();
	
	//var Alto = 620;
	
	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.1));
	//Ancho = 800;
	//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);		
	
	tb_show(this.title,oRaiz+'.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&'+oVariables+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true',this.rel);		
	//console.log('principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&'+oVariables+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true');
	
}


function FncVisualizarArchivo(oArchivo){
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	var Alto = $( window ).height();
	
	//var Alto = 620;
	
	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.1));
	//Ancho = 800;
	//tb_show(this.title,'principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&Id='+Id+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);		
	
	tb_show("",oArchivo+'?placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=false',"");		
	//console.log('principal2.php?Mod='+oMod+'&Form='+oForm+'&Dia=1&'+oVariables+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width='+Ancho+'&height='+Alto+'&modal=true');
	
}


function FncLimpiarAutocompletar(){
	$("<div id='CapAutoCompletar' />").html('');	
}

function FncDesactivarEnter(){
	document.onkeypress=function(e){
	var esIE=(document.all);
	var esNS=(document.layers);
	tecla=(esIE) ? event.keyCode : e.which;
		if(tecla==13){
			return false;
		}
	}	
}
 function FncValidarFechaNormal(Cadena){  
 
     var Fecha= new String(Cadena)   // Crea un string  
     var RealFecha= new Date()   // Para sacar la fecha de hoy  
     // Cadena Año  
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("/")+1,Fecha.length))  
     // Cadena Mes  
     var Mes= new String(Fecha.substring(Fecha.indexOf("/")+1,Fecha.lastIndexOf("/")))  
     // Cadena Día  
     var Dia= new String(Fecha.substring(0,Fecha.indexOf("/")))  
   
   var validador = true;
   
     // Valido el año  
     if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){  
         //alert('Año inválido')  
		 validador = false;
         //return false  
     }  
     // Valido el Mes  
     if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){  
         //alert('Mes inválido')  
        validador = false;
		// return false  
     }  
     // Valido el Dia  
     if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){  
         //alert('Día inválido')  
         validador = false;
		 //return false  
     }  
     if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  

         if (Mes==2 && Dia > 29 || Dia>30) {  
             //alert('Día inválido')  
            // return false  
			validador = false;
         }  
     }  
       
   //para que envie los datos, quitar las  2 lineas siguientes  
  // alert("Fecha correcta.")  
   return validador    
}  

<!-- Se abre el comentario para ocultar el script de navegadores antiguos
function lTrim(sStr){
	while (sStr.charAt(0) == " ")
	sStr = sStr.substr(1, sStr.length - 1);
	return sStr;
}

function rTrim(sStr){
	while (sStr.charAt(sStr.length - 1) == " ")
	sStr = sStr.substr(0, sStr.length - 1);
	return sStr;
}

function aTrim(sStr){
	return rTrim(lTrim(sStr));
}

function FncReloj(){
// Compruebo si se puede ejecutar el script en el navegador del usuario
if (!document.layers && !document.all && !document.getElementById) return;
// Obtengo la hora actual y la divido en sus partes
var fechacompleta = new Date();
var horas = fechacompleta.getHours();
var minutos = fechacompleta.getMinutes();
var segundos = fechacompleta.getSeconds();
var mt = "AM";
// Pongo el formato 12 horas
if (horas > 12) {
mt = "PM";
horas = horas - 12;
}
if (horas == 0) horas = 12;
// Pongo minutos y segundos con dos dígitos
if (minutos <= 9) minutos = "0" + minutos;
if (segundos <= 9) segundos = "0" + segundos;
// En la variable 'cadenareloj' puedes cambiar los colores y el tipo de fuente
cadenareloj = horas + ":" + minutos + ":" + segundos + " " + mt;
//cadenareloj = "<font size='2' face='verdana' >" + horas + ":" + minutos + ":" + segundos + " " + mt + "</font>";
// Escribo el reloj de una manera u otra, según el navegador del usuario
if (document.layers) {
document.layers.spanreloj.document.write(cadenareloj);
document.layers.spanreloj.document.close();
}
else if (document.all) spanreloj.innerHTML = cadenareloj;
else if (document.getElementById) document.getElementById("spanreloj").innerHTML = cadenareloj;
// Ejecuto la función con un intervalo de un segundo
setTimeout("FncReloj()", 1000);
}

// Fin del script -->



function FncPopUp(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
	
	var izquierda = (screen.width/2)-(ancho/2);
var arriba = (screen.height/2)-(alto/2);

     var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;
     var ventana = window.open(direccion,"venta",opciones,sustituir);
if (window.focus) {
		ventana.focus()
	}
	if (!ventana.closed) {
		ventana.focus()
	}
}                    


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


 function Ajax(url,capa,valores,funcion){
	 
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
						if(funcion!=""){
							eval(funcion);
						}
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

