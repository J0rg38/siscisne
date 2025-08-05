// JavaScript Document



var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";
var FichaIngresoTipo = "";
var ModalidadIngreso = "";
var VehiculoMarca = "";


var Orden = "";
var Sentido = "";

var Variables = "";

function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	Sucursal = $("#CmpSucursal").val();
	Filtro = $("#CmpFiltro").val();
	
	Orden = $("#CmpOrden").val();
	Sentido = $("#CmpSentido").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpSucursal="+Sucursal+"&CmpFiltro="+Filtro+"&CmpFichaIngresoTipo="+FichaIngresoTipo+"&CmpModalidadIngreso="+ModalidadIngreso+"&CmpVehiculoMarca="+VehiculoMarca+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
}




function FncValidar(){
	
	var respuesta = true
	
	FncObtenerVariables();
	
	/*if(Moneda==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpMoneda").focus();
				}
			});
			
		respuesta = false;
			
	}else */if(FechaInicio==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una fecha de inicio.",
				callback: function(result){
					$("#CmpFechaInicio").focus();
				}
			});	respuesta = false;		
		
	}else if(FechaFin==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una fecha fin.",
				callback: function(result){
					$("#CmpFechaFin").focus();
				}
			});	respuesta = false;

	}
	
	return respuesta;
	
}




$().ready(function() {

	$('#BtnVer').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoConsolidadoVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoConsolidadoImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoConsolidadoGenerarExcel('');
		}
	});

});





function FncReporteFichaIngresoConsolidadoImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteFichaIngresoConsolidadoGenerarExcel(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteFichaIngresoConsolidadoVer(oIndice){
	
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).submit();
	
}

//
//
//function FncReporteFichaIngresoConsolidadoImprimir(oIndice){
//	var Accion = document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action;
//	
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).submit();
//	
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = 'IfrReporteFichaIngresoConsolidado'+oIndice;
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion;
//	
//}
//
//function FncReporteFichaIngresoConsolidadoGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action;
//	
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).submit();
//	
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = 'IfrReporteFichaIngresoConsolidado'+oIndice;
//	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion;
//	
//}
//
//
//
//function FncReporteFichaIngresoConsolidadoNuevo(){
//
//
//	
//				
//}
//
//
//
/*
//*** EVENTOS
*/

$().ready(function() {

/*
//* EVENTOS - INICIALES
*/
	$("select#CmpVehiculoMarca").change(function(){
		//FncVehiculoModelosCargar();
	});

	
});


