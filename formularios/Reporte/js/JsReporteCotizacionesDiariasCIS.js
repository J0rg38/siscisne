// JavaScript Document

var Ventas = "1";

var Sucursal = "";
var Personal = "";
var FechaInicio = "";
var FechaFin = "";
var Orden = "";
var Sentido = "";

var Variables = "";

function FncObtenerVariables(){

	 Sucursal = $("#CmpSucursal").val();
	 Personal = $("#CmpPersonal").val();
	 FechaInicio = $("#CmpFechaInicio").val();
	 FechaFin = $("#CmpFechaFin").val();
	 Orden = $("#CmpOrden").val();
	 Sentido = $("#CmpSentido").val();
	
	Variables = "CmpSucursal="+Sucursal+"&CmpPersonal="+Personal+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
}

function FncValidar(){
	
	var respuesta = true
	
	FncObtenerVariables();
	
	if(Sucursal==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una sucursal.",
				callback: function(result){
					$("#CmpSucursal").focus();
				}
			});
			
		respuesta = false;
			
	}else if(FechaInicio==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado una fecha de inicio.",
				callback: function(result){
					$("#CmpFechaInicio").focus();
				}
			});	
			
		respuesta = false;		
		
	}else if(FechaFin==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado una fecha fin.",
				callback: function(result){
					$("#CmpFechaFin").focus();
				}
			});	
			
		respuesta = false;

	}
	
	return respuesta;
	
}




$().ready(function() {



	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncReporteCotizacionesDiariasCISVer('');
		}
		
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncReporteCotizacionesDiariasCISImprimir('');
		}
		
	});
	
	$('#BtnExcel').click(function(e) {
		if(FncValidar()){
			FncReporteCotizacionesDiariasCISGenerarExcel('');
		}
	});
	
	
	
	
	
//
});





function FncReporteCotizacionesDiariasCISImprimir(oIndice){
		
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncReporteCotizacionesDiariasCISGenerarExcel(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncReporteCotizacionesDiariasCISVer(oIndice){
	
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).submit();
	
}


/*

function FncReporteCotizacionesDiariasCISVer(){
	
doIframe();
	
}

function FncReporteCotizacionesDiariasCISImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action;
	
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).submit();
	
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).target = 'IfrReporteCotizacionesDiariasCIS'+oIndice;
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action = Accion;
	
}

function FncReporteCotizacionesDiariasCISGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action;
	
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).submit();
	
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).target = 'IfrReporteCotizacionesDiariasCIS'+oIndice;
	document.getElementById('FrmReporteCotizacionesDiariasCIS'+oIndice).action = Accion;
	
}



function FncReporteCotizacionesDiariasCISNuevo(){


	
				
}*/


/*
function FncAgregarSeleccionado(){

	var indice = 0;
	//alert(":3");
	$('input[type=checkbox]').each(function () {
		if($(this).attr('name')=="cmp_seleccionar[]"){
			//alert(":33");
			if($(this).is(':checked')){
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');				
			}
		}
		indice = indice + 1;
	});
	
	
}

*/

$().ready(function() {	

	$("select#CmpSucursal").change(function(){
	
		FncPersonalesCargar();	
		
	});
	
});	

