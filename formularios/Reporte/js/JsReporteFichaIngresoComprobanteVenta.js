// JavaScript Document
var Taller = "1";



var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";

var Filtro = "";

var Modalidad = "";
var VehiculoMarca = "";
var VehiculoModelo = "";

var Personal = "";

var Orden = "";
var Sentido = "";

var Variables = "";
 
 
	
function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	Sucursal = $("#CmpSucursal").val();
	
	Filtro = $("#CmpFiltro").val();
	
	Modalidad = $("#CmpModalidad").val();
	VehiculoMarca = $("#CmpVehiculoMarca").val();
	VehiculoModelo = $("#CmpVehiculoModelo").val();
	
	Personal = $("#CmpPersonal").val();
	 
	Orden = $("#CmpOrden").val();
	Sentido = $("#CmpSentido").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpSucursal="+Sucursal+"&CmpFiltro="+Filtro+"&CmpModalidad="+Modalidad+"&CmpVehiculoMarca="+VehiculoMarca+"&CmpVehiculoModelo="+VehiculoModelo+"&CmpPersonal="+Personal+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
}





function FncValidar(){
	
	var respuesta = true
	
	FncObtenerVariables();
	
	if(FechaInicio==""){
	
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
			FncReporteFichaIngresoComprobanteVentaVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoComprobanteVentaImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoComprobanteVentaGenerarExcel('');
		}
	});
	
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	 
	Ancho = Ancho - (Ancho*(0.08));
	 
	$('.EstReporteCapaListado').width(Ancho);
	
	
	
	
//
});





function FncReporteFichaIngresoComprobanteVentaImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteFichaIngresoComprobanteVentaGenerarExcel(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion =  "formularios/Reporte/XLSReporteFichaIngresoComprobanteVenta.php";
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
	
}

function FncReporteFichaIngresoComprobanteVentaVer(oIndice){
	
	
	 
		
		FncObtenerVariables();
		
		$('#CapReporteFichaIngresoComprobanteVenta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteFichaIngresoComprobanteVenta.php',
			//data: "Moneda="+Moneda+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Orden="+Orden+"&Sentido="+Sentido+"&ClienteNumeroDocumento="+ClienteNumeroDocumento+"&ClienteNombre="+ClienteNombre+"&ClienteId="+ClienteId,
			data: Variables,
			
			success: function(html){
				$('#CapReporteFichaIngresoComprobanteVenta').html(html);	
			}
		});

	 
}




//
//
//function FncReporteFichaIngresoComprobanteVentaValidar(){
//	
//	var respuesta = true
//	
//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//	
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var VehiculoModelo = $("#CmpVehiculoModelo").val();
//	
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//	if(FechaInicio==""){
//		alert("No ha escogido una fecha de inicio.");
//		respuesta = false;
//	}else if(FechaFin==""){
//		alert("No ha escogido una fecha fin.");
//		respuesta = false;
//	
//	}
//	
//	return respuesta;
//	
//}
//
//function FncReporteFichaIngresoComprobanteVentaVer(){
//	
//	if(FncReporteFichaIngresoComprobanteVentaValidar()){
//		
//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//			
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var VehiculoModelo = $("#CmpVehiculoModelo").val();
//	
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//		$('#CapReporteFichaIngresoComprobanteVenta').html("Cargando...");	
//		
//		$.ajax({
//			type: 'GET',
//			url: 'formularios/Reporte/IfrReporteFichaIngresoComprobanteVenta.php',
//			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Modalidad="+Modalidad+"&VehiculoMarca="+VehiculoMarca+"&VehiculoModelo="+VehiculoModelo+"&Personal="+Personal+"&Orden="+Orden+"&Sentido="+Sentido,
//			success: function(html){
//				$('#CapReporteFichaIngresoComprobanteVenta').html(html);	
//			}
//		});
//
//	}
//
//}
//
//function FncReporteFichaIngresoComprobanteVentaImprimir(){
//	
//	if(FncReporteFichaIngresoComprobanteVentaValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		
//			
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var VehiculoModelo = $("#CmpVehiculoModelo").val();
//	
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//		FncPopUp("formularios/Reporte/IfrReporteFichaIngresoComprobanteVenta.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Modalidad="+Modalidad+"&VehiculoMarca="+VehiculoMarca+"&VehiculoModelo="+VehiculoModelo+"&Personal="+Personal+"&Orden="+Orden+"&Sentido="+Sentido+"&P=1");
//		
//	}
//
//}
//
//function FncReporteFichaIngresoComprobanteVentaGenerarExcel(){
//	
//	if(FncReporteFichaIngresoComprobanteVentaValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Moneda = "";
//		var Sucursal = $("#CmpSucursal").val();
//		
//			
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var VehiculoModelo = $("#CmpVehiculoModelo").val();
//	
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//		FncPopUp("formularios/Reporte/XLSReporteFichaIngresoComprobanteVenta.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Modalidad="+Modalidad+"&VehiculoMarca="+VehiculoMarca+"&VehiculoModelo="+VehiculoModelo+"&Personal="+Personal+"&Orden="+Orden+"&Sentido="+Sentido+"&P=2");
//		
//	}
//	
//}
//
//function FncReporteFichaIngresoComprobanteVentaNuevo(){
//
//}

 //
//
///*
//* Funciones complementarias
//*/
//$().ready(function() {
//
//	$('#BtnVer').on('click', function() {
//	
//		FncReporteFichaIngresoComprobanteVentaVer();
//	
//	});
//	
//	$('#BtnImprimir').on('click', function() {
//	
//		FncReporteFichaIngresoComprobanteVentaImprimir();
//	
//	});
//	
//	$('#BtnExcel').on('click', function() {
//	
//		FncReporteFichaIngresoComprobanteVentaGenerarExcel();
//
//	});
//	
//	
//	$('#CmpSucursal').on('change', function() {
//	
//		FncPersonalesCargar();	
//	
//	});
//	
//
//	//var Ancho = $( document ).width();
//	var Ancho = $( window ).width();
//	 
//	Ancho = Ancho - (Ancho*(0.08));
//	 
//	$('.EstReporteCapaListado').width(Ancho);
//	
//
//
//
//
//});

